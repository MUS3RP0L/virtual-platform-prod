<?php

use Illuminate\Database\Seeder;

class AffiliateTypeandStateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        Eloquent::unguard();

        $this->createAffiliateTypes();
        $this->createStateType();
        $this->createaffiliateState();

        Eloquent::reguard();
    }

    private function createAffiliateTypes()
    {
        $statuses = [

            ['name' => 'Comando'],
            ['name' => 'Batallón']

        ];

        foreach ($statuses as $status) {

            Muserpol\AffiliateType::create($status);
        }
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

            ['state_type_id' => '1', 'name' => 'Servicio'],
            ['state_type_id' => '1', 'name' => 'Comisión'],
            ['state_type_id' => '1', 'name' => 'Disponibilidad'],

            ['state_type_id' => '2', 'name' => 'Fallecido'],
            ['state_type_id' => '2', 'name' => 'Jubilado'],
            ['state_type_id' => '2', 'name' => 'Jubilado Invalidez'],

            ['state_type_id' => '3', 'name' => 'Baja Forzosa'],
            ['state_type_id' => '3', 'name' => 'Baja Voluntaria'],
            ['state_type_id' => '3', 'name' => 'Baja Temporal']

        ];

        foreach ($statuses as $status) {

            Muserpol\AffiliateState::create($status);
        }
    }
}
