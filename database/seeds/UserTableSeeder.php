<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Eloquent::unguard();

        $this->createAdmin();

        Eloquent::reguard();
    }

    private function createAdmin()
    {
    	Muserpol\User::create([

            'first_name' => 'Alejandro Erick',
            'last_name' => 'Guisbert Flor',
        	'phone' => '77551112',
        	'username' => 'aguisbert',
        	'password' => bcrypt('admin'),
        	'role_id' => '1'

        ]);
    }
}
