<?php

use Illuminate\Database\Seeder;


class monthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
         Eloquent::unguard();

        $this->createMonths();

        Eloquent::reguard();
     
    }
    private function createMonths()
    {
    	 $months = [
	      ['name' => 'Enero'],
	      ['name' => 'Febrero'],
	      ['name' => 'Marzo'],
	      ['name' => 'Abril'],
	      ['name' => 'Mayo'],
	      ['name' => 'Junio'],
	      ['name' => 'Julio'],
	      ['name' => 'Agosto'],
	      ['name' => 'Septiembre'],
	      ['name' => 'Octubre'],
	      ['name' => 'Noviembre'],
	      ['name' => 'Diciembre']
	   
	      ];

	      foreach ($months as $month) {

		     Muserpol\Month::create($month);
	      }
    }
}
