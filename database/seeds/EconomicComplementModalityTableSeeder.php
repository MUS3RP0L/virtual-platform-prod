<?php

use Illuminate\Database\Seeder;

class EconomicComplementModalityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        Eloquent::unguard();

        $this->EconomicComplementTypes();
        $this->EconomicComplementModalities();
        $this->EconomicComplementStateTypes();
        $this->EconomicComplementStates();

        Eloquent::reguard();
    }

    private function EconomicComplementTypes()
    {
        $statuses = [

            ['name' => 'Vejez'],
            ['name' => 'Viudedad'],
            ['name' => 'Orfandad']

        ];

        foreach ($statuses as $status) {

            Muserpol\EconomicComplementType::create($status);
        }
    }

    private function EconomicComplementModalities()
    {
        $statuses = [

            ['eco_com_type_id' => '1', 'shortened' => 'VEJEZ', 'name' =>'Renta normal', 'description' => 'Renta asociada con el (la) beneficiario (a) titular'],
            ['eco_com_type_id' => '2', 'shortened' => 'VIUDEDAD', 'name' =>'Renta normal', 'description' => 'Renta sociada con el (la) viuda (o) del titular'],
            ['eco_com_type_id' => '3', 'shortened' => 'ORFANDAD', 'name' =>'Renta normal', 'description' => 'Renta asociada con el (la) huérfano (o) del titular'],
            ['eco_com_type_id' => '1', 'shortened' => 'RENT-1COMP-VEJ', 'name' =>'Renta un comp', 'description' => 'Un solo componente'],
            ['eco_com_type_id' => '2', 'shortened' => 'RENT-1COMP-VIU', 'name' =>'Renta un comp', 'description' => 'Un solo componente'],
            ['eco_com_type_id' => '1', 'shortened' => 'RENT-1COM-M2000-VEJ', 'name' =>'Renta un comp menor 2000', 'description' => 'Un solo componente y menor a Bs. 2000,00'],
            ['eco_com_type_id' => '2', 'shortened' => 'RENT-1COM-M2000-VIU', 'name' =>'Renta un comp menor 2000', 'description' => 'Un solo componente y menor a Bs. 2000,00'],
            ['eco_com_type_id' => '1', 'shortened' => 'RENT-M2000-VEJ', 'name' =>'Renta menor a 2000', 'description' => 'Renta menor a Bs. 2000,00'],
            ['eco_com_type_id' => '2', 'shortened' => 'RENT-M2000-VIU', 'name' =>'Renta menor a 2000', 'description' => 'Renta menor a Bs. 2000,00']

        ];

        foreach ($statuses as $status) {

            Muserpol\EconomicComplementModality::create($status);
        }
    }

    private function EconomicComplementStateTypes()
    {
        $statuses = [

            ['name' => 'Pagado'],
            ['name' => 'Suspendido'],
            ['name' => 'Excluido']

        ];

        foreach ($statuses as $status) {

            Muserpol\EconomicComplementStateType::create($status);
        }
    }

    private function EconomicComplementStates()
    {
        $statuses = [



            ['eco_com_state_type_id' => '1', 'name' => 'Banco'],
            ['eco_com_state_type_id' => '1', 'name' => 'Cheque Rezagado'],
            ['eco_com_state_type_id' => '1', 'name' => 'Cheque Adicional'],

            ['eco_com_state_type_id' => '2', 'name' => 'Cuentas por cobrar - Contabilidad'],
            ['eco_com_state_type_id' => '2', 'name' => 'Estado de mora - Préstamos'],
            ['eco_com_state_type_id' => '2', 'name' => 'Doble Percepción'],
            ['eco_com_state_type_id' => '2', 'name' => 'Denuncia'],
            ['eco_com_state_type_id' => '2', 'name' => 'Falta de Requisitos'],

            ['eco_com_state_type_id' => '3', 'name' => 'Invalidez'],
            ['eco_com_state_type_id' => '3', 'name' => 'Menor a 13 años de Servicio'],
            ['eco_com_state_type_id' => '3', 'name' => 'Proceso judicial'],
            ['eco_com_state_type_id' => '3', 'name' => 'Salario mayor del activo'],
            ['eco_com_state_type_id' => '3', 'name' => 'Baja'],
            ['eco_com_state_type_id' => '3', 'name' => 'Matrimonio de hecho']

        ];

        foreach ($statuses as $status) {

            Muserpol\EconomicComplementState::create($status);
        }
    }
}
