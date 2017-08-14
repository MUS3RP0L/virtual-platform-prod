<?php

use Illuminate\Database\Seeder;

class AddObsertionTypePay extends Seeder
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
            'name' => 'Observación por pago a domicilio',
            'description' => ' Referente al pago a domicilio',
        ]);
    }
}
	