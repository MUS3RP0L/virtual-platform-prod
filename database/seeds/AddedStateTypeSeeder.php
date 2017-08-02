<?php

use Illuminate\Database\Seeder;

class AddedStateTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        DB::table('eco_com_state_types')->insert([
            'name' => 'Proceso',
        ]);
        $e=Muserpol\EconomicComplementStateType::where('name','=','Proceso')->first();
        DB::table('eco_com_states')->insert([
            'eco_com_state_type_id' => $e->id,
            'name' => 'En Proceso',
        ]);
        Eloquent::reguard();
    }
}
