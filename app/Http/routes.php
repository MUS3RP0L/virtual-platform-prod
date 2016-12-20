<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('login', 'Auth\AuthController@getLogin');
Route::post('login', 'Auth\AuthController@postLogin');
Route::get('logout', 'Auth\AuthController@getLogout');

Route::group(['middleware' => 'auth'], function() {

	// Dashboard
	Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'Dashboard\DashboardController@showIndex']);
	Route::get('/', ['as' => 'dashboard', 'uses' => 'Dashboard\DashboardController@showIndex']);
	Route::get('home', ['as' => 'dashboard', 'uses' => 'Dashboard\DashboardController@showIndex']);
	Route::get('search', 'Dashboard\DashboardController@searchAffiliate');

	// User Management
	Route::resource('user', 'User\UserController');

	Route::get('user/block/{user}', array('as'=>'user/block', 'uses'=>'User\UserController@Block'));
	Route::get('user/unblock/{user}', array('as'=>'user/unblock', 'uses'=>'User\UserController@Unblock'));
	Route::get('get_user', array('as'=>'get_user', 'uses'=>'User\UserController@Data'));
	Route::get('get_role/{id}', array('as'=>'get_role', 'uses'=>'User\UserController@getRole'));

	// Contribution Rate
	Route::resource('contribution_rate', 'Rate\ContributionRateController');

	Route::get('get_contribution_rate', array('as'=>'get_contribution_rate', 'uses'=>'Rate\ContributionRateController@Data'));

	// IPC Rate
	Route::resource('ipc_rate', 'Rate\IpcRateController');

	Route::get('get_ipc_rate', array('as'=>'get_ipc_rate', 'uses'=>'Rate\IpcRateController@Data'));

	// Base Wage
	Route::resource('base_wage', 'Wage\BaseWageController');

	Route::get('get_first_level_base_wage', array('as'=>'get_first_level_base_wage', 'uses'=>'Wage\BaseWageController@FirstLevelData'));
	Route::get('get_second_level_base_wage', array('as'=>'get_second_level_base_wage', 'uses'=>'Wage\BaseWageController@SecondLevelData'));
	Route::get('get_third_level_base_wage', array('as'=>'get_third_level_base_wage', 'uses'=>'Wage\BaseWageController@ThirdLevelData'));
	Route::get('get_fourth_level_base_wage', array('as'=>'get_fourth_level_base_wage', 'uses'=>'Wage\BaseWageController@FourthLevelData'));

	// Monthly Report
	Route::get('monthly_report', array('as'=>'monthly_report', 'uses'=>'Report\ReportController@ShowMonthlyReport'));
	Route::post('monthly_report', array('as'=>'monthly_report', 'uses'=> 'Report\ReportController@GenerateMonthlyReport'));

	// Record Affiliate
	Route::get('get_record/{affiliate_id}', array('as'=>'get_record', 'uses'=>'Affiliate\RecordController@Data'));

	// Affiliate
	Route::resource('affiliate', 'Affiliate\AffiliateController');
	Route::get('print_affiliate/{affiliate_id}', 'Affiliate\AffiliateController@print_affiliate');
	Route::get('print_sworn_declaration1/{affiliate_id}', 'Affiliate\AffiliateController@print_sworn_declaration1');
	Route::get('print_sworn_declaration2/{affiliate_id}', 'Affiliate\AffiliateController@print_sworn_declaration2');
	Route::get('print_inclusion_solicitude/{affiliate_id}', 'Affiliate\AffiliateController@print_inclusion_solicitude');
	Route::get('print_pay_solicitude/{affiliate_id}', 'Affiliate\AffiliateController@print_pay_solicitude');
	Route::post('search_affiliate', array('as'=>'search_affiliate', 'uses'=>'Affiliate\AffiliateController@SearchAffiliate'));
	Route::get('get_affiliate', array('as'=>'get_affiliate', 'uses'=>'Affiliate\AffiliateController@Data'));

	// Affiliate Address
	Route::resource('affiliate_address', 'Affiliate\AffiliateAddressController');

	// Spouses
	Route::resource('spouse', 'Affiliate\SpouseController');

	// Contribution
	Route::resource('contribution', 'Contribution\ContributionController');

	Route::get('show_contributions/{affiliate_id}', array('as'=>'show_contributions', 'uses'=>'Contribution\ContributionController@ShowContributions'));
	Route::get('get_contribution/{affiliate_id}', array('as'=>'get_contribution', 'uses'=>'Contribution\ContributionController@ShowData'));

	Route::get('select_contribution/{affiliate_id}', array('as'=>'select_contribution', 'uses'=>'Contribution\ContributionController@SelectContribution'));
	Route::get('get_select_contribution/{id}', array('as'=>'get_select_contribution', 'uses'=>'Contribution\ContributionController@SelectData'));

	// Direct Contribution
	Route::resource('direct_contribution', 'Contribution\DirectContributionController');

	Route::get('calculation_contribution/{affiliate_id}/{year}/{type}', 'Contribution\DirectContributionController@CalculationContribution');
	Route::post('calculation_contribution', 'Contribution\DirectContributionController@GenerateCalculationContribution');

	Route::get('get_direct_contribution', array('as'=>'get_direct_contribution', 'uses'=>'Contribution\DirectContributionController@Data'));

	Route::get('print_direct_contribution/{direct_contribution_id}', 'Contribution\DirectContributionController@PrintDirectContribution');

	// Vouchers
	Route::resource('voucher', 'Voucher\VoucherController');

	Route::get('get_voucher', array('as'=>'get_voucher', 'uses'=>'Voucher\VoucherController@Data'));

	Route::get('print_voucher/{voucher_id}', 'Voucher\VoucherController@PrintVoucher');
	Route::get('print_compromise/{afid}', 'Contribution\DirectContributionController@PrintCompromise');


	// Retirement Fund Procedure
	Route::resource('retirement_fund', 'RetirementFund\RetirementFundController');

	// Applicant
	Route::resource('applicant', 'RetirementFund\ApplicantController');

	Route::get('get_retirement_fund', array('as'=>'get_retirement_fund', 'uses'=>'RetirementFund\RetirementFundController@Data'));

	Route::get('retirement_fund_print_reception/{afid}', 'RetirementFund\RetirementFundController@print_reception');
	Route::get('retirement_fund_print_check_file/{afid}', 'RetirementFund\RetirementFundController@print_check_file');
	Route::get('retirement_fund_print_qualification/{afid}', 'RetirementFund\RetirementFundController@print_qualification');
	Route::get('retirement_fund_print_legal_assessment/{afid}', 'RetirementFund\RetirementFundController@print_legal_assessment');


	// Economic Complement Procedure
	Route::resource('complement_economic', 'EconomicComplement\EconomicComplementController');

	// Complementarity Factor
	Route::resource('complementarity_factor', 'EconomicComplement\ComplementarityFactorController');

	Route::get('get_complementarity_factor', array('as'=>'get_complementarity_factor', 'uses'=>'EconomicComplement\ComplementarityFactorController@Data'));

});

define('ACCESS', 'alerick');
