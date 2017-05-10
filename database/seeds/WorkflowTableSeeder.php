<?php

use Illuminate\Database\Seeder;

class WorkflowTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        $this->createModules();
        $this->createWorkflows();

        Eloquent::reguard();
    }

    private function createModules()
    {
        $statuses = [

            ['name' => 'Complemento Económico', 'description' => 'Unidad complemento económico'],
            ['name' => 'Fondo de Retiro','description' => 'Unidad de fondo de retiro'],
            ['name' => 'Cuota Mortuoria','description' => ''],
            ['name' => 'Auxilio Mortuoria','description' => ''],
            ['name' => 'Prestamos','description' => 'Unidad de prestamos']

        ];

        foreach ($statuses as $status) {

            Muserpol\Module::create($status);
        }
    }

    private function createWorkFlows()
    {
        $statuses = [

            ['module_id' =>'1','name' => 'Complemento Económico', 'description' => 'Flujo de complemento económico'],
            ['module_id' => '2','name' => 'Fondo de Retiro','description' => 'Flujo de fondo de retiro'],
            ['module_id' => '3','name' => 'Cuota Mortuoria','description' => 'Flujo de cuota mortuoria'],
            ['module_id' => '4','name' => 'Auxilio Mortuoria','description' => 'Flujo de auxilio mortuoria'],
            ['module_id' => '5','name' => 'Prestamos','description' => 'Flujo de prestamos']

        ];

        foreach ($statuses as $status) {

            Muserpol\Workflow::create($status);
        }
    }
}
