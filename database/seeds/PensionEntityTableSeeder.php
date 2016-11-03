<?php

use Illuminate\Database\Seeder;

class PensionEntityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        Eloquent::unguard();

        $this->createPensionEntities();

        Eloquent::reguard();
    }

    private function createPensionEntities()
    {
        $statuses = [

            ['type' => 'APS', 'name' => 'AFP FUTURO'],
            ['type' => 'APS','name' => 'AFP PREVISION'],
            ['type' => 'APS','name' => 'LA VITALICIA'],
            ['type' => 'APS','name' => 'PROVIDA'],
            ['type' => 'SENASIR','name' => 'SENASIR']

        ];

        foreach ($statuses as $status) {

            Muserpol\PensionEntity::create($status);
        }
    }
}
