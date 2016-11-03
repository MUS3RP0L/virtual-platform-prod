<?php

namespace Muserpol\Http\Controllers\Contribution;

use Illuminate\Http\Request;
use Muserpol\Http\Requests;
use Muserpol\Http\Controllers\Controller;

use Session;
use Datatables;
use Carbon\Carbon;
use Muserpol\Helper\Util;
use Illuminate\Support\Collection;

use Muserpol\Affiliate;
use Muserpol\Contribution;

class ContributionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function ShowContributions($affiliate_id)
    {
        $affiliate = Affiliate::idIs($affiliate_id)->first();

        $contribution = Contribution::affiliateidIs($affiliate->id)->first();

        if ($contribution) {

            $data = [

                'affiliate' => $affiliate,

            ];

            return view('contributions.view', $data);
        }
        else {

            $message = "No existe Registro de Aportes";
            Session::flash('message', $message);

            return redirect('affiliate/'.$affiliate_id);
        }
    }

    public function ShowData(Request $request)
    {
        $contributions = Contribution::select(['id', 'month_year', 'degree_id', 'unit_id', 'item', 'base_wage','seniority_bonus', 'study_bonus', 'position_bonus', 'border_bonus', 'east_bonus', 'public_security_bonus', 'gain', 'quotable', 'retirement_fund', 'mortuary_quota', 'total'])
                                        ->where('affiliate_id', $request->affiliate_id);

        return Datatables::of($contributions)
                ->editColumn('month_year', function ($contribution) { return Carbon::parse($contribution->month_year)->month . "-" . Carbon::parse($contribution->month_year)->year ; })
                ->editColumn('degree_id', function ($contribution) { return $contribution->degree_id ? $contribution->degree->code_level . "-" . $contribution->degree->code_degree : ''; })
                ->editColumn('unit_id', function ($contribution) { return $contribution->unit_id ? $contribution->unit->code : ''; })
                ->editColumn('base_wage', function ($contribution) { return Util::formatMoney($contribution->base_wage); })
                ->editColumn('seniority_bonus', function ($contribution) { return Util::formatMoney($contribution->seniority_bonus); })
                ->editColumn('study_bonus', function ($contribution) { return Util::formatMoney($contribution->study_bonus); })
                ->editColumn('position_bonus', function ($contribution) { return Util::formatMoney($contribution->position_bonus); })
                ->editColumn('border_bonus', function ($contribution) { return Util::formatMoney($contribution->border_bonus); })
                ->editColumn('east_bonus', function ($contribution) { return Util::formatMoney($contribution->east_bonus); })
                ->editColumn('public_security_bonus', function ($contribution) { return Util::formatMoney($contribution->public_security_bonus); })
                ->editColumn('gain', function ($contribution) { return Util::formatMoney($contribution->gain); })
                ->editColumn('quotable', function ($contribution) { return Util::formatMoney($contribution->quotable); })
                ->editColumn('retirement_fund', function ($contribution) { return Util::formatMoney($contribution->retirement_fund); })
                ->editColumn('mortuary_quota', function ($contribution) { return Util::formatMoney($contribution->mortuary_quota); })
                ->editColumn('total', function ($contribution) { return Util::formatMoney($contribution->total); })
                ->make(true);
    }

    public function SelectContribution($affiliate_id)
    {
        $affiliate = Affiliate::idIs($affiliate_id)->first();

        $data = [
            'affiliate' => $affiliate,
        ];

        return view('contributions.select', $data);
    }

    public function SelectData(Request $request)
    {
        $affiliate = Affiliate::idIs($request->affiliate_id)->first();
        $afi["affiliate"] = $affiliate->id;

        $group_contributions = new Collection;

        $now = Carbon::now();
        $from = Carbon::parse($affiliate->date_entry);
        $to = Carbon::createFromDate($now->year, $now->month, 1)->subMonth();

        for ($i=$from->year; $i <= $to->year ; $i++) {

            $count = 0;
            $total = 0;

            $base = array();
            $mes = array();

            for ($j=1; $j <= 12; $j++) {

                $contribution = Contribution::select(['month_year'])->where('affiliate_id', $affiliate->id)
                                                                    ->where('month_year', '=',Carbon::createFromDate($i, $j, 1)->toDateString())->first();
                if ($contribution) {
                    $mes["m".$j] = 1;
                    $count ++;
                    $total ++;
                }else {
                   $mes["m".$j] = 0;
                   $total ++;
                }

                if ($i == $from->year) {
                    if($j < $from->month){
                        $mes["m".$j] = -1;
                        $total --;
                    }
                }

                if ($i == $to->year) {
                    if($j > $to->month){
                        $mes["m".$j] = -1;
                        $total --;
                    }
                }
                $base = array_merge($base, $mes);
            }

            if ($total == $count) {
                $c["status"] = false;
            }else {
                $c["status"] = true;
            }

            $year = array('year'=> $i);
            $group_contributions->push(array_merge($afi, $c, $year, $base));
        }

        return Datatables::of($group_contributions)
                ->editColumn('m1', '<?php if($m1 === 1){ ?><i class="glyphicon glyphicon-check"></i><?php } if($m1 === 0){?><i class="glyphicon glyphicon-unchecked"></i><?php } if($m1 === -1){ ?>&nbsp;<?php } ?>')
                ->editColumn('m2', '<?php if($m2 === 1){ ?><i class="glyphicon glyphicon-check"></i><?php } if($m2 === 0){?><i class="glyphicon glyphicon-unchecked"></i><?php } if($m2 === -1){ ?>&nbsp;<?php } ?>')
                ->editColumn('m3', '<?php if($m3 === 1){ ?><i class="glyphicon glyphicon-check"></i><?php } if($m3 === 0){?><i class="glyphicon glyphicon-unchecked"></i><?php } if($m3 === -1){ ?>&nbsp;<?php } ?>')
                ->editColumn('m4', '<?php if($m4 === 1){ ?><i class="glyphicon glyphicon-check"></i><?php } if($m4 === 0){?><i class="glyphicon glyphicon-unchecked"></i><?php } if($m4 === -1){ ?>&nbsp;<?php } ?>')
                ->editColumn('m5', '<?php if($m5 === 1){ ?><i class="glyphicon glyphicon-check"></i><?php } if($m5 === 0){?><i class="glyphicon glyphicon-unchecked"></i><?php } if($m5 === -1){ ?>&nbsp;<?php } ?>')
                ->editColumn('m6', '<?php if($m6 === 1){ ?><i class="glyphicon glyphicon-check"></i><?php } if($m6 === 0){?><i class="glyphicon glyphicon-unchecked"></i><?php } if($m6 === -1){ ?>&nbsp;<?php } ?>')
                ->editColumn('m7', '<?php if($m7 === 1){ ?><i class="glyphicon glyphicon-check"></i><?php } if($m7 === 0){?><i class="glyphicon glyphicon-unchecked"></i><?php } if($m7 === -1){ ?>&nbsp;<?php } ?>')
                ->editColumn('m8', '<?php if($m8 === 1){ ?><i class="glyphicon glyphicon-check"></i><?php } if($m8 === 0){?><i class="glyphicon glyphicon-unchecked"></i><?php } if($m8 === -1){ ?>&nbsp;<?php } ?>')
                ->editColumn('m9', '<?php if($m9 === 1){ ?><i class="glyphicon glyphicon-check"></i><?php } if($m9 === 0){?><i class="glyphicon glyphicon-unchecked"></i><?php } if($m9 === -1){ ?>&nbsp;<?php } ?>')
                ->editColumn('m10', '<?php if($m10 === 1){ ?><i class="glyphicon glyphicon-check"></i><?php } if($m10 === 0){?><i class="glyphicon glyphicon-unchecked"></i><?php } if($m10 === -1){ ?>&nbsp;<?php } ?>')
                ->editColumn('m11', '<?php if($m11 === 1){ ?><i class="glyphicon glyphicon-check"></i><?php } if($m11 === 0){?><i class="glyphicon glyphicon-unchecked"></i><?php } if($m11 === -1){ ?>&nbsp;<?php } ?>')
                ->editColumn('m12', '<?php if($m12 === 1){ ?><i class="glyphicon glyphicon-check"></i><?php } if($m12 === 0){?><i class="glyphicon glyphicon-unchecked"></i><?php } if($m12 === -1){ ?>&nbsp;<?php } ?>')
                ->addColumn('action','
                    <?php if($status){ ?>
                        <div class="btn-group" style="margin:-6px 0;">
                            <a href="{{ url("calculation_contribution")}}/{{$affiliate}}/{{$year}}/normal" class="btn btn-success btn-raised btn-sm"><i class="glyphicon glyphicon-edit"></i></a>
                            <a href="" data-target="#" class="btn btn-success btn-raised btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ url("calculation_contribution")}}/{{$affiliate}}/{{$year}}/reintegro" style="padding:3px 10px;"><i class="glyphicon glyphicon-pencil"></i> reintegro</a></li>
                            </ul>
                        </div>
                    <?php } ?>')
                ->make(true);
    }
}
