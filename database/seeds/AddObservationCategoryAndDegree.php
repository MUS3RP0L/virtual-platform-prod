<?php

use Illuminate\Database\Seeder;

class AddObservationCategoryAndDegree extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
    	 DB::table('observation_types')->insert([
            'module_id' => '2',
            'name' => 'Observación por Categoria',
            'description' => ' Suspendido por cambio indevido de Categoria',
        ]);

    	 DB::table('observation_types')->insert([
            'module_id' => '2',
            'name' => 'Observación por Grado',
            'description' => ' Suspendido por cambio indevido de Grado',
        ]);
    }
}
