<?php

use Illuminate\Database\Seeder;

class AddNewsObservationType extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('observation_types')->insert([
        	'module_id' => '2',
            'name' => 'Observación por Concurrencia',
            'description' => 'Referente a percepción de una pensión por Jubilación y simultáneamente la prestación de invalidez (concurrencia)'
        ]);

        DB::table('observation_types')->insert([
        	'module_id' => '2',
        	'name' => 'Observación Salario por Concurrencia',
        	'description' => 'Referente a percibir la pensión de vejez o solidaria de vejez y simultáneamente la prestación de invalidez (concurrencia)'
        ]);

        DB::table('observation_types')->insert([
        	'module_id' => '2',
        	'name' => 'Observación Calificación Correcta',
        	'description' => 'Referente a no existencia en error del monto pagado'
        ]);
    }
}
