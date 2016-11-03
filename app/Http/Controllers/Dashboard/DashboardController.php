<?php

namespace Muserpol\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Muserpol\Http\Requests;
use Muserpol\Http\Controllers\Controller;

use DB;
use Muserpol\Affiliate;
use Muserpol\Helper\Util;
use Carbon\Carbon;

use Muserpol\Activity;
use Muserpol\AffiliateState;
use Muserpol\AffiliateType;
use Muserpol\Contribution;
use Muserpol\RetirementFund;

class DashboardController extends Controller
{
    /*
	|--------------------------------------------------------------------------
	| Dashboard Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */

	public function __construct()
	{
		$this->middleware('auth');
	}
	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */

	public function showIndex()
	{
      $AfiServ = DB::table('affiliates')
                    ->select(DB::raw('COUNT(*) totalAfiS'))
                    ->where('affiliates.affiliate_state_id', '=', 1)
                    ->get();

      foreach ($AfiServ as $item) {
        $totalAfiServ = $item->totalAfiS;
      }

      $AfiComi = DB::table('affiliates')
                    ->select(DB::raw('COUNT(*) totalAfiC'))
                    ->where('affiliates.affiliate_state_id', '=', 2)
                    ->get();

      foreach ($AfiComi as $item) {
        $totalAfiComi = $item->totalAfiC;
      }

      $affiliateState = AffiliateState::all();
      $affiliateType = AffiliateType::all();
      $district = DB::table('units')->select(DB::raw('DISTINCT (units.district) as district'))->get();
      $year = Carbon::now()->year;

      foreach ($affiliateState as $item) {
        $TotalAffiliates = Affiliate::afibyState($item->id,$year)->first();
        $Total_AffiliatebyState[$item->id] = $TotalAffiliates->total;
      }

      foreach ($affiliateType as $item) {
        $Afitype = Affiliate::afibyType($item->id,$year)->first();
        $Total_AffiliatebyType[$item->id] = $Afitype->type;

      }
      //Total Contributions of last five year, disaggregated by year.
      $lastContribution = DB::table('contributions')->orderBy('month_year', 'desc')->first();
      if($lastContribution)
      {
        $date_contribution = Carbon::parse($lastContribution->month_year)->subYears(5);
        $yearc = Carbon::parse($date_contribution)->year;
        $listYear = DB::table('contributions')->select(DB::raw('DISTINCT(year(contributions.month_year)) as year'))
                                    ->whereYear('contributions.month_year', '>', $yearc)->orderBy('contributions.month_year', 'asc')->get();

        foreach ($listYear as $item) {
          $totalContribution = Contribution::afiContribution($item->year)->first();
          $list_totalcontribution[] = $totalContribution->total;
          $list_year[] = $totalContribution->month_year;

        }
        $totalContributionByYear = array($list_year, $list_totalcontribution );
      }
      else
      {
        $list_totalcontribution[] = 0;
        $list_year[] =0;
        $totalContributionByYear = array($list_year, $list_totalcontribution );
      }

      // Total Affiliates disaggregated by district.
      foreach ($district as $item) {

        $afiDistrict = Affiliate::afiDistrict($item->district, $year)->first();
        $list_affiliateByDisctrict[$item->district] = $afiDistrict->district;

      }

      //Total Retirement Fund of current year, disaggregated by month.
      $current_date = Carbon::now();
      $current_year = Carbon::parse($current_date)->year;

      $monthRetirementFund = DB::table('retirement_funds')
                            ->select(DB::raw('DISTINCT(month(retirement_funds.reception_date)) as month'))
                            ->whereYear('retirement_funds.reception_date', '=', $current_year)
                            ->orderBy('retirement_funds.reception_date', 'asc')
                            ->get();
      if($monthRetirementFund)
      {
        foreach ($monthRetirementFund as $item) {
          $totalRetirementFundByMonth = RetirementFund::totalRetirementFund($item->month,$current_year)->first();
          $list_month[] = Util::getMes($totalRetirementFundByMonth->month);
          $list_totalRetirementFundByMonth[] = $totalRetirementFundByMonth->total;
        }
        $total_retirementFundByMonth = array($list_month, $list_totalRetirementFundByMonth);
      }
      else
      {
        $list_month[] = 0;
        $list_totalRetirementFundByMonth[] = 0;
        $total_retirementFundByMonth = array($list_month, $list_totalRetirementFundByMonth);
      }

      //voluntary contribution by current year
      $monthVoluntaryContribution = DB::table('contributions')
                            ->select(DB::raw('DISTINCT(month(contributions.month_year)) as month'))
                            ->where('contributions.contribution_type_id', '=', 2)
                            ->whereYear('contributions.month_year', '=', $current_year)
                            ->orderBy('contributions.month_year', 'asc')
                            ->get();

       if($monthVoluntaryContribution)
      {
        foreach ($monthVoluntaryContribution as $item) {
            $totalVoluntaryContributionByMonth = Contribution::voluntaryContribution($item->month, $current_year)->first();
            $list_monthVoluntaryContribution[] = Util::getMes($totalVoluntaryContributionByMonth->month);
            $list_amountVoluntaryContribution[] = $totalVoluntaryContributionByMonth->total;
        }
        $total_voluntayContributionByMonth = array($list_monthVoluntaryContribution, $list_amountVoluntaryContribution);
      }
      else
      {
        $list_monthVoluntaryContribution[] = 0;
        $list_amountVoluntaryContribution[] = 0;
        $total_voluntayContributionByMonth = array($list_monthVoluntaryContribution, $list_amountVoluntaryContribution);
      }


    $activities = Activity::orderBy('created_at', 'desc')->take(10)->get();
    $totalAfi = $totalAfiServ + $totalAfiComi;

    $data = [
      'activities' => $activities,
      'totalAfiServ' => $totalAfiServ,
      'totalAfiComi' => $totalAfiComi,
      'totalAfi' => $totalAfi,
      'Total_AffiliatebyState' => $Total_AffiliatebyState,
      'Total_AffiliatebyType' => $Total_AffiliatebyType,
      'totalContributionByYear' => $totalContributionByYear,
      'list_affiliateByDisctrict' => $list_affiliateByDisctrict,
      'total_retirementFundByMonth' => $total_retirementFundByMonth,
      'total_voluntayContributionByMonth' => $total_voluntayContributionByMonth,
      'current_year' => $current_year
    ];

     return view('dashboard.index', $data);
      //return response()->json($totalAfiServ);
	}
}
