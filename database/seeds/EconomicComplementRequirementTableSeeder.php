<?php

use Illuminate\Database\Seeder;

class EconomicComplementRequirementTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        Eloquent::unguard();

        $this->createEconomicComplementRequirements();

        Eloquent::reguard();
    }

    private function createEconomicComplementRequirements()
    {

            ['eco_com_type_id' => '1', 'name' => 'Fotocopia de Boleta de Renta', 'shortened' => 'Fotocopia de Boleta de Renta'],
            ['eco_com_type_id' => '1', 'name' => 'Fotocopia de Cédula de Identidad', 'shortened' => 'Fotocopia de Cédula de Identidad'],
            ['eco_com_type_id' => '1', 'name' => 'Fotocopia legible de Memorándum de Agradecimiento de servicios, emitido por el Comando General de la Policía Boliviana', 'shortened' => 'Fotocopia de Memorándum de Agradecimiento'],
            ['eco_com_type_id' => '1', 'name' => 'Fotocopia legible de Certificación de Años de Servicio emitida por el Comando General de la Policía Boliviana, que acredite como mínimo Dieciséis (16) años de servicio en la Policía Boliviana', 'shortened' => 'Fotocopia de Certificación de Años de Servicio'],
            ['eco_com_type_id' => '1', 'name' => 'Fotocopia de la Resolución de SENASIR o contrato de la AFP o de la Aseguradora; excepcionalmente se podrá admitir fotocopia legalizada de la Resolución otorgada de renta de vejez', 'shortened' => 'Fotocopia de Resolución de SENASIR o contrato de la AFP o de la Aseguradora'],

            ['eco_com_type_id' => '2', 'name' => 'Fotocopia de Boleta de Renta', 'shortened' => 'Fotocopia de Boleta de Renta'],
            ['eco_com_type_id' => '2', 'name' => 'Fotocopia de Cédula de Identidad del derechohabiente', 'shortened' => 'Fotocopia de Cédula de Identidad del derechohabiente'],
            ['eco_com_type_id' => '2', 'name' => 'Fotocopia de Cédula de Identidad del causahabiente ', 'shortened' => 'Fotocopia de Cédula de Identidad del causahabiente'],
            ['eco_com_type_id' => '2', 'name' => 'Certificado Original de Defunción del causahabiente', 'shortened' => 'Certificado Original de Defunción del causahabiente'],
            ['eco_com_type_id' => '2', 'name' => 'Fotocopia de la Resolución de SENASIR o contrato de la AFP o de la Aseguradora; excepcionalmente se podrá admitir fotocopia legalizada de la Resolución otorgada de renta de vejez', 'shortened' => 'Fotocopia de Resolución de SENASIR o contrato de la AFP o de la Aseguradora'],
            ['eco_com_type_id' => '2', 'name' => 'Fotocopia legible del Memorándum de Agradecimiento de servicios o Certificación de Trabajo, emitidos por el Comando General de la Policía Boliviana.', 'shortened' => 'Fotocopia de Memorándum de Agradecimiento de servicios o Certificación de Trabajo'],
            ['eco_com_type_id' => '2', 'name' => 'Fotocopia legible de Certificación de Años de Servicio emitida por el Comando General de la Policía Boliviana, que acredite como mínimo Dieciséis (16) años de servicio en la Policía Boliviana', 'shortened' => 'Fotocopia de Certificación de Años de Servicio'],
            ['eco_com_type_id' => '2', 'name' => 'Certificación original de verificación de partidas matrimoniales emitida por el Servicio de Registro Civil – SERECI', 'shortened' => 'Certificación original de verificación de partidas matrimoniales'],

            ['eco_com_type_id' => '3', 'name' => 'Fotocopia de Boleta de Renta', 'shortened' => 'Fotocopia de Boleta de Renta'],
            ['eco_com_type_id' => '3', 'name' => 'Fotocopia de Cédula de Identidad del derechohabiente', 'shortened' => 'Fotocopia de Cédula de Identidad del derechohabiente'],
            ['eco_com_type_id' => '3', 'name' => 'Fotocopia de Cédula de Identidad del causahabiente ', 'shortened' => 'Fotocopia de Cédula de Identidad del causahabiente'],
            ['eco_com_type_id' => '3', 'name' => 'Certificado Original de Defunción del causahabiente', 'shortened' => 'Certificado Original de Defunción del causahabiente'],
            ['eco_com_type_id' => '3', 'name' => 'Fotocopia de la Resolución de SENASIR o contrato de la AFP o de la Aseguradora; excepcionalmente se podrá admitir fotocopia legalizada de la Resolución otorgada de renta de vejez', 'shortened' => 'Fotocopia de Resolución de SENASIR o contrato de la AFP o de la Aseguradora'],
            ['eco_com_type_id' => '3', 'name' => 'Fotocopia legalizada de Resolución judicial de declaración de tutela', 'shortened' => 'Fotocopia legalizada de Resolución judicial de declaración de tutela'],
            ['eco_com_type_id' => '3', 'name' => 'Fotocopia legible del Memorándum de Agradecimiento de servicios o Certificación de Trabajo, emitidos por el Comando General de la Policía Boliviana.', 'shortened' => 'Fotocopia de Memorándum de Agradecimiento de servicios o Certificación de Trabajo'],
            ['eco_com_type_id' => '3', 'name' => 'Fotocopia legible de Certificación de Años de Servicio emitida por el Comando General de la Policía Boliviana, que acredite como mínimo Dieciséis (16) años de servicio en la Policía Boliviana', 'shortened' => 'Fotocopia de Certificación de Años de Servicio'],

        ];

        foreach ($statuses as $status) {

            Muserpol\EconomicComplementRequirement::create($status);

        }
    }
}
