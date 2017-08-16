<?php

use Illuminate\Database\Seeder;

class AddObservacionReposicionFondos extends Seeder
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
            'name' => 'Suspención por Reposición de fondos',
            'description' => ' Suspendido por Reposición de fondos',
        ]);
    }
}
