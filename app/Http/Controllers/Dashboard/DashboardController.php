<?php

namespace Muserpol\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Muserpol\Http\Requests;
use Muserpol\Http\Controllers\Controller;

use DB;
use Muserpol\Helper\Util;
use Carbon\Carbon;

use Muserpol\Activity;
use Muserpol\Affiliate;
use Muserpol\Spouse;
use Muserpol\AffiliateState;
use Muserpol\AffiliateType;
use Muserpol\Contribution;


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
										->select(DB::raw('count(*) as totalafis'))
										->where('affiliates.affiliate_state_id', '=', 1)
										->get();
								
			foreach ($AfiServ as $item) {
				$totalAfiServ = $item->totalafis;
				
			}	

			$AfiComi = DB::table('affiliates')
										->select(DB::raw('COUNT(*) as totalafic'))
										->where('affiliates.affiliate_state_id', '=', 2)
										->get();

			foreach ($AfiComi as $item) {
				$totalAfiComi = $item->totalafic;
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

				$listYear = DB::table('contributions')
					->select(DB::raw('DISTINCT(EXTRACT(YEAR FROM contributions.month_year)) as year'))
					->where(DB::raw('EXTRACT(YEAR FROM contributions.month_year)'), '>', $yearc)
					->orderBy(DB::raw('EXTRACT(YEAR FROM contributions.month_year )'), 'asc')
					->get();
				
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
			$current_year=Carbon::now()->year;

			//voluntary contribution by current year
			$monthVoluntaryContribution = DB::table('contributions')
				
				->select(DB::raw('DISTINCT(EXTRACT(MONTH FROM contributions.month_year)) as month'))
				->where('contributions.contribution_type_id', '=', 2)
				->where(DB::raw('EXTRACT(MONTH FROM contributions.month_year)'), '=', $current_year)
				->orderBy(DB::raw('EXTRACT(MONTH FROM contributions.month_year)'), 'asc')
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
			'total_voluntayContributionByMonth' => $total_voluntayContributionByMonth,
			'current_year' => $current_year
		];
	
				return view('dashboard.index', $data);

	}

		public function appendValue($data, $type, $element)
	{
		// operate on the item passed by reference, adding the element and type
		foreach ($data as $key => & $item) {
			$item[$element] = $type;
		}
		return $data;
	}

	public function appendURL($data, $prefix)
	{
		// operate on the item passed by reference, adding the url based on slug
		foreach ($data as $key => & $item) {
			$item['url'] = url($prefix.'/'.$item['id']);
		}
		return $data;
	}

	public function searchAffiliate(Request $request)
	{
		$query = $request->q;

		if(!$query && $query == '') return Response::json(array(), 400);

		$affiliates = Affiliate::where('identity_card','like', $query)
			->orderBy('first_name','asc')
			->take(3)
			->get(array('id', 'identity_card', 'first_name', 'last_name'))->toArray();

				$spouses = Spouse::where('identity_card','like', $query)
						->orderBy('first_name','asc')
						->take(3)
						->get(array('id', 'identity_card', 'first_name', 'last_name'))->toArray();

		$affiliates = $this->appendURL($affiliates, 'affiliate');
				$spouses  = $this->appendURL($spouses, 'affiliate');

		$affiliates = $this->appendValue($affiliates, 'affiliate', 'class');
		$spouses = $this->appendValue($spouses, 'spouse', 'class');

				$data = array_merge($affiliates, $spouses);

				return response()->json(array(
			'data'=>$data
		));
	}
}
