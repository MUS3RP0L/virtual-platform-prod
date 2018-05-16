<?php

use Illuminate\Database\Seeder;

class ContributionRate2018TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contribution_rate = new Muserpol\ContributionRate();
        $contribution_rate->month_year = '2018-01-01';
        $contribution_rate->retirement_fund = '4.77';
        $contribution_rate->mortuary_quota = '1.09';
        $contribution_rate->retirement_fund_commission = '4.77';
        $contribution_rate->mortuary_quota_commission = '1.09';
        $contribution_rate->mortuary_aid = '2.03';
        $contribution_rate->user_id = 1;
        $contribution_rate->save();
    }
}
