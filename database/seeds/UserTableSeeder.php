<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
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
    	$userAdmin=Muserpol\User::create([

            'first_name' => 'Alejandro Erick',
            'last_name' => 'Guisbert Flor',
        	'phone' => '77551112',
        	'username' => 'aguisbert',
        	'password' => bcrypt('admin')
        	//'role_id' => '1'

        ]);

        DB::table('role_user')->insert([
              'user_id'=>1,
              'role_id'=>1,
              'created_at'=>Carbon::now(),
              'updated_at'=>Carbon::now(),

        ]);
    }
}
