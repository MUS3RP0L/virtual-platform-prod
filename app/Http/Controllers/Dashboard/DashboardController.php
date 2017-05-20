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
use Muserpol\EconomicComplement;


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
				if ($TotalAffiliates->total) {
					
				$Total_AffiliatebyState[$item->name] = $TotalAffiliates->total;
				}
			}
			foreach ($affiliateType as $item) {
				$Afitype = Affiliate::afibyType($item->id,$year)->first();

				$Total_AffiliatebyType[$item->name] = $Afitype->type;
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

					$list_totalcontribution[] = ($totalContribution->total);
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
			$list_affiliateByDisctrict=[];
			foreach ($district as $item) {

				$afiDistrict = Affiliate::afiDistrict($item->district, $year)->first();
				if ($afiDistrict->district) {
					$list_affiliateByDisctrict[$item->district] = $afiDistrict->district;
				}

			}
			$current_year=Carbon::now()->year;

			//voluntary contribution by current year
			$monthVoluntaryContribution = DB::table('contributions')
				
				->select(DB::raw('DISTINCT(EXTRACT(MONTH FROM contributions.month_year)) as month'))
				->where('contributions.type', '=', 'Directo')
				->where(DB::raw('EXTRACT(MONTH FROM contributions.month_year)'), '=', $current_year)
				->orderBy(DB::raw('EXTRACT(MONTH FROM contributions.month_year)'), 'asc')
				->get();
				//revisar
				//dd($monthVoluntaryContribution);
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


		//for economic complement
		$economic_complement=DB::table('economic_complements')
			->select(DB::raw('COUNT(*) as quantity, EXTRACT(MONTH FROM economic_complements.reception_date) as month'))
			//->groupBy(DB::raw('EXTRACT(MONTH FROM economic_complements.reception_date)'))
			->groupBy('month')
			->orderBy('month')
			->get();
		$economic_complement_bar_labels=[];
		$economic_complement_bar_datas=[];
		foreach ($economic_complement as $item) {
			$economic_complement_bar_labels[]= date("F", mktime(0, 0, 0, $item->month, 10));
			$economic_complement_bar_datas[]= $item->quantity;
		}
		$economic_complement_bar= array($economic_complement_bar_labels, $economic_complement_bar_datas);
		
		// for economic complement types

		$economic_complement_types=DB::table('eco_com_types')
			->select(DB::raw('count(*) as quantity, eco_com_types.name as type_name'))
			->join('eco_com_modalities','eco_com_types.id', '=', 'eco_com_modalities.eco_com_type_id')
			->join('economic_complements','economic_complements.eco_com_modality_id','=','eco_com_modalities.id')
			->groupBy('eco_com_types.name')
			->get();
		$economic_complement_pie_types_labels=[];
		$economic_complement_pie_types_datas=[];
		foreach ($economic_complement_types as $item) {
			$economic_complement_pie_types_labels[]= $item->type_name;
			$economic_complement_pie_types_datas[]= $item->quantity;
		}
		$economic_complement_pie_types=array($economic_complement_pie_types_labels,$economic_complement_pie_types_datas);
		
		//for economic complement  modalities types

		$economic_complement_modalities_types=DB::table('eco_com_types')
			->select(DB::raw('count(*) as quantity, eco_com_modalities.shortened'))
			->join('eco_com_modalities','eco_com_types.id' ,'=', 'eco_com_modalities.eco_com_type_id')
			->join('economic_complements','economic_complements.eco_com_modality_id','=','eco_com_modalities.id')
			->groupBy('eco_com_modalities.shortened')
			->get();
			$economic_complement_modalities_types_datas=[];
		foreach ($economic_complement_modalities_types as $item) {
			$economic_complement_modalities_types_datas[$item->shortened]= $item->quantity;
		}
		//for  economic complement for cities

		$economic_complement_cities=DB::table('cities')
			->select(DB::raw('count(*) as quantity, cities.name'))
			->join('economic_complements','economic_complements.city_id','=','cities.id')
			->groupBy('cities.name')
			->orderBy('quantity')
			->get();
		$economic_complement_cities_data=[];
		foreach ($economic_complement_cities as $item) {
			$economic_complement_cities_data[$item->name]=$item->quantity;
		}

		$data = [
			'activities' => $activities,
			'totalAfiServ' => $totalAfiServ,
			'totalAfiComi' => $totalAfiComi,
			'totalAfi' => $totalAfi,
			'Total_AffiliatebyState' => array(array_keys($Total_AffiliatebyState),array_values($Total_AffiliatebyState)),
			'Total_AffiliatebyType' => array(array_keys($Total_AffiliatebyType),array_values($Total_AffiliatebyType)),
			'totalContributionByYear' => $totalContributionByYear,
			'list_affiliateByDisctrict' => array(array_keys($list_affiliateByDisctrict),array_values($list_affiliateByDisctrict)),
			'total_voluntayContributionByMonth' => $total_voluntayContributionByMonth,
			'current_year' => $current_year,
			'economic_complement_bar'=>$economic_complement_bar,
			'economic_complement_pie_types'=>$economic_complement_pie_types,
			'economic_complement_modalities_types'=>array(array_keys($economic_complement_modalities_types_datas),array_values($economic_complement_modalities_types_datas)),
			'economic_complement_cities'=>array(array_keys($economic_complement_cities_data),array_values($economic_complement_cities_data)),

		];
		//dd(array(array_keys($economic_complement_modalities_types),array_values($economic_complement_modalities_types)));
	
				return view('dashboard.index', $data);

	}

	public function appendValue($data, $type, $element)
	{
		foreach ($data as $key => & $item) {
			$item[$element] = $type;
		}
		return $data;
	}

	public function appendURLaffiliate($data, $prefix)
	{
		foreach ($data as $key => & $item) {
			$item['url'] = url($prefix.'/'.$item['id']);
		}
		return $data;
	}

	public function appendURLspouse($data, $prefix)
	{
		foreach ($data as $key => & $item) {
			$item['url'] = url($prefix.'/'.$item['affiliate_id']);
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
			->get(array('id', 'affiliate_id', 'identity_card', 'first_name', 'last_name'))->toArray();

		$affiliates = $this->appendURLaffiliate($affiliates, 'affiliate');
		$spouses  = $this->appendURLspouse($spouses, 'affiliate');

		$affiliates = $this->appendValue($affiliates, 'affiliate', 'class');
		$spouses = $this->appendValue($spouses, 'spouse', 'class');

		$data = array_merge($affiliates, $spouses);

		return response()->json(array(
			'data'=>$data
		));
	}
}
