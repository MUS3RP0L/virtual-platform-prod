<?php

use Illuminate\Database\Seeder;

class ContributionRate2TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        Eloquent::unguard();

        $this->createContributionRates();

        Eloquent::reguard();
    }

    private function createContributionRates()
    {
        $statuses = [
			['month_year' => '2017-5-1', 'retirement_fund' =>'1.850', 'mortuary_quota' =>'0.650', 'retirement_fund_commission' =>'1.850', 'mortuary_quota_commission'  =>'0.650', 'mortuary_aid' => '1.5000', 'user_id' => '1'],
			['month_year' => '2017-6-1', 'retirement_fund' =>'1.850', 'mortuary_quota' =>'0.650', 'retirement_fund_commission' =>'1.850', 'mortuary_quota_commission'  =>'0.650', 'mortuary_aid' => '1.5000', 'user_id' => '1'],
			['month_year' => '2017-7-1', 'retirement_fund' =>'1.850', 'mortuary_quota' =>'0.650', 'retirement_fund_commission' =>'1.850', 'mortuary_quota_commission'  =>'0.650', 'mortuary_aid' => '1.5000', 'user_id' => '1'],
			['month_year' => '2017-8-1', 'retirement_fund' =>'1.850', 'mortuary_quota' =>'0.650', 'retirement_fund_commission' =>'1.850', 'mortuary_quota_commission'  =>'0.650', 'mortuary_aid' => '1.5000', 'user_id' => '1'],
			['month_year' => '2017-9-1', 'retirement_fund' =>'1.850', 'mortuary_quota' =>'0.650', 'retirement_fund_commission' =>'1.850', 'mortuary_quota_commission'  =>'0.650', 'mortuary_aid' => '1.5000', 'user_id' => '1'],
        ];

        foreach ($statuses as $status) {
            Muserpol\ContributionRate::create($status);
        }
    }
}
