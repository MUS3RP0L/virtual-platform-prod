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

            ['code_level' => '00', 'code_degree' => '00', 'name' => 'COMANDANTE GRAL', 'shortened' => 'CMTE. GRAL.'],
            ['code_level' => '00', 'code_degree' => '01', 'name' => 'COMANDANTE GRAL', 'shortened' => 'CMTE. GRAL.'],
            ['code_level' => '00', 'code_degree' => '02', 'name' => 'SUBCOMANDANTE', 'shortened' => 'SBCMTE. GRAL.'],
            ['code_level' => '00', 'code_degree' => '03', 'name' => 'INSPECTOR GENERAL', 'shortened' => 'INSP. GRAL.'],
            ['code_level' => '00', 'code_degree' => '04', 'name' => 'DIRECTOR GENERAL', 'shortened' => 'DIR. GRAL.'],
            ['code_level' => '00', 'code_degree' => '04C', 'name' => 'GENERAL', 'shortened' => 'GRAL.'], //Eco Com
            ['code_level' => '01', 'code_degree' => '01', 'name' => 'CORONEL CON SUELDO DE GENERAL', 'shortened' => 'CNL.'],
            ['code_level' => '01', 'code_degree' => '02', 'name' => 'CORONEL', 'shortened' => 'CNL.'],      
            ['code_level' => '01', 'code_degree' => '03', 'name' => 'TENIENTE CORONEL', 'shortened' => 'TCNL.'],
            ['code_level' => '01', 'code_degree' => '04', 'name' => 'MAYOR', 'shortened' => 'MY.'],
            ['code_level' => '01', 'code_degree' => '05', 'name' => 'CAPITAN', 'shortened' => 'CAP.'],
            ['code_level' => '01', 'code_degree' => '06', 'name' => 'TENIENTE', 'shortened' => 'TTE.'],
            ['code_level' => '01', 'code_degree' => '07', 'name' => 'SUBTENIENTE', 'shortened' => 'SBTTE.'],
            ['code_level' => '02', 'code_degree' => '02', 'name' => 'CORONEL ADMINISTRATIVO', 'shortened' => 'CNL. ADM.'],
            ['code_level' => '02', 'code_degree' => '03', 'name' => 'TENIENTE CORONEL ADMINISTRATIVO', 'shortened' => 'TCNL. ADM.'],
            ['code_level' => '02', 'code_degree' => '04', 'name' => 'MAYOR ADMINISTRATIVO', 'shortened' => 'MY. ADM.'],
            ['code_level' => '02', 'code_degree' => '05', 'name' => 'CAPITAN ADMINISTRATIVO', 'shortened' => 'CAP. ADM.'],
            ['code_level' => '02', 'code_degree' => '06', 'name' => 'TENIENTE ADMINISTRATIVO', 'shortened' => 'TTE. ADM.'],
            ['code_level' => '02', 'code_degree' => '07', 'name' => 'SUBTENIENTE ADMINISTRATIVO', 'shortened' => 'SBTTE. ADM.'],
            ['code_level' => '03', 'code_degree' => '08', 'name' => 'SUBOFICIAL SUPERIOR', 'shortened' => 'SOF. SUP.'],
            ['code_level' => '03', 'code_degree' => '09', 'name' => 'SUBOFICIAL MAYOR', 'shortened' => 'SOF. MY.'],
            ['code_level' => '03', 'code_degree' => '10', 'name' => 'SUBOFICIAL PRIMERO', 'shortened' => 'SOF. 1RO.'],
            ['code_level' => '03', 'code_degree' => '11', 'name' => 'SUBOFICIAL SEGUNDO', 'shortened' => 'SOF. 2DO.'],
            ['code_level' => '03', 'code_degree' => '12', 'name' => 'SARGENTO PRIMERO', 'shortened' => 'SGTO. 1RO.'],
            ['code_level' => '03', 'code_degree' => '13', 'name' => 'SARGENTO SEGUNDO', 'shortened' => 'SGTO. 2DO.'],
            ['code_level' => '03', 'code_degree' => '14', 'name' => 'CABO', 'shortened' => 'CBO.'],
            ['code_level' => '03', 'code_degree' => '15', 'name' => 'POLICIA', 'shortened' => 'POL.'],
            ['code_level' => '04', 'code_degree' => '08', 'name' => 'SUBOFICIAL SUPERIOR ADMINISTRATIVO', 'shortened' => 'SOF. SUP. ADM.'],
            ['code_level' => '04', 'code_degree' => '09', 'name' => 'SUBOFICIAL MAYOR ADMINISTRATIVO', 'shortened' => 'SOF. MY. ADM.'],
            ['code_level' => '04', 'code_degree' => '10', 'name' => 'SUBOFICIAL PRIMERO ADMINISTRATIVO', 'shortened' => 'SOF. 1RO. ADM.'],
            ['code_level' => '04', 'code_degree' => '11', 'name' => 'SUBOFICIAL SEGUNDO ADMINISTRATIVO', 'shortened' => 'SOF. 2DO. ADM.'],
            ['code_level' => '04', 'code_degree' => '12', 'name' => 'SARGENTO PRIMERO ADMINISTRATIVO', 'shortened' => 'SGTO. 1RO. ADM.'],
            ['code_level' => '04', 'code_degree' => '13', 'name' => 'SARGENTO SEGUNDO ADMINISTRATIVO', 'shortened' => 'SGTO. 2DO. ADM.'],
            ['code_level' => '04', 'code_degree' => '14', 'name' => 'CABO ADMINISTRATIVO', 'shortened' => 'CBO. ADM.'],
            ['code_level' => '04', 'code_degree' => '16', 'name' => 'POLICIA ADMINISTRATIVO', 'shortened' => 'POL. ADM.']
        
        ];

        foreach ($statuses as $status) {

            Muserpol\Degree::create($status);
            
        }
    }
}
