<?php

use Illuminate\Database\Seeder;

class ApplicantTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        Eloquent::unguard();

        $this->createApplicantTypes();

        Eloquent::reguard();
    }

    private function createApplicantTypes()
    {
        $statuses = [

            ['name' => 'Titular'],
            ['name' => 'Conyuge'],
            ['name' => 'Hijo'],
            ['name' => 'Otro']

        ];

        foreach ($statuses as $status) {

                Muserpol\ApplicantType::create($status);

        }
    }
}
