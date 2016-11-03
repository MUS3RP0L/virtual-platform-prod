<?php

use Illuminate\Database\Seeder;

class BreakdownTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        Eloquent::unguard();

        $this->createBreakdowns();

        Eloquent::reguard();
    }

    private function createBreakdowns()
    {
        $statuses = [

            ['code' => '1', 'name' => 'Disponibilidad'],// Servicio Disponibilidad *
            ['code' => '2', 'name' => 'Dir. Nal. Pofoma'],//Servicio
            ['code' => '3', 'name' => 'Item Cero'],//Comisión *
            ['code' => '4', 'name' => 'S/N'],//
            ['code' => '5', 'name' => 'Bat. Seg. Física Privada'],//Servicio Batallón *
            ['code' => '6', 'name' => 'Juzgados Policiales'],//Servicio
            ['code' => '7', 'name' => 'S/N'],//
            ['code' => '8', 'name' => 'Escuadrón de Seg. Los Pumas'],//Servicio
            ['code' => '9', 'name' => 'Dir. Nal. Seg. Penitenciaria'],//Servicio
            ['code' => '0', 'name' => 'Servicio']//Servicio



        ];

        foreach ($statuses as $status) {

            Muserpol\Breakdown::create($status);

        }
    }
}
