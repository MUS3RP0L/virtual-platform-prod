<?php

use Illuminate\Database\Seeder;

class ObservationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       Eloquent::unguard();
       $this->createObservationType();
       $this->createRoles();
       Eloquent::reguard();
    }

    private function createObservationType(){
        $statuses = [
            ['module_id' => '2', 'name' => 'Observación Fuera de Plazo 90 días', 'description' => 'se comunica a usted que su trámite ingresó fuera de plazo.'],
            ['module_id' => '2', 'name' => 'Observación Fuera de Plazo 120 días', 'description' => 'se comunica a usted que su trámite ingresó fuera de plazo.'],
            ['module_id' => '2', 'name' => 'Observación Falta de Requisitos', 'description' => 'se comunica a usted que no cumple con los requisitos establecidos según reglamento vigente.'],
            ['module_id' => '2', 'name' => 'Observación Falta de Requisitos Habitual a Inclusión', 'description' => 'se comunica a usted que tiene un plazo de 90 días para gestionar la documentación faltante.'],
            ['module_id' => '2', 'name' => 'Observación Menor a 16 años de Servicio', 'description' => 'se comunica a usted que no acredita como mínimo 16 años de servicio en la Policia Boliviana.'],
            ['module_id' => '2', 'name' => 'Observación por Invalidez', 'description' => 'se comunica a usted que percibe una prestación por invalidez común.'],
            ['module_id' => '2', 'name' => 'Observación por Salario', 'description' => 'se comunica a usted que es excluido por salario.'],
            ['module_id' => '2', 'name' => 'General Complemento Económico', 'description' => 'observación general por complemento económico'],

        ];

        foreach ($statuses as $status) {

            Muserpol\ObservationType::create($status);

        }
    }

    private function createRoles()
    {
        $statuses = [
	        ['module_id' => '6', 'name' => 'Préstamos', 'action'=> 'Comporbante Realizado'],
	        ['module_id' => '7', 'name' => 'Jurídica', 'action'=> 'Comprobante Realizado'],
        ];

        foreach ($statuses as $status) {
            Muserpol\Role::create($status);
        }
    }


}
