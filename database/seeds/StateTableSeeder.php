<?php

use Illuminate\Database\Seeder;

class StateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        Eloquent::unguard();

        $this->createStateType();
        $this->createaffiliateState();

        Eloquent::reguard();
    }


    private function createStateType()
    {
        $statuses = [

            ['name' => 'Activo'],
            ['name' => 'Pasivo'],
            ['name' => 'Baja']

        ];

        foreach ($statuses as $status) {

            Muserpol\StateType::create($status);
        }
    }

    private function createaffiliateState()
    {
        $statuses = [

            ['affiliate_state_type_id' => '1', 'name' => 'Servicio'],
            ['affiliate_state_type_id' => '1', 'name' => 'Comisión'],
            ['affiliate_state_type_id' => '1', 'name' => 'Disponibilidad'],

            ['affiliate_state_type_id' => '2', 'name' => 'Fallecido'],
            ['affiliate_state_type_id' => '2', 'name' => 'Jubilado'],
            ['affiliate_state_type_id' => '2', 'name' => 'Jubilado Invalidez'],

            ['affiliate_state_type_id' => '3', 'name' => 'Baja Forzosa'],
            ['affiliate_state_type_id' => '3', 'name' => 'Baja Voluntaria'],
            ['affiliate_state_type_id' => '3', 'name' => 'Baja Temporal']

        ];

        foreach ($statuses as $status) {

            Muserpol\AffiliateState::create($status);
        }
    }
}
