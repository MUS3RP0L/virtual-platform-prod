<?php

namespace Muserpol\Http\Controllers\Affiliate;

use Illuminate\Http\Request;
use Muserpol\Http\Requests;
use Muserpol\Http\Controllers\Controller;

use DB;
use Auth;
use Validator;
use Session;
use Datatables;
use Carbon\Carbon;
use Muserpol\Helper\Util;

use Muserpol\Affiliate;
use Muserpol\AffiliateAddress;
use Muserpol\AffiliateState;
use Muserpol\AffiliateType;
use Muserpol\Category;
use Muserpol\Contribution;
use Muserpol\City;
use Muserpol\Degree;
use Muserpol\EconomicComplement;
use Muserpol\PensionEntity;
use Muserpol\Spouse;
use Muserpol\Unit;

class AffiliateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return view('affiliates.index');
    }

    public function Data(Request $request)
    {
        $affiliates = Affiliate::select(['id', 'identity_card', 'registration', 'last_name', 'mothers_last_name', 'first_name', 'second_name',  'affiliate_state_id', 'degree_id', 'city_identity_card_id']);

        if ($request->has('last_name'))
        {
            $affiliates->where(function($affiliates) use ($request)
            {
                $last_name = trim($request->get('last_name'));
                $affiliates->where('last_name', 'like', "%{$last_name}%");
            });
        }
        if ($request->has('mothers_last_name'))
        {
            $affiliates->where(function($affiliates) use ($request)
            {
                $mothers_last_name = trim($request->get('mothers_last_name'));
                $affiliates->where('mothers_last_name', 'like', "%{$mothers_last_name}%");
            });
        }
        if ($request->has('first_name'))
        {
            $affiliates->where(function($affiliates) use ($request)
            {
                $first_name = trim($request->get('first_name'));
                $affiliates->where('first_name', 'like', "%{$first_name}%");
            });
        }
        if ($request->has('second_name'))
        {
            $affiliates->where(function($affiliates) use ($request)
            {
                $second_name = trim($request->get('second_name'));
                $affiliates->where('second_name', 'like', "%{$second_name}%");
            });
        }
        if ($request->has('identity_card'))
        {
            $affiliates->where(function($affiliates) use ($request)
            {
                $identity_card = trim($request->get('identity_card'));
                $affiliates->where('identity_card', 'like', "%{$identity_card}%");
            });
        }
        if ($request->has('registration'))
        {
            $affiliates->where(function($affiliates) use ($request)
            {
                $registration = trim($request->get('registration'));
                $affiliates->where('registration', 'like', "%{$registration}%");
            });
        }

        return Datatables::of($affiliates)
                ->addColumn('identity_card', function($affiliate){

                    if($affiliate->city_identity_card->shortened){
                        return $affiliate->identity_card.' '.$affiliate->city_identity_card->shortened;
                    }
                    else{
                        return $affiliate->identity_card;
                    }

                })
                ->addColumn('degree', function ($affiliate) { return $affiliate->degree_id ? $affiliate->degree->shortened : ''; })
                ->editColumn('last_name', function ($affiliate) { return Util::ucw($affiliate->last_name); })
                ->editColumn('mothers_last_name', function ($affiliate) { return Util::ucw($affiliate->mothers_last_name); })
                ->addColumn('names', function ($affiliate) { return Util::ucw($affiliate->first_name) .' '. Util::ucw($affiliate->second_name); })
                ->addColumn('state', function ($affiliate) { return $affiliate->affiliate_state->name; })
                ->addColumn('action', function ($affiliate) { return  '
                    <div class="btn-group" style="margin:-3px 0;">
                        <a href="affiliate/'.$affiliate->id.'" class="btn btn-primary btn-raised btn-sm">&nbsp;&nbsp;<i class="glyphicon glyphicon-eye-open"></i>&nbsp;&nbsp;</a>
                    </div>';})
                ->make(true);
    }

    public static function getViewModel()
    {
        $cities = City::all();
        $cities_list = ['' => ''];
        foreach ($cities as $item) {
            $cities_list[$item->id]=$item->name;
        }

        $cities_list_short = ['' => ''];
        foreach ($cities as $item) {
            $cities_list_short[$item->id]=$item->shortened;
        }

        return [

            'cities_list' => $cities_list,
            'cities_list_short' => $cities_list_short

        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getData($affiliate)
    {
        $affiliate = Affiliate::idIs($affiliate)->first();

        $AffiliateAddress = AffiliateAddress::affiliateidIs($affiliate->id)->first();
        if (!$AffiliateAddress) { $AffiliateAddress = new AffiliateAddress; }
        $spouse = Spouse::affiliateidIs($affiliate->id)->first();

        if (!$spouse) { $spouse = new Spouse; }
        if ($spouse->city_identity_card_id) {
            $spouse->city_identity_card = City::idIs($spouse->city_identity_card_id)->first()->shortened;
        }else {
            $spouse->city_identity_card = '';
        }

        if ($affiliate->gender == 'M') {
            $gender_list = ['' => '', 'C' => 'CASADO', 'S' => 'SOLTERO', 'V' => 'VIUDO', 'D' => 'DIVORCIADO'];
            $gender_list_s = ['' => '', 'C' => 'CASADA', 'S' => 'SOLTERA', 'V' => 'VIUDA', 'D' => 'DIVORCIADA'];

        }elseif ($affiliate->gender == 'F') {
            $gender_list = ['' => '', 'C' => 'CASADA', 'S' => 'SOLTERA', 'V' => 'VIUDA', 'D' => 'DIVORCIADA'];
            $gender_list_s = ['' => '', 'C' => 'CASADO', 'S' => 'SOLTERO', 'V' => 'VIUDO', 'D' => 'DIVORCIADO'];

        }

        if ($affiliate->city_identity_card_id) {
            $affiliate->city_identity_card = City::idIs($affiliate->city_identity_card_id)->first()->shortened;
        }else {
            $affiliate->city_identity_card = '';
        }
        if ($affiliate->city_birth_id) {
            $affiliate->city_birth = City::idIs($affiliate->city_birth_id)->first()->name;
        }else {
            $affiliate->city_birth = '';
        }
        if ($AffiliateAddress->city_address_id) {
            $AffiliateAddress->city_address = City::idIs($AffiliateAddress->city_address_id)->first()->name;
        }else {
            $AffiliateAddress->city_address = '';
        }
        if ($AffiliateAddress->city_address_id || $AffiliateAddress->zone || $AffiliateAddress->Street || $AffiliateAddress->number_address) {
            $info_address = TRUE;
        }else{
            $info_address = FALSE;
        }
        if ($spouse->identity_card) {
            $info_spouse = TRUE;
        }else{
            $info_spouse = FALSE;
        }

        // $last_contribution = Contribution::affiliateidIs($affiliate->id)->orderBy('month_year', 'desc')->first();

        // $totals = DB::table('affiliates')
        //                 ->select(DB::raw('SUM(contributions.gain) as gain, SUM(contributions.public_security_bonus) as public_security_bonus,
        //                                 SUM(contributions.quotable) as quotable, SUM(contributions.total) as total,
        //                                 SUM(contributions.retirement_fund) as retirement_fund, SUM(contributions.mortuary_quota) as mortuary_quota'))
        //                 ->leftJoin('contributions', 'affiliates.id', '=', 'contributions.affiliate_id')
        //                 ->where('affiliates.id', '=', $affiliate->id)
        //                 ->get();

        // foreach ($totals as $item) {
        //     $total_gain = Util::formatMoney($item->gain);
        //     $total_public_security_bonus = Util::formatMoney($item->public_security_bonus);
        //     $total_quotable = Util::formatMoney($item->quotable);
        //     $total_retirement_fund = Util::formatMoney($item->retirement_fund);
        //     $total_mortuary_quota = Util::formatMoney($item->mortuary_quota);
        //     $total = Util::formatMoney($item->total);
        // }
        $affiliate_states=AffiliateState::all();
        $a_states=[];
        foreach ($affiliate_states as $as) {
            $a_states[$as->id]=$as->name;
        }
        $dg=Degree::all();
        $degrees=[];
        foreach ($dg as $d) {
            $degrees[$d->id]=$d->name;
        }

         $ep=PensionEntity::all();
        $entity_pensions=[];
        foreach ($ep as $e) {
            $entity_pensions[$e->id]=$e->name;
        }

        $at=AffiliateType::all();
        $affiliate_types=[];
        foreach ($at as $d) {
            $affiliate_types[$d->id]=$d->name;
        }
        $un=Unit::all();
        $units=[];
        foreach ($un as $d) {
            $units[$d->id]=$d->name;
        }

        $economic_complement = EconomicComplement::where('affiliate_id', $affiliate->id)->first();

        $ca=Category::all();
        $categories=[];
        foreach ($ca as $key=>$d) {
            if ($key==8) {
                break;
            }else{
                $categories[$d->id]=$d->name;
            }
        }

        $data = [

            'affiliate' => $affiliate,
            'AffiliateAddress' => $AffiliateAddress,
            'spouse' => $spouse,
            'gender_list' => $gender_list,
            'gender_list_s' => $gender_list_s,
            'info_address' => $info_address,
            'info_spouse' => $info_spouse,
            'economic_complement' => $economic_complement,
            // 'last_contribution' => $last_contribution,
            'observations'=>$affiliate->observations,
            // 'total_gain' => $total_gain,
            // 'total_public_security_bonus' => $total_public_security_bonus,
            // 'total_quotable' => $total_quotable,
            // 'total_retirement_fund' => $total_retirement_fund,
            // 'total_mortuary_quota' => $total_mortuary_quota,
            // 'total' => $total
            'affiliate_state'=>$a_states,
            'degrees'=>$degrees,
            'affiliate_types'=>$affiliate_types,
            'entity_pensions'=>$entity_pensions,
            'units'=>$units,
            'categories'=>$categories

        ];
        $data = array_merge($data, self::getViewModel());
        return $data;
    }
    public function show($affiliate)
    {
        return view('affiliates.view', self::getData($affiliate->id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $affiliate)
    {
        return $this->save($request, $affiliate);
    }

    public function save($request, $affiliate = false)
    {

        $rules = [
            // 'identity_card' =>'required',
            // 'city_identity_card_id' => 'required',
            // 'last_name' => 'min:3|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
            // 'mothers_last_name' => 'min:3|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
            // 'first_name' => 'min:3|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
            // 'second_name' => 'min:3|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
            // 'surname_husband' => 'min:3|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
            // 'gender' => 'required',
            // 'birth_date' => 'required'
        ];

        $messages = [
            // 'identity_card.required' => 'El Campo es Requerido',
            // 'city_identity_card_id.required' => 'El Campo es Requerido',
            // 'last_name.min' => 'El mínimo de caracteres permitidos para apellido paterno es 3',
            // 'last_name.regex' => 'Sólo se aceptan letras para apellido paterno',

            // 'mothers_last_name.min' => 'El mínimo de caracteres permitidos para apellido materno es 3',
            // 'mothers_last_name.regex' => 'Sólo se aceptan letras para apellido materno',

            // 'first_name.min' => 'El mínimo de caracteres permitidos para primer nombre es 3',
            // 'first_name.regex' => 'Sólo se aceptan letras para primer nombre',

            // 'second_name.min' => 'El mínimo de caracteres permitidos para teléfono de usuario es 3',
            // 'second_name.regex' => 'Sólo se aceptan letras para segundo nombre',

            // 'surname_husband.min' => 'El mínimo de caracteres permitidos para estado civil es 3',
            // 'surname_husband.regex' => 'Sólo se aceptan letras para estado civil',
            // 'gender.required' => 'Debe seleccionar un género',
            // 'birth_date.required' => 'Debe ingresa fecha de nacimiento'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);



        if ($validator->fails()) {
            return redirect('affiliate/'.$affiliate->id)
            ->withErrors($validator)
            ->withInput();
        }
        else {

            $affiliate->user_id = Auth::user()->id;

            switch ($request->type) {

                case 'personal':

                    $affiliate->identity_card = trim($request->identity_card);
                    if ($request->city_identity_card_id) { $affiliate->city_identity_card_id = $request->city_identity_card_id; } else { $affiliate->city_identity_card_id = null; }
                    $affiliate->last_name = trim($request->last_name);
                    $affiliate->mothers_last_name = trim($request->mothers_last_name);
                    $affiliate->first_name = trim($request->first_name);
                    $affiliate->second_name = trim($request->second_name);
                    $affiliate->surname_husband = trim($request->surname_husband);
                    $affiliate->gender = trim($request->gender);
                    $affiliate->nua = $request->nua >0 ? $request->nua:0;
                    $affiliate->birth_date = Util::datePick($request->birth_date);
                    $affiliate->civil_status = trim($request->civil_status);
                    if ($request->city_birth_id) { $affiliate->city_birth_id = $request->city_birth_id; } else { $affiliate->city_birth_id = null; }
                    $affiliate->phone_number = trim(implode(",", $request->phone_number));
                    $affiliate->cell_phone_number = trim(implode(",", $request->cell_phone_number));
                    if ($request->DateDeathAffiliateCheck == "on") {
                        $affiliate->date_death = Util::datePick($request->date_death);
                        $affiliate->reason_death = trim($request->reason_death);
                    }else {
                        $affiliate->date_death = null;
                        $affiliate->reason_death = null;
                    }
                    $affiliate->save();
                    $message = "Información personal de Afiliado actualizado con éxito";
                break;

                case 'institutional':

                    //check!
                    $economic_complement = EconomicComplement::where('affiliate_id', $affiliate->id)->first();
                    $economic_complement->city_id = $request->regional;
                    $economic_complement->save();

                    //end check!


                    $affiliate->affiliate_state_id = $request->state;
                    $affiliate->degree_id = $request->degree;
                    $affiliate->type = $request->affiliate_type;
                    $affiliate->unit_id = $request->unit;
                    $affiliate->date_entry = Util::datePick($request->date_entry);
                    $affiliate->item = $request->item > 0 ? $request->item: 0 ;
                    $affiliate->category_id = $request->category;
                    $affiliate->pension_entity_id=$request->affiliate_entity_pension;
                    $affiliate->save();
                    $message = "Información del Policia actualizada correctamene.";
                    Session::flash('message', $message);

                break;

            }
                Session::flash('message', $message);
        }

        return redirect('affiliate/'.$affiliate->id);
    }

    public function print_affiliate($affiliate)
    {
        $header1 = "DIRECCIÓN DE BENEFICIOS ECONÓMICOS";
        $header2 = "UNIDAD DE FONDO DE RETIRO POLICIAL INDIVIDUAL";
        $title = "REPORTE DE AFILIADO";
        $date = Util::getDateEdit(date('Y-m-d'));
        $current_date = Carbon::now();
        $hour = Carbon::parse($current_date)->toTimeString();
        $data = $this->getData($affiliate);
        $affiliate = $data['affiliate'];
        $spouse = $data['spouse'];
        $total_gain = $data['total_gain'];
        $total_public_security_bonus = $data['total_public_security_bonus'];
        $total_quotable = $data['total_quotable'];
        $total_retirement_fund = $data['total_retirement_fund'];
        $total_mortuary_quota = $data['total_mortuary_quota'];
        $total = $data['total'];
        $contributions = Contribution::select(['id', 'month_year', 'degree_id', 'unit_id', 'item', 'base_wage','seniority_bonus', 'study_bonus', 'position_bonus', 'border_bonus', 'east_bonus', 'public_security_bonus', 'gain', 'quotable', 'retirement_fund', 'mortuary_quota', 'total'])->where('affiliate_id', $affiliate->id)->get();
        $date = Util::getfulldate(date('Y-m-d'));
        $view = \View::make('affiliates.print.show', compact('header1','header2','title','date','hour','affiliate', 'spouse','total_gain','total_public_security_bonus','total_quotable','total_retirement_fund','total_mortuary_quota','total','contributions'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view)->setPaper('legal','landscape');
        return $pdf->stream();
    }

    public function print_affiliate_cover($affiliate)
    {
        $header1 = "DIRECCIÓN DE BENEFICIOS ECONÓMICOS";
        $header2 = "UNIDAD DE FONDO DE RETIRO POLICIAL INDIVIDUAL";
        $title = "REPORTE DE AFILIADO";
        $date = Util::getDateEdit(date('Y-m-d'));
        $current_date = Carbon::now();
        $hour = Carbon::parse($current_date)->toTimeString();
        $data = $this->getData($affiliate);
        $affiliate = $data['affiliate'];
        $spouse = $data['spouse'];
        $total_gain = $data['total_gain'];
        $total_public_security_bonus = $data['total_public_security_bonus'];
        $total_quotable = $data['total_quotable'];
        $total_retirement_fund = $data['total_retirement_fund'];
        $total_mortuary_quota = $data['total_mortuary_quota'];
        $total = $data['total'];
        $contributions = Contribution::select(['id', 'month_year', 'degree_id', 'unit_id', 'item', 'base_wage','seniority_bonus', 'study_bonus', 'position_bonus', 'border_bonus', 'east_bonus', 'public_security_bonus', 'gain', 'quotable', 'retirement_fund', 'mortuary_quota', 'total'])->where('affiliate_id', $affiliate->id)->get();
        $date = Util::getfulldate(date('Y-m-d'));
        $view = \View::make('affiliates.print.show', compact('header1','header2','title','date','hour','affiliate', 'spouse','total_gain','total_public_security_bonus','total_quotable','total_retirement_fund','total_mortuary_quota','total','contributions'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view)->setPaper('legal','landscape');
        return $pdf->stream();
    }
      public function print_wallet_in_arrears()
    {
        $header1 = "DIRECCIÓN DE BENEFICIOS ECONÓMICOS";
        $header2 = "UNIDAD DE FONDO DE RETIRO POLICIAL INDIVIDUAL";
        $title = "NOTIFICACIÓN";
        $date = Util::getDateEdit(date('Y-m-d'));
        $current_date = Carbon::now();
        $hour = Carbon::parse($current_date)->toTimeString();
        //$data = $this->getData();
       // dd($header1);
      //  $affiliate = $data['affiliate'];
        //$spouse = $data['spouse'];
        //$total_gain = $data['total_gain'];
        //$total_public_security_bonus = $data['total_public_security_bonus'];
        //$total_quotable = $data['total_quotable'];
        //$total_retirement_fund = $data['total_retirement_fund'];
        //$total_mortuary_quota = $data['total_mortuary_quota'];
        //$total = $data['total'];
        //$contributions = Contribution::select(['id', 'month_year', 'degree_id', 'unit_id', 'item', 'base_wage','seniority_bonus', 'study_bonus', 'position_bonus', 'border_bonus', 'east_bonus', 'public_security_bonus', 'gain', 'quotable', 'retirement_fund', 'mortuary_quota', 'total'])->where('affiliate_id', $affiliate->id)->get();
        $date = Util::getfulldate(date('Y-m-d'));
        $view = \View::make('affiliates.print.wallet_arrear', compact('header1','header2','title','date','hour'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view)->setPaper('legal');
        return $pdf->stream();
    }

       public function print_excluded_by_salary()
    {
        $header1 = "DIRECCIÓN DE BENEFICIOS ECONÓMICOS";
        $header2 = "UNIDAD DE FONDO DE RETIRO POLICIAL INDIVIDUAL";
        $title = "NOTIFICACIÓN";
        $date = Util::getDateEdit(date('Y-m-d'));
        $current_date = Carbon::now();
        $hour = Carbon::parse($current_date)->toTimeString();
        //$data = $this->getData();
       // dd($header1);
      //  $affiliate = $data['affiliate'];
        //$spouse = $data['spouse'];
        //$total_gain = $data['total_gain'];
        //$total_public_security_bonus = $data['total_public_security_bonus'];
        //$total_quotable = $data['total_quotable'];
        //$total_retirement_fund = $data['total_retirement_fund'];
        //$total_mortuary_quota = $data['total_mortuary_quota'];
        //$total = $data['total'];
        //$contributions = Contribution::select(['id', 'month_year', 'degree_id', 'unit_id', 'item', 'base_wage','seniority_bonus', 'study_bonus', 'position_bonus', 'border_bonus', 'east_bonus', 'public_security_bonus', 'gain', 'quotable', 'retirement_fund', 'mortuary_quota', 'total'])->where('affiliate_id', $affiliate->id)->get();
        $date = Util::getfulldate(date('Y-m-d'));
        $view = \View::make('affiliates.print.excluded_by_salary', compact('header1','header2','title','date','hour'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view)->setPaper('legal');
        return $pdf->stream();
    }

         public function print_miss_requiriments()
    {
        $header1 = "DIRECCIÓN DE BENEFICIOS ECONÓMICOS";
        $header2 = "UNIDAD DE FONDO DE RETIRO POLICIAL INDIVIDUAL";
        $title = "NOTIFICACIÓN";
        $date = Util::getDateEdit(date('Y-m-d'));
        $current_date = Carbon::now();
        $hour = Carbon::parse($current_date)->toTimeString();
        //$data = $this->getData();
       // dd($header1);
      //  $affiliate = $data['affiliate'];
        //$spouse = $data['spouse'];
        //$total_gain = $data['total_gain'];
        //$total_public_security_bonus = $data['total_public_security_bonus'];
        //$total_quotable = $data['total_quotable'];
        //$total_retirement_fund = $data['total_retirement_fund'];
        //$total_mortuary_quota = $data['total_mortuary_quota'];
        //$total = $data['total'];
        //$contributions = Contribution::select(['id', 'month_year', 'degree_id', 'unit_id', 'item', 'base_wage','seniority_bonus', 'study_bonus', 'position_bonus', 'border_bonus', 'east_bonus', 'public_security_bonus', 'gain', 'quotable', 'retirement_fund', 'mortuary_quota', 'total'])->where('affiliate_id', $affiliate->id)->get();
        $date = Util::getfulldate(date('Y-m-d'));
        $view = \View::make('affiliates.print.miss_requiriments', compact('header1','header2','title','date','hour'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view)->setPaper('legal');
        return $pdf->stream();
    }
}