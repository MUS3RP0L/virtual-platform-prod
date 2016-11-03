<?php

use Illuminate\Database\Seeder;

class RetirementFundModalityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        Eloquent::unguard();

        $this->createRetirementFundModalities();

        Eloquent::reguard();
    }

    private function createRetirementFundModalities()
    {
        $statuses = [

            ['shortened' => 'Baja Forzosa', 'name' => 'Retiro por Baja Forzosa'],
            ['shortened' => 'Baja Voluntaria', 'name' => 'Retiro por Baja Voluntaria'],
            ['shortened' => 'Jubilación', 'name' => 'Retiro por Jubilación'],
            ['shortened' => 'Fallecimiento', 'name' => 'Retiro por Fallecimiento'],
            ['shortened' => 'Devolución', 'name' => 'Devolución de Descuentos al Garante']
        
        ];

        foreach ($statuses as $status) {
         
            Muserpol\RetirementFundModality::create($status);
        }
    }
}
