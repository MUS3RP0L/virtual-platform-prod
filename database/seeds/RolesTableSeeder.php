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
          ['module_id' => '2', 'name' => 'Aprobación'],
          ['module_id' => '2', 'name' => 'Certificación'],
          ['module_id' => '2', 'name' => 'Presupuesto'],
          ['module_id' => '3', 'name' => 'Recepción'],
          ['module_id' => '3', 'name' => 'Revision'],
          ['module_id' => '3', 'name' => 'Calificación'],
          ['module_id' => '4', 'name' => 'Dictamen Legal'],
          ['module_id' => '4', 'name' => 'Archivo']
      ];

        foreach ($statuses as $status) {
            Muserpol\Role::create($status);
        }
    }
}
