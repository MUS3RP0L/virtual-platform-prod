<?php

use Illuminate\Database\Seeder;

class ObservationTypeTableSeeder extends Seeder
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

        Eloquent::reguard();
    }
    private function createObservationType(){
        $statuses = [

            ['module_id' => '8', 'name' => 'observacion por contabilidad','description'=>'se comunica Elija un elemento. figura como deudor por cuentas por cobrar en el Sistema contable de la MUSERPOL'],
            ['module_id' => '6', 'name' => 'observacion por prestamos','description'=>'se comunica a usted que Elija un elemento.figura como deudor, por registrar cartera en mora por préstamos otorgados por la MUSERPOL.'],
            ['module_id' => '7', 'name' => 'observacion por juridica','description'=>'se comunica que Elija un elemento. figura como Elija un elemento. en los procesos judiciales seguido por la MUSEPOL y/o MUSERPOL.'],

        ];

        foreach ($statuses as $status) {

            Muserpol\ObservationType::create($status);

        }
    }

}
