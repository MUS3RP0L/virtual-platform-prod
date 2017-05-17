<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        Eloquent::unguard();

        $this->createCities();

        Eloquent::reguard();
    }

    private function createCities()
    {
        $statuses = [

            ['name' => 'BENI', 'first_shortened' => 'BN', 'second_shortened' => 'BEN', 'third_shortened' => 'BNI'],
            ['name' => 'CHUQUISACA', 'first_shortened' => 'CH', 'second_shortened' => 'SUC', 'third_shortened' => 'CHQ'],
            ['name' => 'COCHABAMBA', 'first_shortened' => 'CB', 'second_shortened' => 'CBB', 'third_shortened' => 'CBB'],
            ['name' => 'LA PAZ', 'first_shortened' => 'LP', 'second_shortened' => 'LPZ', 'third_shortened' => 'LPZ'],
            ['name' => 'ORURO', 'first_shortened' => 'OR', 'second_shortened' => 'ORU', 'third_shortened' => 'ORU'],
            ['name' => 'PANDO', 'first_shortened' => 'PD', 'second_shortened' => 'PDO', 'third_shortened' => 'PND'],
            ['name' => 'POTOSI', 'first_shortened' => 'PT', 'second_shortened' => 'PTS', 'third_shortened' => 'PTS'],
            ['name' => 'SANTA CRUZ', 'first_shortened' => 'SC', 'second_shortened' => 'SCZ', 'third_shortened' => 'SCZ'],
            ['name' => 'TARIJA', 'first_shortened' => 'TJ', 'second_shortened' => 'TJA', 'third_shortened' => 'TRJ']

        ];

        foreach ($statuses as $status) {

            Muserpol\City::create($status);

        }
    }
}
