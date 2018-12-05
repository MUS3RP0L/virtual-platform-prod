<?php

use Illuminate\Database\Seeder;

class EcoComObservationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $values=[
	        [ 'module_id'=> 2, 'name' => 'PAGO A FUTURO', 'description' => '', 'type' => 'T'],
		];
		foreach ($values as $val) {
		    Muserpol\ObservationType::create($val);
		}
    }
}
