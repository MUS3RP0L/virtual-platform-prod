<?php

use Illuminate\Database\Seeder;

class ContributionTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        Eloquent::unguard();

        $this->createContributionTypes();

        Eloquent::reguard();
    }

    private function createContributionTypes()
    {
        $statuses = [

            ['name' => 'Comando'],
            ['name' => 'Voluntario']

        ];

        foreach ($statuses as $status) {

            Muserpol\ContributionType::create($status);
            
        }
    }

}
