<?php

use Illuminate\Database\Seeder;

class ComplementaryFactorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        Eloquent::unguard();

        $this->createComplementaryFactors();

        Eloquent::reguard();
    }

    private function createComplementaryFactors()
    {
        $statuses = [

            ['user_id' => '1', 'year' => '2016-1-1', 'semester' => 'Segundo', 'normal_start_date' => '2016-1-1', 'normal_end_date' => '2016-12-1', 'lagging_start_date' => '2016-1-1', 'lagging_end_date' => '2016-12-1', 'additional_start_date' => '2016-1-1', 'additional_end_date' => '2016-12-1'],
            ['user_id' => '1', 'year' => '2017-1-1', 'semester' => 'Primer', 'normal_start_date' => '2017-1-1', 'normal_end_date' => '2017-12-1', 'lagging_start_date' => '2017-1-1', 'lagging_end_date' => '2017-12-1', 'additional_start_date' => '2017-1-1', 'additional_end_date' => '2017-12-1']

        ];

        foreach ($statuses as $status) {

            Muserpol\EconomicComplementProcedure::create($status);

        }

        $statuses = [

            ['user_id' => '1', 'hierarchy_id' => '1', 'year' => '2015-1-1', 'semester' => 'Segundo', 'old_age' => '65', 'widowhood' => '75'],
            ['user_id' => '1', 'hierarchy_id' => '2', 'year' => '2015-1-1', 'semester' => 'Segundo', 'old_age' => '75', 'widowhood' => '75'],
            ['user_id' => '1', 'hierarchy_id' => '3', 'year' => '2015-1-1', 'semester' => 'Segundo', 'old_age' => '72', 'widowhood' => '72'],
            ['user_id' => '1', 'hierarchy_id' => '4', 'year' => '2015-1-1', 'semester' => 'Segundo', 'old_age' => '88', 'widowhood' => '82'],
            ['user_id' => '1', 'hierarchy_id' => '5', 'year' => '2015-1-1', 'semester' => 'Segundo', 'old_age' => '72', 'widowhood' => '72'],

            ['user_id' => '1', 'hierarchy_id' => '1', 'year' => '2016-1-1', 'semester' => 'Primer', 'old_age' => '61', 'widowhood' => '71'],
            ['user_id' => '1', 'hierarchy_id' => '2', 'year' => '2016-1-1', 'semester' => 'Primer', 'old_age' => '71', 'widowhood' => '71'],
            ['user_id' => '1', 'hierarchy_id' => '3', 'year' => '2016-1-1', 'semester' => 'Primer', 'old_age' => '70', 'widowhood' => '70'],
            ['user_id' => '1', 'hierarchy_id' => '4', 'year' => '2016-1-1', 'semester' => 'Primer', 'old_age' => '86', 'widowhood' => '80'],
            ['user_id' => '1', 'hierarchy_id' => '5', 'year' => '2016-1-1', 'semester' => 'Primer', 'old_age' => '70', 'widowhood' => '70'],

            ['user_id' => '1', 'hierarchy_id' => '1', 'year' => '2016-1-1', 'semester' => 'Segundo', 'old_age' => '61', 'widowhood' => '71'],
            ['user_id' => '1', 'hierarchy_id' => '2', 'year' => '2016-1-1', 'semester' => 'Segundo', 'old_age' => '71', 'widowhood' => '71'],
            ['user_id' => '1', 'hierarchy_id' => '3', 'year' => '2016-1-1', 'semester' => 'Segundo', 'old_age' => '70', 'widowhood' => '70'],
            ['user_id' => '1', 'hierarchy_id' => '4', 'year' => '2016-1-1', 'semester' => 'Segundo', 'old_age' => '86', 'widowhood' => '80'],
            ['user_id' => '1', 'hierarchy_id' => '5', 'year' => '2016-1-1', 'semester' => 'Segundo', 'old_age' => '70', 'widowhood' => '70'],
            
            ['user_id' => '1', 'hierarchy_id' => '1', 'year' => '2017-1-1', 'semester' => 'Primer', 'old_age' => '61', 'widowhood' => '71'],
            ['user_id' => '1', 'hierarchy_id' => '2', 'year' => '2017-1-1', 'semester' => 'Primer', 'old_age' => '71', 'widowhood' => '71'],
            ['user_id' => '1', 'hierarchy_id' => '3', 'year' => '2017-1-1', 'semester' => 'Primer', 'old_age' => '70', 'widowhood' => '70'],
            ['user_id' => '1', 'hierarchy_id' => '4', 'year' => '2017-1-1', 'semester' => 'Primer', 'old_age' => '86', 'widowhood' => '80'],
            ['user_id' => '1', 'hierarchy_id' => '5', 'year' => '2017-1-1', 'semester' => 'Primer', 'old_age' => '70', 'widowhood' => '70']
    
        ];

        foreach ($statuses as $status) {

            Muserpol\ComplementaryFactor::create($status);

        }
    }
}
