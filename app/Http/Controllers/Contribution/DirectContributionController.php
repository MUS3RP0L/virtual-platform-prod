<?php

namespace Muserpol\Http\Controllers\Contribution;

use Illuminate\Http\Request;
use Muserpol\Http\Requests;
use Muserpol\Http\Controllers\Controller;

use Auth;
use Validator;
use Session;
use Datatables;
use Carbon\Carbon;
use Muserpol\Helper\Util;
use Illuminate\Support\Collection;

use Muserpol\Affiliate;
use Muserpol\DirectContribution;
use Muserpol\Contribution;
use Muserpol\Category;
use Muserpol\ContributionRate;
use Muserpol\IpcRate;
use Muserpol\BaseWage;
use Muserpol\Voucher;

class DirectContributionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return view('direct_contributions.index');
    }

    public function Data(Request $request)
    {
        $direct_contributions = DirectContribution::select(['id', 'affiliate_id', 'type', 'code', 'created_at', 'total']);

        if ($request->has('code'))
        {
            $direct_contributions->where(function($direct_contributions) use ($request)
            {
                $code = trim($request->get('code'));
                $direct_contributions->where('code', 'like', "%{$code}%");
            });
        }
        if ($request->has('affiliate_name'))
        {
            $direct_contributions->where(function($direct_contributions) use ($request)
            {
                $affiliate_name = trim($request->get('affiliate_name'));
                $direct_contributions->where('affiliate_name', 'like', "%{$affiliate_name}%");
            });
        }
        if ($request->has('date'))
        {
            $direct_contributions->where(function($direct_contributions) use ($request)
            {
                $date = Util::datePick($request->get('date'));
                $direct_contributions->where('created_at', 'like', "%{$date}%");
            });
        }

        return Datatables::of($direct_contributions)
                ->addColumn('affiliate_name', function ($direct_contribution) { return $direct_contribution->affiliate->getTittleName(); })
                ->addColumn('period', function ($direct_contribution) { return $direct_contribution->period(); })
                ->addColumn('total', function ($direct_contribution) { return Util::formatMoney($direct_contribution->total); })
                ->editColumn('created_at', function ($direct_contribution) { return Util::getDateShort($direct_contribution->created_at); })
                ->addColumn('action', function ($direct_contribution) { return
                    '<div class="btn-group" style="margin:-3px 0;">
                        <a href="direct_contribution/'.$direct_contribution->id.'" class="btn btn-primary btn-raised btn-sm">&nbsp;&nbsp;<i class="glyphicon glyphicon-eye-open"></i>&nbsp;&nbsp;</a>
                        <a href="" class="btn btn-primary btn-raised btn-sm dropdown-toggle" data-toggle="dropdown">&nbsp;<span class="caret"></span>&nbsp;</a>
                        <ul class="dropdown-menu">
                            <li><a href="direct_contribution/delete/ '.$direct_contribution->id.' " style="padding:3px 10px;"><i class="glyphicon glyphicon-ban-circle"></i> Anular</a></li>
                        </ul>
                    </div>';})
                ->make(true);
    }

    public static function getViewModel($affiliate_id, $year, $category_id = null, $last_contribution = null)
    {
        $affiliate = Affiliate::idIs($affiliate_id)->first();

        $categories = Category::where('name', '<>', 'S/N')->get();
        $list_categories = array('' => '');
        foreach ($categories as $item) {
             $list_categories[$item->id]=$item->name;
        }

        $now = Carbon::now();
        $from = Carbon::parse($affiliate->date_entry);
        $to = Carbon::createFromDate($now->year, $now->month, 1)->subMonth();

        $ipc_actual = IpcRate::select('index')->where('month_year', '=',Carbon::createFromDate($now->year, $now->month, 1)->toDateString())->first();

        $months = new Collection;
        $month = array();

        for ($j=1; $j <= 12; $j++) {

            $contribution = Contribution::select(['month_year'])->where('affiliate_id', $affiliate_id)->where('month_year', '=', Carbon::createFromDate($year, $j, 1)->toDateString())->first();
            $contribution_rate = ContributionRate::where('month_year', '=', Carbon::createFromDate($year, $j, 1)->toDateString())->first();
            $ipc_rate = IpcRate::where('month_year', '=',Carbon::createFromDate($year, $j, 1)->toDateString())->first();

            if(!$contribution) {
                if ($year == $from->year) {
                    if($j >= $from->month) {
                        $month["id"] = $j;
                        $month["name"] = Util::getMes($j);
                        $month["retirement_fund"] = $contribution_rate ? $contribution_rate->retirement_fund : '0';
                        $month["mortuary_quota"] = $contribution_rate ? $contribution_rate->mortuary_quota : '0';
                        $month["ipc_rate"] = $contribution_rate ? $ipc_rate->index : '0';
                        $months->push($month);
                    }
                }
                elseif ($year == $to->year) {
                    if($j <= $to->month) {
                        $month["id"] = $j;
                        $month["name"] = Util::getMes($j);
                        $month["retirement_fund"] = $contribution_rate ? $contribution_rate->retirement_fund : '0';
                        $month["mortuary_quota"] = $contribution_rate ? $contribution_rate->mortuary_quota : '0';
                        $month["ipc_rate"] = $contribution_rate ? $ipc_rate->index : '0';
                        $months->push($month);
                    }
                }else {
                    $month["id"] = $j;
                    $month["name"] = Util::getMes($j);
                    $month["retirement_fund"] = $contribution_rate ? $contribution_rate->retirement_fund : '0';
                    $month["mortuary_quota"] = $contribution_rate ? $contribution_rate->mortuary_quota : '0';
                    $month["ipc_rate"] = $contribution_rate ? $ipc_rate->index : '0';
                    $months->push($month);
                }
            }
        }

        if (!$last_contribution) {
            $date = Carbon::createFromDate($year, $months[0]["id"], 1);
            $last_contribution = Contribution::affiliateidIs($affiliate->id)->where('month_year', '<', $date->toDateString())->first();

            if (!$last_contribution) {
                $last_contribution = new Contribution;
                $base_wage = BaseWage::whereYear('month_year', '<=', $year)->first();
                $last_contribution->base_wage = $base_wage->amount;
                $last_contribution->study_bonus = 0;
                $last_contribution->position_bonus = 0;
                $last_contribution->border_bonus = 0;
                $last_contribution->east_bonus = 0;
            }
            $last_contribution->date = Util::getDateShort($last_contribution->month_year);
        }

        if ($category_id) {
            $affiliate->category_id = $category_id;
        }

        return [

            'affiliate' => $affiliate,
            'list_categories' => $list_categories,
            'categories' => Category::where('name', '<>', 'S/N')->orderBy('id', 'asc')->get(array('percentage', 'name', 'id')),
            'ipc_actual' => $ipc_actual,
            'months' => $months,
            'year' => $year,
            'last_contribution' => $last_contribution,
            'direct_contribution' => ''
        ];
    }

    public function CalculationContribution($affiliate_id, $year, $type)
    {

        $data = [

            'type' => $type == "reintegro" ? "Reintegro" : "Normal",

        ];

        $data = array_merge($data, self::getViewModel($affiliate_id, $year));
        return view('direct_contributions.calculation', $data);
    }

    public function GenerateCalculationContribution(Request $request)
    {
        $last_contribution = new Contribution;
        $last_contribution->base_wage = $request->base_wage;
        $last_contribution->study_bonus = $request->study_bonus;
        $last_contribution->position_bonus = $request->position_bonus;
        $last_contribution->border_bonus = $request->border_bonus;
        $last_contribution->east_bonus = $request->east_bonus;
        $last_contribution->date = $request->last_contribution_date;

        $data = [

            'type' => $request->type == "reintegro" ? "Reintegro" : "Normal",

        ];

        $data = array_merge($data, self::getViewModel($request->affiliate_id, $request->year, $request->category_id, $last_contribution));
        return view('direct_contributions.calculation', $data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->save($request);
    }

    public function save($request)
    {
        $rules = [

            'affiliate_id' => 'required',

        ];

        $messages = [

            'affiliate_id.required' => 'Afiliado no disponible',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect('affiliate/'.$request->affiliate_id)
            ->withErrors($validator)
            ->withInput();
        }
        else {

            $direct_contribution = new DirectContribution;
            $data = json_decode($request->data);
            $now = Carbon::now();
            $affiliate = Affiliate::IdIs($request->affiliate_id)->first();
            $last_direct_contribution = DirectContribution::whereYear('created_at', '=', $now->year)->where('deleted_at', '=', null)->orderBy('id', 'desc')->first();
            if ($last_direct_contribution) {
                $number_code = Util::separateCode($last_direct_contribution->code);
                $code = $number_code + 1;
            }else{
                $code = 1;
            }

            $direct_contribution->code = $code . "/" . $now->year;
            $direct_contribution->user_id = Auth::user()->id;
            $direct_contribution->affiliate_id = $request->affiliate_id;
            $direct_contribution->affiliate_name = $affiliate->getTittleName();
            $direct_contribution->affiliate_degree = $affiliate->degree->name;
            $direct_contribution->affiliate_identity_card = $affiliate->identity_card;
            $direct_contribution->affiliate_registration = $affiliate->registration;
            $direct_contribution->quotable = $data->sum_quotable;
            $direct_contribution->retirement_fund = $data->sum_subtotal_retirement_fund;
            $direct_contribution->mortuary_quota = $data->sum_subtotal_mortuary_quota;
            $direct_contribution->subtotal = $data->sum_subtotal;
            $direct_contribution->ipc = $data->sum_subtotal_ipc_rate;
            $direct_contribution->total = $data->sum_total;
            $direct_contribution->save();

            foreach ($data->contributions as $item)
            {
                $month_year = Carbon::createFromDate($request->year, $item->id_month, 1)->toDateString();
                $contribution = Contribution::where('month_year', '=', $month_year)->where('affiliate_id', '=', $request->affiliate_id)->first();
                $contribution_rate = ContributionRate::where('month_year', '=', $month_year)->first();
                $ipc_rate = IpcRate::where('month_year', '=', $month_year)->first();
                $now = Carbon::now();
                $ipc_actual = IpcRate::select('index')->where('month_year', '=',Carbon::createFromDate($now->year, $now->month, 1)->toDateString())->first();

                if (!$contribution) {

                    $contribution = new Contribution;
                    $contribution->user_id = Auth::user()->id;
                    $contribution->contribution_type_id = 2;
                    $contribution->affiliate_id = $request->affiliate_id;
                    $contribution->direct_contribution_id = $direct_contribution->id;

                    $contribution->month_year = $month_year;

                    $contribution->base_wage = $item->base_wage;
                    $contribution->category_id = $item->category->id;
                    $contribution->seniority_bonus = $item->seniority_bonus;
                    $contribution->study_bonus = $item->study_bonus;
                    $contribution->position_bonus = $item->position_bonus;
                    $contribution->border_bonus = $item->border_bonus;
                    $contribution->east_bonus = $item->east_bonus;

                    $contribution->quotable = $item->quotable;
                    $contribution->retirement_fund = $item->subtotal_retirement_fund;
                    $contribution->mortuary_quota = $item->subtotal_mortuary_quota;
                    $contribution->subtotal = $item->subtotal;
                    $contribution->ipc = $item->subtotal_ipc_rate;
                    $contribution->total = $item->total;
                    $contribution->save();
                }

            }

            $voucher = new Voucher;
            $voucher->user_id = Auth::user()->id;
            $voucher->affiliate_id = $request->affiliate_id;
            $voucher->voucher_type_id = 1;
            $voucher->direct_contribution_id = $direct_contribution->id;
            $last_voucher = Voucher::whereYear('created_at', '=', $now->year)->where('deleted_at', '=', null)->orderBy('id', 'desc')->first();
            if ($last_voucher) {
                $number_code = Util::separateCode($last_voucher->code);
                $code = $number_code + 1;
            }else{
                $code = 1;
            }
            $voucher->code = $code . "/" . $now->year;

            $voucher->total = $data->sum_total;
            $voucher->save();

            $message = "Aportes Guardados";
            Session::flash('message', $message);

        }

        return redirect('direct_contribution/'.$direct_contribution->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($direct_contribution)
    {
        $affiliate = Affiliate::IdIs($direct_contribution->affiliate_id)->first();
        $contribution = Contribution::where('direct_contribution_id', '=', $direct_contribution->id)->first();

        $data = [
            'direct_contribution' => $direct_contribution,
            'affiliate' => $affiliate,
            'year' => $contribution->month_year,
            'type' => $contribution  ? "Normal" : "Reintegro",

        ];

        return view('direct_contributions.show', $data);
    }

    public function PrintDirectContribution($id)
    {
        $header1 = "DIRECCIÓN DE BENEFICIOS ECONÓMICOS";
        $header2 = "UNIDAD DE FONDO DE RETIRO POLICIAL INDIVIDUAL";
        $title = "PAGO DE APORTES DIRECTOS";
        $direct_contribution = DirectContribution::idIs($id)->first();
        $affiliate = Affiliate::IdIs($direct_contribution->affiliate_id)->first();
        $date = Util::getDateEdit(date('Y-m-d'));
        $current_date = Carbon::now();
        $hour = Carbon::parse($current_date)->toTimeString();
        $view = \View::make('direct_contributions.print.show', compact('header1','header2','title','date','hour','direct_contribution','affiliate'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view)->setPaper('letter');
        return $pdf->stream();
    }

    public function PrintCompromise($id)
    {
        $header1 = "DIRECCIÓN DE BENEFICIOS ECONÓMICOS";
        $header2 = "UNIDAD DE FONDO DE RETIRO POLICIAL INDIVIDUAL";
        $title = "COMPROMISO DE PAGO DE APORTES EN FORMA DIRECTA AL BENEFICIO ECONOMICO DEL SEGURO DE VIDA TITULARES";
        $affiliate = Affiliate::IdIs($id)->first();
        //$date = Util::getDateEdit(date('Y-m-d'));
        $current_date = Carbon::now();
        $hour = Carbon::parse($current_date)->toTimeString();
        $date = Carbon::parse($current_date)->toDateString();
        $view = \View::make('direct_contributions.print.compromise', compact('header1','header2','title','date','hour','affiliate'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view)->setPaper('letter');
        return $pdf->stream();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
