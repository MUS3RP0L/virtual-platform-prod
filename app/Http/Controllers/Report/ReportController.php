<?php

namespace Muserpol\Http\Controllers\Report;

use Illuminate\Http\Request;
use Muserpol\Http\Requests;
use Muserpol\Http\Controllers\Controller;

use DB;
use Carbon\Carbon;
use Muserpol\Helper\Util;

use Muserpol\Contribution;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public static function getViewModel()
    {
        $years = DB::table('contributions')->select(DB::raw('DISTINCT YEAR(contributions.month_year ) years'))
                    ->orderBy('years', 'desc')->get();

        $years_list = [];
        foreach ($years as $item) {
            $years_list[$item->years]=$item->years;
        }

        $months_list = Util::getArrayMonths();

        return [

            'years_list' => $years_list,
            'months_list' => $months_list

        ];
    }

    public function ShowMonthlyReport()
    {
        $data = [

            'result' => false,
            'year' => '',
            'month' => ''
        ];

        $data = array_merge($data, self::getViewModel());

        return view('reports.monthly_report.index', $data);
    }

    public function GenerateMonthlyReport(Request $request)
    {
        $totalSumC = DB::select('call sum_contributionsC(' . $request->month . ',' . $request->year . ')');

        foreach ($totalSumC as $item) {
            $count_idC = $item->count_id;
            $salaryC = $item->salary;
            $seniority_bonusC = $item->seniority_bonus;
            $study_bonusC = $item->study_bonus;
            $position_bonusC = $item->position_bonus;
            $border_bonusC = $item->border_bonus;
            $east_bonusC = $item->east_bonus;
            $public_security_bonusC = $item->public_security_bonus;
            $gainC = $item->gain;
            $quotableC = $item->quotable;
            $retirement_fundC = $item->retirement_fund;
            $mortuary_quotaC = $item->mortuary_quota;
            $totalC = $item->total;
        }

        $totalSumB = DB::select('call sum_contributionsB(' . $request->month . ',' . $request->year . ')');

        foreach ($totalSumB as $item) {
            $count_idB = $item->count_id;
            $salaryB = $item->salary;
            $seniority_bonusB = $item->seniority_bonus;
            $study_bonusB = $item->study_bonus;
            $position_bonusB = $item->position_bonus;
            $border_bonusB = $item->border_bonus;
            $east_bonusB = $item->east_bonus;
            $public_security_bonusB = $item->public_security_bonus;
            $gainB = $item->gain;
            $quotableB = $item->quotable;
            $retirement_fundB = $item->retirement_fund;
            $mortuary_quotaB = $item->mortuary_quota;
            $totalB = $item->total;
        }
        $total_count_id = $count_idC + $count_idB;
        $total_salary = $salaryC + $salaryB;
        $total_seniority_bonus = $seniority_bonusC + $seniority_bonusB;
        $total_study_bonus = $study_bonusC + $study_bonusB;
        $total_position_bonus = $position_bonusC + $position_bonusB;
        $total_border_bonus = $border_bonusC + $border_bonusB;
        $total_east_bonus = $east_bonusC + $east_bonusB;
        $total_public_security_bonus = $public_security_bonusC + $public_security_bonusB;
        $total_gain = $gainC + $gainB;
        $total_quotable = $quotableC + $quotableB;
        $total_retirement_fund = $retirement_fundC + $retirement_fundB;
        $total_mortuary_quota = $mortuary_quotaC + $mortuary_quotaB;
        $total = $totalC + $totalB;

        $data = [
            'count_idC' => $count_idC,
            'count_idB' => $count_idB,
            'total_count_id' => $total_count_id,
            'salaryC' => Util::formatMoney($salaryC),
            'salaryB' => Util::formatMoney($salaryB),
            'total_salary' => Util::formatMoney($total_salary),
            'seniority_bonusC' => Util::formatMoney($seniority_bonusC),
            'seniority_bonusB' => Util::formatMoney($seniority_bonusB),
            'total_seniority_bonus' => Util::formatMoney($total_seniority_bonus),
            'study_bonusC' => Util::formatMoney($study_bonusC),
            'study_bonusB' => Util::formatMoney($study_bonusB),
            'total_study_bonus' => Util::formatMoney($total_study_bonus),
            'position_bonusC' => Util::formatMoney($position_bonusC),
            'position_bonusB' => Util::formatMoney($position_bonusB),
            'total_position_bonus' => Util::formatMoney($total_position_bonus),
            'border_bonusC' => Util::formatMoney($border_bonusC),
            'border_bonusB' => Util::formatMoney($border_bonusB),
            'total_border_bonus' => Util::formatMoney($total_border_bonus),
            'east_bonusC' => Util::formatMoney($east_bonusC),
            'east_bonusB' => Util::formatMoney($east_bonusB),
            'total_east_bonus' => Util::formatMoney($total_east_bonus),
            'public_security_bonusC' => Util::formatMoney($public_security_bonusC),
            'public_security_bonusB' => Util::formatMoney($public_security_bonusB),
            'total_public_security_bonus' => Util::formatMoney($total_public_security_bonus),
            'gainC' => Util::formatMoney($gainC),
            'gainB' => Util::formatMoney($gainB),
            'total_gain' => Util::formatMoney($total_gain),
            'quotableC' => Util::formatMoney($quotableC),
            'quotableB' => Util::formatMoney($quotableB),
            'total_quotable' => Util::formatMoney($total_quotable),
            'retirement_fundC' => Util::formatMoney($retirement_fundC),
            'retirement_fundB' => Util::formatMoney($retirement_fundB),
            'total_retirement_fund' => Util::formatMoney($total_retirement_fund),
            'mortuary_quotaC' => Util::formatMoney($mortuary_quotaC),
            'mortuary_quotaB' => Util::formatMoney($mortuary_quotaB),
            'total_mortuary_quota' => Util::formatMoney($total_mortuary_quota),
            'totalC' => Util::formatMoney($totalC),
            'totalB' => Util::formatMoney($totalB),
            'total' => Util::formatMoney($total),
            'year' => $request->year,
            'month' => $request->month,
            'result' => true
        ];

        $data = array_merge($data, self::getViewModel());
        return view('reports.monthly_report.index', $data);
    }
}
