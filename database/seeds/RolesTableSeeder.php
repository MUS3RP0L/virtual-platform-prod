<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
   * Run the database seeds.
   *
   * @return void
   */

  public function run()
  {
      Eloquent::unguard();

      $this->createModules();
      $this->createRoles();

      Eloquent::reguard();
  }

    private function createRoles()
    {
        $statuses = [

          ['module_id' => '1', 'name' => 'SuperAdmin'],
          ['module_id' => '2', 'name' => 'Recepción'],
          ['module_id' => '2', 'name' => 'Revisión'],
          ['module_id' => '2', 'name' => 'Archivo'],
          ['module_id' => '2', 'name' => 'Calificación'],
          ['module_id' => '2', 'name' => 'Dictamen Legal'],
          ['module_id' => '2', 'name' => 'Responsable'],
          ['module_id' => '3', 'name' => 'Recepción'],
          ['module_id' => '3', 'name' => 'Revisión'],
          ['module_id' => '3', 'name' => 'Responsable'],
          ['module_id' => '4', 'name' => 'Responsable'],
          ['module_id' => '5', 'name' => 'Responsable'],
          ['module_id' => '6', 'name' => 'Responsable'],
          ['module_id' => '7', 'name' => 'Responsable'],
          ['module_id' => '8', 'name' => 'Responsable']


      ];

        foreach ($statuses as $status) {
            Muserpol\Role::create($status);
        }
    }
}
