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

        $this->createDegrees();

        Eloquent::reguard();
    }

    private function createDegrees()
    {
        $statuses = [

            ['id' => '1', 'code_level' => '00', 'code_degree' => '00', 'name' => 'COMANDANTE GRAL', 'shortened' => 'CMTE. GRAL.'],
            ['id' => '2', 'code_level' => '00', 'code_degree' => '01', 'name' => 'COMANDANTE GRAL', 'shortened' => 'CMTE. GRAL.'],
            ['id' => '3', 'code_level' => '00', 'code_degree' => '02', 'name' => 'SUBCOMANDANTE', 'shortened' => 'SBCMTE. GRAL.'],
            ['id' => '4', 'code_level' => '00', 'code_degree' => '03', 'name' => 'INSPECTOR GENERAL', 'shortened' => 'INSP. GRAL.'],
            ['id' => '5', 'code_level' => '00', 'code_degree' => '04', 'name' => 'DIRECTOR GENERAL', 'shortened' => 'DIR. GRAL.'],
            ['id' => '6', 'code_level' => '01', 'code_degree' => '01', 'name' => 'CORONEL CON SUELDO DE GENERAL', 'shortened' => 'CNL.'],
            ['id' => '7', 'code_level' => '01', 'code_degree' => '02', 'name' => 'CORONEL', 'shortened' => 'CNL.'],      
            ['id' => '8', 'code_level' => '01', 'code_degree' => '03', 'name' => 'TENIENTE CORONEL', 'shortened' => 'TCNL.'],
            ['id' => '9', 'code_level' => '01', 'code_degree' => '04', 'name' => 'MAYOR', 'shortened' => 'MY.'],
            ['id' => '10', 'code_level' => '01', 'code_degree' => '05', 'name' => 'CAPITAN', 'shortened' => 'CAP.'],
            ['id' => '11', 'code_level' => '01', 'code_degree' => '06', 'name' => 'TENIENTE', 'shortened' => 'TTE.'],
            ['id' => '12', 'code_level' => '01', 'code_degree' => '07', 'name' => 'SUBTENIENTE', 'shortened' => 'SBTTE.'],
            ['id' => '13', 'code_level' => '02', 'code_degree' => '02', 'name' => 'CORONEL ADMINISTRATIVO', 'shortened' => 'CNL. ADM.'],
            ['id' => '14', 'code_level' => '02', 'code_degree' => '03', 'name' => 'TENIENTE CORONEL ADMINISTRATIVO', 'shortened' => 'TCNL. ADM.'],
            ['id' => '15', 'code_level' => '02', 'code_degree' => '04', 'name' => 'MAYOR ADMINISTRATIVO', 'shortened' => 'MY. ADM.'],
            ['id' => '16', 'code_level' => '02', 'code_degree' => '05', 'name' => 'CAPITAN ADMINISTRATIVO', 'shortened' => 'CAP. ADM.'],
            ['id' => '17', 'code_level' => '02', 'code_degree' => '06', 'name' => 'TENIENTE ADMINISTRATIVO', 'shortened' => 'TTE. ADM.'],
            ['id' => '18', 'code_level' => '02', 'code_degree' => '07', 'name' => 'SUBTENIENTE ADMINISTRATIVO', 'shortened' => 'SBTTE. ADM.'],
            ['id' => '19', 'code_level' => '03', 'code_degree' => '08', 'name' => 'SUBOFICIAL SUPERIOR', 'shortened' => 'SOF. SUP.'],
            ['id' => '20', 'code_level' => '03', 'code_degree' => '09', 'name' => 'SUBOFICIAL MAYOR', 'shortened' => 'SOF. MY.'],
            ['id' => '21', 'code_level' => '03', 'code_degree' => '10', 'name' => 'SUBOFICIAL PRIMERO', 'shortened' => 'SOF. 1RO.'],
            ['id' => '22', 'code_level' => '03', 'code_degree' => '11', 'name' => 'SUBOFICIAL SEGUNDO', 'shortened' => 'SOF. 2DO.'],
            ['id' => '23', 'code_level' => '03', 'code_degree' => '12', 'name' => 'SARGENTO PRIMERO', 'shortened' => 'SGTO. 1RO.'],
            ['id' => '24', 'code_level' => '03', 'code_degree' => '13', 'name' => 'SARGENTO SEGUNDO', 'shortened' => 'SGTO. 2DO.'],
            ['id' => '25', 'code_level' => '03', 'code_degree' => '14', 'name' => 'CABO', 'shortened' => 'CBO.'],
            ['id' => '26', 'code_level' => '03', 'code_degree' => '15', 'name' => 'POLICIA', 'shortened' => 'POL.'],
            ['id' => '27', 'code_level' => '04', 'code_degree' => '08', 'name' => 'SUBOFICIAL SUPERIOR ADMINISTRATIVO', 'shortened' => 'SOF. SUP. ADM.'],
            ['id' => '28', 'code_level' => '04', 'code_degree' => '09', 'name' => 'SUBOFICIAL MAYOR ADMINISTRATIVO', 'shortened' => 'SOF. MY. ADM.'],
            ['id' => '29', 'code_level' => '04', 'code_degree' => '10', 'name' => 'SUBOFICIAL PRIMERO ADMINISTRATIVO', 'shortened' => 'SOF. 1RO. ADM.'],
            ['id' => '30', 'code_level' => '04', 'code_degree' => '11', 'name' => 'SUBOFICIAL SEGUNDO ADMINISTRATIVO', 'shortened' => 'SOF. 2DO. ADM.'],
            ['id' => '31', 'code_level' => '04', 'code_degree' => '12', 'name' => 'SARGENTO PRIMERO ADMINISTRATIVO', 'shortened' => 'SGTO. 1RO. ADM.'],
            ['id' => '32', 'code_level' => '04', 'code_degree' => '13', 'name' => 'SARGENTO SEGUNDO ADMINISTRATIVO', 'shortened' => 'SGTO. 2DO. ADM.'],
            ['id' => '33', 'code_level' => '04', 'code_degree' => '14', 'name' => 'CABO ADMINISTRATIVO', 'shortened' => 'CBO. ADM.'],
            ['id' => '34', 'code_level' => '04', 'code_degree' => '16', 'name' => 'POLICIA ADMINISTRATIVO', 'shortened' => 'POL. ADM.']
        
        ];

        foreach ($statuses as $status) {

            Muserpol\Degree::create($status);
            
        }
    }
}
