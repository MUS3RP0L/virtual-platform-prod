<?php

use Illuminate\Database\Seeder;

class EconomicComplementApplicantTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        $this->createEconomicComplementApplicantTypes();

        Eloquent::reguard();
    }

    private function createEconomicComplementApplicantTypes()
    {
        $statuses = [

            ['name' => 'Titular'],
            ['name' => 'Conyuge'],
            ['name' => 'Hijo']

        ];

        foreach ($statuses as $status) {

            Muserpol\EconomicComplementApplicantType::create($status);

        }
    }
}
