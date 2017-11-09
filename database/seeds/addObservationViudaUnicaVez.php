<?php

use Illuminate\Database\Seeder;

class addObservationViudaUnicaVez extends Seeder
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
        	'id'=>20,
            'module_id' => '2',
            'name' => 'Pago a Viuda por única vez',
            'description' => ' Referente al pago al pago de vuida por unica vez',
        ]);
    }
}
