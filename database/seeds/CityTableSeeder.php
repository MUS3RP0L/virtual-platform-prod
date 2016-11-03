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

            ['name' => 'BENI', 'shortened' => 'BN', 'second_shortened' => 'BEN', 'third_shortened' => 'BNI'],
            ['name' => 'CHUQUISACA', 'shortened' => 'CH', 'second_shortened' => 'SUC', 'third_shortened' => 'CHQ'],
            ['name' => 'COCHABAMBA', 'shortened' => 'CB', 'second_shortened' => 'CBB', 'third_shortened' => 'CBB'],
            ['name' => 'LA PAZ', 'shortened' => 'LP', 'second_shortened' => 'LPZ', 'third_shortened' => 'LPZ'],
            ['name' => 'ORURO', 'shortened' => 'OR', 'second_shortened' => 'ORU', 'third_shortened' => 'ORU'],
            ['name' => 'PANDO', 'shortened' => 'PN', 'second_shortened' => 'PDO', 'third_shortened' => 'PND'],
            ['name' => 'POTOSÍ', 'shortened' => 'PT', 'second_shortened' => 'PTS', 'third_shortened' => 'PTS'],
            ['name' => 'SANTA CRUZ', 'shortened' => 'SC', 'second_shortened' => 'SCZ', 'third_shortened' => 'SCZ'],
            ['name' => 'TARIJA', 'shortened' => 'TJ', 'second_shortened' => 'TJA', 'third_shortened' => 'TRJ']

        ];

        foreach ($statuses as $status) {

            Muserpol\City::create($status);

        }
    }
}
