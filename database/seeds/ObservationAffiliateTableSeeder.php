<?php

use Illuminate\Database\Seeder;

class ObservationAffiliateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();
        $this->createObservationStates();
        $this->createObservationTypes();

        Eloquent::reguard();
    }

    private function createObservationStates()
    {
        $statuses = [
            ['name' => 'Activo'],
            ['name' => 'Bloqueado']
        ];

        foreach ($statuses as $status) {
            Muserpol\ObservationState::create($status);
        }
    }

    private function createObservationTypes()
    {
        $statuses = [
                //suspendidos
                ['observation_state_id' => '1','module_id' => '8','type' =>'Suspendido','observation' => 'Observación Contabilidad - Cuentas por cobrar','enable1' => '1','enable2' => '0','pending' => '1'],
                ['observation_state_id' => '1','module_id' => '6','type' =>'Suspendido','observation' => 'Observación Prestamos - Estado en mora','enable1' => '1','enable2' => '0','pending' => '1'],
                ['observation_state_id' => '1','module_id' => '2','type' =>'Suspendido','observation' => 'Observación Complemento - Falta de Requisitos','enable1' => '1','enable2' => '0','pending' => '1'],
                ['observation_state_id' => '1','module_id' => '2','type' =>'Suspendido','observation' => 'Observación Complemento - Falta de Requisitos habitual a inclusión','enable1' => '1','enable2' => '0','pending' => '1'],
                //Excluidos
                ['observation_state_id' => '1','module_id' => '2','type' =>'Excluido','observation' => 'Observación Complemento - Doble Percepción','enable1' => '1','enable2' => '0','pending' => '1'],
                ['observation_state_id' => '1','module_id' => '2','type' =>'Excluido','observation' => 'Observación Complemento - Dado de Baja','enable1' => '1','enable2' => '0','pending' => '1'],
                ['observation_state_id' => '1','module_id' => '2','type' =>'Excluido','observation' => 'Observación Complemento - Salario mayor al activo','enable1' => '1','enable2' => '0','pending' => '1'],
                ['observation_state_id' => '1','module_id' => '2','type' =>'Excluido','observation' => 'Observación Complemento - Menor a 16 años de servicio','enable1' => '1','enable2' => '0','pending' => '1'],
                ['observation_state_id' => '1','module_id' => '2','type' =>'Excluido','observation' => 'Observación Complemento - Matrimonio de hecho','enable1' => '1','enable2' => '0','pending' => '1'],
                ['observation_state_id' => '1','module_id' => '2','type' =>'Excluido','observation' => 'Observación Complemento - Invalidez','enable1' => '1','enable2' => '0','pending' => '1'],
                ['observation_state_id' => '1','module_id' => '7','type' =>'Excluido', 'observation' => 'Observación Jurídica - Proceso judicial','enable1' => '1','enable2' => '0','pending' => '1']
        ];

        foreach ($statuses as $status) {
            Muserpol\ObservationType::create($status);
        }
    }
}
