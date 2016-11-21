<?php

use Illuminate\Database\Seeder;

class DegreeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        Eloquent::unguard();

        $this->createHierarchies();
        $this->createDegrees();

        Eloquent::reguard();
    }

    private function createHierarchies()
    {
        $statuses = [

            ['code' => '00', 'name' => 'GENERALES'],
            ['code' => '01', 'name' => 'JEFES Y OFICIALES'],
            ['code' => '02', 'name' => 'JEFES Y OFICIALES ADMINISTRATIVOS'],
            ['code' => '03', 'name' => 'SUBOFICIALES, CLASES Y POLICIAS'],
            ['code' => '04', 'name' => 'SUBOFICIALES, CLASES Y POLICIAS ADMINSTRATIVOS']

        ];

        foreach ($statuses as $status) {

            Muserpol\Hierarchy::create($status);

        }
    }

    private function createDegrees()
    {
        $statuses = [

            ['hierarchy_id' => '1', 'code' => '00', 'name' => 'COMANDANTE GRAL', 'shortened' => 'CMTE. GRAL.'],
            ['hierarchy_id' => '1', 'code' => '01', 'name' => 'COMANDANTE GRAL', 'shortened' => 'CMTE. GRAL.'],
            ['hierarchy_id' => '1', 'code' => '02', 'name' => 'SUBCOMANDANTE', 'shortened' => 'SBCMTE. GRAL.'],
            ['hierarchy_id' => '1', 'code' => '03', 'name' => 'INSPECTOR GENERAL', 'shortened' => 'INSP. GRAL.'],
            ['hierarchy_id' => '1', 'code' => '04', 'name' => 'DIRECTOR GENERAL', 'shortened' => 'DIR. GRAL.'],

            ['hierarchy_id' => '2', 'code' => '01', 'name' => 'CORONEL CON SUELDO DE GENERAL', 'shortened' => 'CNL.'],
            ['hierarchy_id' => '2', 'code' => '02', 'name' => 'CORONEL', 'shortened' => 'CNL.'],
            ['hierarchy_id' => '2', 'code' => '03', 'name' => 'TENIENTE CORONEL', 'shortened' => 'TCNL.'],
            ['hierarchy_id' => '2', 'code' => '04', 'name' => 'MAYOR', 'shortened' => 'MY.'],
            ['hierarchy_id' => '2', 'code' => '05', 'name' => 'CAPITAN', 'shortened' => 'CAP.'],
            ['hierarchy_id' => '2', 'code' => '06', 'name' => 'TENIENTE', 'shortened' => 'TTE.'],
            ['hierarchy_id' => '2', 'code' => '07', 'name' => 'SUBTENIENTE', 'shortened' => 'SBTTE.'],

            ['hierarchy_id' => '3', 'code' => '02', 'name' => 'CORONEL ADMINISTRATIVO', 'shortened' => 'CNL. ADM.'],
            ['hierarchy_id' => '3', 'code' => '03', 'name' => 'TENIENTE CORONEL ADMINISTRATIVO', 'shortened' => 'TCNL. ADM.'],
            ['hierarchy_id' => '3', 'code' => '04', 'name' => 'MAYOR ADMINISTRATIVO', 'shortened' => 'MY. ADM.'],
            ['hierarchy_id' => '3', 'code' => '05', 'name' => 'CAPITAN ADMINISTRATIVO', 'shortened' => 'CAP. ADM.'],
            ['hierarchy_id' => '3', 'code' => '06', 'name' => 'TENIENTE ADMINISTRATIVO', 'shortened' => 'TTE. ADM.'],
            ['hierarchy_id' => '3', 'code' => '07', 'name' => 'SUBTENIENTE ADMINISTRATIVO', 'shortened' => 'SBTTE. ADM.'],

            ['hierarchy_id' => '4', 'code' => '08', 'name' => 'SUBOFICIAL SUPERIOR', 'shortened' => 'SOF. SUP.'],
            ['hierarchy_id' => '4', 'code' => '09', 'name' => 'SUBOFICIAL MAYOR', 'shortened' => 'SOF. MY.'],
            ['hierarchy_id' => '4', 'code' => '10', 'name' => 'SUBOFICIAL PRIMERO', 'shortened' => 'SOF. 1RO.'],
            ['hierarchy_id' => '4', 'code' => '11', 'name' => 'SUBOFICIAL SEGUNDO', 'shortened' => 'SOF. 2DO.'],
            ['hierarchy_id' => '4', 'code' => '12', 'name' => 'SARGENTO PRIMERO', 'shortened' => 'SGTO. 1RO.'],
            ['hierarchy_id' => '4', 'code' => '13', 'name' => 'SARGENTO SEGUNDO', 'shortened' => 'SGTO. 2DO.'],
            ['hierarchy_id' => '4', 'code' => '14', 'name' => 'CABO', 'shortened' => 'CBO.'],
            ['hierarchy_id' => '4', 'code' => '15', 'name' => 'POLICIA', 'shortened' => 'POL.'],

            ['hierarchy_id' => '5', 'code' => '08', 'name' => 'SUBOFICIAL SUPERIOR ADMINISTRATIVO', 'shortened' => 'SOF. SUP. ADM.'],
            ['hierarchy_id' => '5', 'code' => '09', 'name' => 'SUBOFICIAL MAYOR ADMINISTRATIVO', 'shortened' => 'SOF. MY. ADM.'],
            ['hierarchy_id' => '5', 'code' => '10', 'name' => 'SUBOFICIAL PRIMERO ADMINISTRATIVO', 'shortened' => 'SOF. 1RO. ADM.'],
            ['hierarchy_id' => '5', 'code' => '11', 'name' => 'SUBOFICIAL SEGUNDO ADMINISTRATIVO', 'shortened' => 'SOF. 2DO. ADM.'],
            ['hierarchy_id' => '5', 'code' => '12', 'name' => 'SARGENTO PRIMERO ADMINISTRATIVO', 'shortened' => 'SGTO. 1RO. ADM.'],
            ['hierarchy_id' => '5', 'code' => '13', 'name' => 'SARGENTO SEGUNDO ADMINISTRATIVO', 'shortened' => 'SGTO. 2DO. ADM.'],
            ['hierarchy_id' => '5', 'code' => '14', 'name' => 'CABO ADMINISTRATIVO', 'shortened' => 'CBO. ADM.'],
            ['hierarchy_id' => '5', 'code' => '16', 'name' => 'POLICIA ADMINISTRATIVO', 'shortened' => 'POL. ADM.']

        ];

        foreach ($statuses as $status) {

            Muserpol\Degree::create($status);

        }
    }
}
