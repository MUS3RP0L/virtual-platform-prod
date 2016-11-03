<?php

use Illuminate\Database\Seeder;

class UnitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        $this->createUnits();

        Eloquent::reguard();
    }

    private function createUnits()
    {
        $statuses = [

	    	['breakdown_id' => '10', 'district' => 'CHUQUISACA', 'code' => '10182', 'shortened' => 'C.D.PN.CH.', 'name' => 'COMANDO DEPARTAMENTAL CHUQUISACA'],
	    	['breakdown_id' => '5', 'district' => 'CHUQUISACA', 'code' => '10182', 'shortened' => 'BAT.SEG.FP.CH.', 'name' => 'BAT. SEG. FISICA PRIVADA CH. (SERVICIOS)'],

	    	['breakdown_id' => '10', 'district' => 'CHUQUISACA', 'code' => '10194', 'shortened' => 'F.E.L.C.N.CH.', 'name' => 'F.E.L.C.N. CHUQUISACA'],

	    	['breakdown_id' => '10', 'district' => 'LA PAZ', 'code' => '20181', 'shortened' => 'S.F.E.', 'name' => 'SEGURIDAD FISICA ESTATAL'],

	    	['breakdown_id' => '10', 'district' => 'LA PAZ', 'code' => '20182', 'shortened' => 'C.D.PN.', 'name' => 'COMANDO DEPARTAMENTAL LA PAZ '],
	    	['breakdown_id' => '5', 'district' => 'LA PAZ', 'code' => '20182', 'shortened' => 'BAT.SEG.FP.LP.', 'name' => 'BAT. SEG. FISICA PRIVADA LP. (SERVICIOS)'],
	    	['breakdown_id' => '6', 'district' => 'LA PAZ', 'code' => '20182', 'shortened' => 'J.P.C.C.F.', 'name' => 'JUZGADOS POLICIALES - C.C. Y FAMILIAR'],
	    	['breakdown_id' => '8', 'district' => 'LA PAZ', 'code' => '20182', 'shortened' => 'ESC.SEG.PU.', 'name' => 'ESCUADRON DE SEG. LOS PUMAS'],
	        ['breakdown_id' => '9', 'district' => 'LA PAZ', 'code' => '20182', 'shortened' => 'DIR.NAL.SEG.PEN.IT.0', 'name' => 'DIR NAL SEG. PENITENCIARIA'],

	        ['breakdown_id' => '10', 'district' => 'LA PAZ', 'code' => '20183', 'shortened' => 'ANAPOL', 'name' => 'ACADEMIA NACIONAL DE POLICIA'],

	    	['breakdown_id' => '10', 'district' => 'LA PAZ', 'code' => '20184', 'shortened' => 'D.P.2', 'name' => 'DISTRITO POLICIAL Nº 2'],

	    	['breakdown_id' => '10', 'district' => 'LA PAZ', 'code' => '20185', 'shortened' => 'D.P.5', 'name' => 'DISTRITO POLICIAL Nº 5'],

	    	['breakdown_id' => '10', 'district' => 'EL ALTO', 'code' => '20186', 'shortened' => 'C.R.E.A.', 'name' => 'COMANDO REGIONAL EL ALTO'],
	    	['breakdown_id' => '5', 'district' => 'EL ALTO', 'code' => '20186', 'shortened' => 'BAT.SEG.FP.E.A.', 'name' => 'BAT. SEG. FISICA PRIVADA EL ALTO (SERVICIOS)'],

	    	['breakdown_id' => '10', 'district' => 'LA PAZ', 'code' => '20187', 'shortened' => 'D.P.1', 'name' => 'DISTRITO POLICIAL Nº 1'],

	    	['breakdown_id' => '10', 'district' => 'LA PAZ', 'code' => '20188', 'shortened' => 'D.P.3', 'name' => 'DISTRITO POLICIAL Nº 3'],

	    	['breakdown_id' => '10', 'district' => 'ZONA SUR', 'code' => '20189', 'shortened' => 'D.P.4', 'name' => 'DISTRITO POLICIAL Nº 4'],

	    	['breakdown_id' => '10', 'district' => 'LA PAZ', 'code' => '20190', 'shortened' => 'C.G.PN.', 'name' => 'COMANDO GENERAL'],
	    	['breakdown_id' => '1', 'district' => 'LA PAZ', 'code' => '20190', 'shortened' => 'DISP.', 'name' => 'DISPONIBILIDAD'],
	    	['breakdown_id' => '2', 'district' => 'LA PAZ', 'code' => '20190', 'shortened' => 'DIR.NAL.POFOMA', 'name' => 'DIRECCION NACIONAL POFOMA'],
			['breakdown_id' => '3', 'district' => 'LA PAZ', 'code' => '20190', 'shortened' => 'COM.IT.0', 'name' => 'COMISION ITEM CERO'],

	    	['breakdown_id' => '10', 'district' => 'LA PAZ', 'code' => '20191', 'shortened' => 'POLIV.', 'name' => 'POLIVALENTES DE SEG. CIUDADANA'],

	    	['breakdown_id' => '10', 'district' => 'LA PAZ', 'code' => '20192', 'shortened' => 'U.P.R.F.', 'name' => 'POL. RURAL Y FRONTERIZA'],

	    	['breakdown_id' => '10', 'district' => 'ZONA SUR', 'code' => '20193', 'shortened' => 'CANES', 'name' => 'CENTRO DE ADIESTRAMIENTO DE CANES'],

	    	['breakdown_id' => '10', 'district' => 'LA PAZ', 'code' => '20194', 'shortened' => 'F.E.L.C.N.LP.', 'name' => 'F.E.L.C.N. LA PAZ'],

	    	['breakdown_id' => '10', 'district' => 'ZONA SUR', 'code' => '20195', 'shortened' => 'C.R.ZS.', 'name' => 'COMANDO REGIONAL ZONA SUR'],

	    	['breakdown_id' => '10', 'district' => 'LA PAZ', 'code' => '20196', 'shortened' => 'DIR.NAL.IDENTIF.', 'name' => 'DIRECION NACIONAL IDENTIFICACION PERSONAL'],

	    	['breakdown_id' => '10', 'district' => 'LA PAZ', 'code' => '20197', 'shortened' => 'DIR.NAL.RECA.', 'name' => 'DIRECION NACIONAL DE FISC. Y RECAUDACIONES'],

	    	['breakdown_id' => '10', 'district' => 'LA PAZ', 'code' => '20210', 'shortened' => 'DIPROVE', 'name' => 'DIRECION NACIONAL PREVENC. ROBO DE VEHICULOS'],

	    	['breakdown_id' => '10', 'district' => 'LA PAZ', 'code' => '20220', 'shortened' => 'DIR.NAL.SALUD', 'name' => 'DIRECION NACIONAL SALUD BIENESTAR SOCIAL'],

	    	['breakdown_id' => '10', 'district' => 'LA PAZ', 'code' => '20230', 'shortened' => 'DIR.NAL.INS.ENS.', 'name' => 'DIRECION NACIONAL DE INSTRUC. Y ENSEÑANZA'],

	    	['breakdown_id' => '10', 'district' => 'LA PAZ', 'code' => '20280', 'shortened' => 'UTOP', 'name' => 'TACTICA DE OPERACIONES POLICIALES'],

	    	['breakdown_id' => '10', 'district' => 'LA PAZ', 'code' => '20282', 'shortened' => 'TRANS', 'name' => 'ORG. OP. DE TRANSITO'],

	    	['breakdown_id' => '10', 'district' => 'LA PAZ', 'code' => '20283', 'shortened' => 'F.E.L.C.C.', 'name' => 'DIRECION NACIONAL F.E.L.C.- C'],

	    	['breakdown_id' => '10', 'district' => 'LA PAZ', 'code' => '20284', 'shortened' => 'R.P.110', 'name' => 'RADIO PATRULLAS 110'],

	    	['breakdown_id' => '10', 'district' => 'LA PAZ', 'code' => '20285', 'shortened' => 'BOMB.', 'name' => 'BOMBEROS'],

	    	['breakdown_id' => '10', 'district' => 'EL ALTO', 'code' => '20286', 'shortened' => 'ORG.OP.TRANS.EA.', 'name' => 'ORG. OP. DE TRANSITO EL ALTO'],

	    	['breakdown_id' => '10', 'district' => 'COCHABAMBA', 'code' => '30184', 'shortened' => 'CDPN.CBBA.', 'name' => 'COMANDO DEPARTAMENTAL COCHABAMBA'],
	    	['breakdown_id' => '5', 'district' => 'COCHABAMBA', 'code' => '30184', 'shortened' => 'BAT.SEG.FP.CBBA.', 'name' => 'BAT. SEG. FISICA PRIVADA CBBA. (SERVICIOS)'],

	    	['breakdown_id' => '10', 'district' => 'COCHABAMBA', 'code' => '30190', 'shortened' => 'P.E.CBBA.', 'name' => 'POLICIA ECOLÓGICA CBBA.'],

	    	['breakdown_id' => '10', 'district' => 'COCHABAMBA', 'code' => '30194', 'shortened' => 'F.E.L.C.N.CBBA.', 'name' => 'F.E.L.C.N. COCHABAMBA'],

	    	['breakdown_id' => '10', 'district' => 'ORURO', 'code' => '40182', 'shortened' => 'C.D.PN.OR.', 'name' => 'COMANDO DEPARTAMENTAL ORURO'],
	    	['breakdown_id' => '5', 'district' => 'ORURO', 'code' => '40182', 'shortened' => 'BAT.SEG.FP.OR.', 'name' => 'BAT. SEG. FISICA PRIVADA OR. (SERVICIOS)'],

	    	['breakdown_id' => '10', 'district' => 'ORURO', 'code' => '40194', 'shortened' => 'F.E.L.C.N.OR.', 'name' => 'F.E.L.C.N. ORURO'],

	    	['breakdown_id' => '10', 'district' => 'POTOSI', 'code' => '50182', 'shortened' => 'C.D.PN.PT.', 'name' => 'COMANDO DEPARTAMENTAL POTOSI'],
	    	['breakdown_id' => '5', 'district' => 'POTOSI', 'code' => '50182', 'shortened' => 'BAT.SEG.FP.PT.', 'name' => 'BAT. SEG. FISICA PRIVADA PT. (SERVICIOS)'],

	    	['breakdown_id' => '10', 'district' => 'POTOSI', 'code' => '50194', 'shortened' => 'F.E.L.C.N.PT.', 'name' => 'F.E.L.C.N. POTOSÍ'],

	    	['breakdown_id' => '10', 'district' => 'TUPIZA', 'code' => '50882', 'shortened' => 'J.F.PN.TZA.', 'name' => 'JEFATURA FRONTERIZA TUPIZA'],
	    	['breakdown_id' => '5', 'district' => 'TUPIZA', 'code' => '50882', 'shortened' => 'BAT.SEG.FPF.TZA.', 'name' => 'BAT. SEG. FISICA PRIVADA FRONT. TUPIZA'],

	    	['breakdown_id' => '10', 'district' => 'TUPIZA', 'code' => '51194', 'shortened' => 'F.E.L.C.N.TZA.', 'name' => 'F.E.L.C.N. TUPIZA'],

	    	['breakdown_id' => '10', 'district' => 'VILLAZON', 'code' => '51582', 'shortened' => 'J.F.PN.VIZN.', 'name' => 'JEFATURA FRONTERIZA VILLAZON'],
	    	['breakdown_id' => '5', 'district' => 'VILLAZON', 'code' => '51582', 'shortened' => 'BAT.SEG.FPF.VIZN.', 'name' => 'BAT. SEG. FISICA PRIVADA FRONT. VILLAZON'],

	    	['breakdown_id' => '10', 'district' => 'VILLAZON', 'code' => '51594', 'shortened' => 'F.E.L.C.N.VI.', 'name' => 'F.E.L.C.N. VILLAZON'],

	    	['breakdown_id' => '10', 'district' => 'TARIJA', 'code' => '60182', 'shortened' => 'C.D.PN.TJA.', 'name' => 'COMANDO DEPARTAMENTAL TARIJA'],
	    	['breakdown_id' => '5', 'district' => 'TARIJA', 'code' => '60182', 'shortened' => 'BAT.SEG.FP.TJA.', 'name' => 'BAT. SEG. FISICA PRIVADA TJA. (SERVICIOS)'],

	    	['breakdown_id' => '10', 'district' => 'TARIJA', 'code' => '60194', 'shortened' => 'F.E.L.C.N.TJA.', 'name' => 'F.E.L.C.N. TARIJA'],

	    	['breakdown_id' => '10', 'district' => 'YACUIBA', 'code' => '60294', 'shortened' => 'F.E.L.C.N.YA.', 'name' => 'F.E.L.C.N. YACUIBA'],

	    	['breakdown_id' => '10', 'district' => 'YACUIBA', 'code' => '60382', 'shortened' => 'J.F.PN.YA.', 'name' => 'JEFATURA FRONTERIZA YACUIBA'],
			['breakdown_id' => '5', 'district' => 'YACUIBA', 'code' => '60382', 'shortened' => 'BAT.SEG.FP.YA.', 'name' => 'BAT. SEG. FISICA PRIVADA FRONT. YACUIBA'],

	    	['breakdown_id' => '10', 'district' => 'VILLAMONTES', 'code' => '60482', 'shortened' => 'J.F.PN.VITS.', 'name' => 'JEFATURA PROVINCIAL VILLAMONTES'],
	    	['breakdown_id' => '5', 'district' => 'VILLAMONTES', 'code' => '60482', 'shortened' => 'BAT.SEG.FP.VITS.', 'name' => 'BAT. SEG. FISICA PRIVADA FRONT. VILLAMONTES'],

	    	['breakdown_id' => '10', 'district' => 'BERMEJO', 'code' => '60582', 'shortened' => 'J.F.PN.BMJO.', 'name' => 'JEFATURA FRONTERIZA BERMEJO'],
	    	['breakdown_id' => '5', 'district' => 'BERMEJO', 'code' => '60582', 'shortened' => 'BAT.SEG.FP.BMJO.', 'name' => 'BAT. SEG. FISICA PRIVADA FRONT. BERMEJO'],

	    	['breakdown_id' => '10', 'district' => 'SANTA CRUZ', 'code' => '70182', 'shortened' => 'C.D.PN.SC.', 'name' => 'COMANDO DEPARTAMENTAL SANTA CRUZ'],
	    	['breakdown_id' => '5', 'district' => 'SANTA CRUZ', 'code' => '70182', 'shortened' => 'BAT.SEG.FP.SC.', 'name' => 'BAT. SEG. FISICA PRIVADA SC. (SERVICIOS)'],

	    	['breakdown_id' => '10', 'district' => 'SANTA CRUZ', 'code' => '70194', 'shortened' => 'F.E.L.C.N.SC.', 'name' => 'F.E.L.C.N. SANTA CRUZ'],

	    	['breakdown_id' => '10', 'district' => 'SAN MATIAS', 'code' => '70294', 'shortened' => 'F.E.L.C.N.SM.', 'name' => 'F.E.L.C.N. SAN MATIAS'],

	    	['breakdown_id' => '10', 'district' => 'S. I. VELASCO', 'code' => '70382', 'shortened' => 'J.F.PN.SAIGVE.', 'name' => 'JEFATURA PROVINCIAL SAN IGNACIO DE VELASCO'],

	    	['breakdown_id' => '10', 'district' => 'S. I. VELASCO', 'code' => '70394', 'shortened' => 'F.E.L.C.N.SAIGVE.', 'name' => 'F.E.L.C.N. SAN IGNACIO DE VELASCO'],

	    	['breakdown_id' => '10', 'district' => 'SAN MATIAS', 'code' => '70482', 'shortened' => 'J.F.PN.SAMA.', 'name' => 'JEFATURA FRONTERIZA SAN MATIAS'],

	    	['breakdown_id' => '10', 'district' => 'PTO. SUAREZ', 'code' => '70582', 'shortened' => 'J.F.PN.PTOSUA.', 'name' => 'JEFATURA FRONTERIZA PUERTO SUAREZ'],
	    	['breakdown_id' => '5', 'district' => 'PTO. SUAREZ', 'code' => '70582', 'shortened' => 'BAT.SEG.FP.PTOSUA.', 'name' => 'BAT. SEG. FISICA PRIVADA FRONT. PUERTO SUAREZ'],

	    	['breakdown_id' => '10', 'district' => 'PTO. SUAREZ', 'code' => '70594', 'shortened' => 'F.E.L.C.N.PTOSUA.', 'name' => 'F.E.L.C.N. PUERTO SUAREZ'],

	    	['breakdown_id' => '10', 'district' => 'BENI', 'code' => '80182', 'shortened' => 'C.D.PN.BN.', 'name' => 'CCOMANDO DEPARTAMENTAL BENI'],
	    	['breakdown_id' => '5', 'district' => 'BENI', 'code' => '80182', 'shortened' => 'BAT.SEG.FP.BN.', 'name' => 'BAT. SEG. FISICA PRIVADA BN. (SERVICIOS)'],

	    	['breakdown_id' => '10', 'district' => 'RIBERALTA', 'code' => '80186', 'shortened' => 'J.F.PN.RIBE.', 'name' => 'JEFATURA PROVINCIAL RIBERALTA'],
	    	['breakdown_id' => '5', 'district' => 'RIBERALTA', 'code' => '80186', 'shortened' => 'BAT.SEG.FP.RIBE.', 'name' => 'BAT. SEG. FISICA PRIVADA FRONT. RIBERALTA'],

	    	['breakdown_id' => '10', 'district' => 'BENI', 'code' => '80194', 'shortened' => 'F.E.L.C.N.BN.', 'name' => 'F.E.L.C.N. BENI'],

	    	['breakdown_id' => '10', 'district' => 'GUAYARAMERIN', 'code' => '80282', 'shortened' => 'J.F.PN.GUAY.', 'name' => 'JEFATURA FRONTERIZA GUAYARAMERIN'],
	    	['breakdown_id' => '5', 'district' => 'GUAYARAMERIN', 'code' => '80282', 'shortened' => 'BAT.SEG.FP.GUAY.', 'name' => 'BAT. SEG. FISICA PRIVADA FRONT. GUAYARAMERIN'],

	    	['breakdown_id' => '10', 'district' => 'PANDO', 'code' => '90182', 'shortened' => 'C.D.PN.PD.', 'name' => 'COMANDO DEPARTAMENTAL PANDO'],
	    	['breakdown_id' => '5', 'district' => 'PANDO', 'code' => '90182', 'shortened' => 'BAT.SEG.FP.PD.', 'name' => 'BAT. SEG. FISICA PRIVADA PDO. (SERVICIOS)'],

	    	['breakdown_id' => '10', 'district' => 'PANDO', 'code' => '90194', 'shortened' => 'F.E.L.C.N.PD.', 'name' => 'F.E.L.C.N. PANDO']
    	];

        foreach ($statuses as $status) {

            Muserpol\Unit::create($status);

        }
    }
}
