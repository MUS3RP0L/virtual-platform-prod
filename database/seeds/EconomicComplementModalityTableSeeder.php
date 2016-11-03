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

            ['eco_com_type_id' => '1', 'name' => 'Vejez', 'description' => 'Renta asociada con el (la) beneficiario (a) titular'],
            ['eco_com_type_id' => '2', 'name' => 'Viudedad', 'description' => 'Renta sociada con el (la) viuda (o) del titular'],
            ['eco_com_type_id' => '3', 'name' => 'Orfandad', 'description' => 'Renta asociada con el (la) huérfano (o) del titular'],
            ['eco_com_type_id' => '1', 'name' => 'RENT-1COMP-VEJ', 'description' => 'Un solo componente'],
            ['eco_com_type_id' => '2', 'name' => 'RENT-1COMP-VIU', 'description' => 'Un solo componente'],
            ['eco_com_type_id' => '1', 'name' => 'RENT-1COM-M2000-VEJ', 'description' => 'Un solo componente y menor a Bs. 2000,00'],
            ['eco_com_type_id' => '2', 'name' => 'RENT-1COM-M2000-VIU', 'description' => 'Un solo componente y menor a Bs. 2000,00'],
            ['eco_com_type_id' => '1', 'name' => 'RENT-M2000-VEJ', 'description' => 'Renta menor a Bs. 2000,00'],
            ['eco_com_type_id' => '2', 'name' => 'RENT-M2000-VIU', 'description' => 'Renta menor a Bs. 2000,00']

        ];

        foreach ($statuses as $status) {

            Muserpol\EconomicComplementModality::create($status);
        }
    }
}
