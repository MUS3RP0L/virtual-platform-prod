<?php

use Illuminate\Database\Seeder;

class RequirementTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function run()
    {
        Eloquent::unguard();

        $this->createRequirements();

        Eloquent::reguard();
    }

    private function createRequirements()
    {
        $statuses = [

            ['id' => '1', 'retirement_fund_modality_id' => '1', 'shortened' => 'Depósito Bancario para el canje de formulario y Carpeta.', 'name' => 'Depósito de Bs. 25.- en cuenta N° 1-13809229 del Banco Unión a para el canje de formulario y Carpeta.'],
            ['id' => '2', 'retirement_fund_modality_id' => '1', 'shortened' => 'Solicitud dirigida a la Dirección General Ejecutiva.', 'name' => 'Solicitud dirigida a la Dirección General Ejecutiva.'],
            ['id' => '3', 'retirement_fund_modality_id' => '1', 'shortened' => 'Fotocopia de Cédula de Identidad.', 'name' => 'Fotocopia simple de Cédula de Identidad.'],
            ['id' => '4', 'retirement_fund_modality_id' => '1', 'shortened' => 'Certificado de nacimiento.', 'name' => 'Certificado de nacimiento original y actualizado.'],
            ['id' => '5', 'retirement_fund_modality_id' => '1', 'shortened' => 'Memorándum de Agradecimiento de Servicios.', 'name' => 'Memorándum de Agradecimiento de Servicios otorgado por el Comando General de la Policía Boliviana (Original o Fotocopia Legalizada).'],
            ['id' => '6', 'retirement_fund_modality_id' => '1', 'shortened' => 'Certificado de Haberes de los últimos 36 meses de pago.', 'name' => 'Certificado de Haberes otorgado por el Comando General de la Policía Boliviana (Papeletas de haberes Original O Fotocopia Legalizada) de los últimos 36 meses de pago.'],
            ['id' => '7', 'retirement_fund_modality_id' => '1', 'shortened' => 'Reposición de Obrados Desglosado o Certificado de Años de Servicio.', 'name' => 'Reposición de Obrados Desglosado (Original) o Certificado de Años de Servicio (Copias Originales o fotocopia legalizada), emitidos por el C.A.S. desde la fecha de ingreso a la fecha de retiro definitivo de la institución policial de acuerdo a Memorándum de Agradecimiento.'],
            ['id' => '8', 'retirement_fund_modality_id' => '1', 'shortened' => 'Computo General Desglosado de Años de Servicio.', 'name' => 'Computo General Desglosado de Años de Servicio otorgado por el Comando General de la Policía Boliviana (Original).'],
            ['id' => '9', 'retirement_fund_modality_id' => '2', 'shortened' => 'Depósito Bancario para el canje de formulario y Carpeta.', 'name' => 'Depósito de Bs. 25.- en cuenta N° 1-13809229 del Banco Unión a para el canje de formulario y Carpeta.'],
            ['id' => '10', 'retirement_fund_modality_id' => '2', 'shortened' => 'Solicitud dirigida a la Dirección General Ejecutiva.', 'name' => 'Solicitud dirigida a la Dirección General Ejecutiva.'],
            ['id' => '11', 'retirement_fund_modality_id' => '2', 'shortened' => 'Fotocopia de Cédula de Identidad.', 'name' => 'Fotocopia simple de Cédula de Identidad.'],
            ['id' => '12', 'retirement_fund_modality_id' => '2', 'shortened' => 'Certificado de nacimiento.', 'name' => 'Certificado de nacimiento original y actualizado.'],
            ['id' => '13', 'retirement_fund_modality_id' => '2', 'shortened' => 'Memorándum de Agradecimiento de Servicios.', 'name' => 'Memorándum de Agradecimiento de Servicios otorgado por el Comando General de la Policía Boliviana (Original o Fotocopia Legalizada).'],
            ['id' => '14', 'retirement_fund_modality_id' => '2', 'shortened' => 'Certificado de Haberes de los últimos 36 meses de pago.', 'name' => 'Certificado de Haberes otorgado por el Comando General de la Policía Boliviana (Papeletas de haberes Original O Fotocopia Legalizada) de los últimos 36 meses de pago.'],
            ['id' => '15', 'retirement_fund_modality_id' => '2', 'shortened' => 'Reposición de Obrados Desglosado o Certificado de Años de Servicio.', 'name' => 'Reposición de Obrados Desglosado (Original) o Certificado de Años de Servicio (Copias Originales o fotocopia legalizada), emitidos por el C.A.S. desde la fecha de ingreso a la fecha de retiro definitivo de la institución policial de acuerdo a Memorándum de Agradecimiento.'],
            ['id' => '16', 'retirement_fund_modality_id' => '2', 'shortened' => 'Computo General Desglosado de Años de Servicio.', 'name' => 'Computo General Desglosado de Años de Servicio otorgado por el Comando General de la Policía Boliviana (Original).'],
            ['id' => '17', 'retirement_fund_modality_id' => '3', 'shortened' => 'Depósito Bancario para el canje de formulario y Carpeta.', 'name' => 'Depósito de Bs. 25.- en cuenta N° 1-13809229 del Banco Unión a para el canje de formulario y Carpeta.'],
            ['id' => '18', 'retirement_fund_modality_id' => '3', 'shortened' => 'Solicitud dirigida a la Dirección General Ejecutiva.', 'name' => 'Solicitud dirigida a la Dirección General Ejecutiva.'],
            ['id' => '19', 'retirement_fund_modality_id' => '3', 'shortened' => 'Fotocopia de Cédula de Identidad.', 'name' => 'Fotocopia simple de Cédula de Identidad.'],
            ['id' => '20', 'retirement_fund_modality_id' => '3', 'shortened' => 'Certificado de nacimiento.', 'name' => 'Certificado de nacimiento original y actualizado.'],
            ['id' => '21', 'retirement_fund_modality_id' => '3', 'shortened' => 'Memorándum de Agradecimiento de Servicios.', 'name' => 'Memorándum de Agradecimiento de Servicios otorgado por el Comando General de la Policía Boliviana (Original o Fotocopia Legalizada).'],
            ['id' => '22', 'retirement_fund_modality_id' => '3', 'shortened' => 'Certificado de Haberes de los últimos 36 meses de pago.', 'name' => 'Certificado de Haberes otorgado por el Comando General de la Policía Boliviana (Papeletas de haberes Original O Fotocopia Legalizada) de los últimos 36 meses de pago.'],
            ['id' => '23', 'retirement_fund_modality_id' => '3', 'shortened' => 'Reposición de Obrados Desglosado o Certificado de Años de Servicio.', 'name' => 'Reposición de Obrados Desglosado (Original) o Certificado de Años de Servicio (Copias Originales o fotocopia legalizada), emitidos por el C.A.S. desde la fecha de ingreso a la fecha de retiro definitivo de la institución policial de acuerdo a Memorándum de Agradecimiento.'],
            ['id' => '24', 'retirement_fund_modality_id' => '3', 'shortened' => 'Computo General Desglosado de Años de Servicio.', 'name' => 'Computo General Desglosado de Años de Servicio otorgado por el Comando General de la Policía Boliviana (Original).'],
            ['id' => '25', 'retirement_fund_modality_id' => '4', 'shortened' => 'Depósito Bancario para el canje de formulario y Carpeta.', 'name' => 'Depósito de Bs. 25.- en cuenta N° 1-13809229 del Banco Unión a para el canje de formulario y Carpeta.'],
            ['id' => '26', 'retirement_fund_modality_id' => '4', 'shortened' => 'Solicitud dirigida a la Dirección General Ejecutiva.', 'name' => 'Solicitud dirigida a la Dirección Ejecutiva.'],
            ['id' => '27', 'retirement_fund_modality_id' => '4', 'shortened' => 'Fotocopia de Cédula de Identidad del Afiliado fallecido.', 'name' => 'Fotocopia simple de Cédula de Identidad del Afiliado fallecido.'],
            ['id' => '28', 'retirement_fund_modality_id' => '4', 'shortened' => 'Certificado de Defunción del Afiliado fallecido.', 'name' => 'Certificado de Defunción original y actualizado.'],
            ['id' => '29', 'retirement_fund_modality_id' => '4', 'shortened' => 'Certificado de nacimiento del Afiliado fallecido.', 'name' => 'Certificado de nacimiento original y actualizado del fallecido.'],
            ['id' => '30', 'retirement_fund_modality_id' => '4', 'shortened' => 'Certificado de nacimiento del/la cónyugue y los hijos beneficiarios.', 'name' => 'Certificado de nacimiento original y actualizado del/la cónyugue y los hijos beneficiarios.'],
            ['id' => '31', 'retirement_fund_modality_id' => '4', 'shortened' => 'Certificado de matrimonio o Declaración de Matrimonio de Hecho o Unión Libre.', 'name' => 'Certificado de matrimonio original y actualizado o Declaración de Matrimonio de Hecho o Unión Libre.'],
            ['id' => '32', 'retirement_fund_modality_id' => '4', 'shortened' => 'Declaratoria de Herederos.', 'name' => 'Declaratoria de Herederos en original o fotocopia legalizada.'],
            ['id' => '33', 'retirement_fund_modality_id' => '4', 'shortened' => 'Certificación de verificación de descendencia y partidas matrimoniales emitida por el SERECI.', 'name' => 'Certificación de verificación de descendencia y partidas matrimoniales emitida por el SERECI.'],
            ['id' => '34', 'retirement_fund_modality_id' => '4', 'shortened' => 'Fotocopia de Cédula de Identidad del /la solicitante y todos los beneficiarios.', 'name' => 'Fotocopia simple de Cédula de Identidad del /la solicitante y todos los beneficiarios.'],
            ['id' => '35', 'retirement_fund_modality_id' => '4', 'shortened' => 'Formulario (AVC-04) de afiliación a la caja nacional de salud.', 'name' => 'Formulario (AVC-04) de afiliación a la caja nacional de salud (Original o fotocopia legalizada).'],
            ['id' => '36', 'retirement_fund_modality_id' => '4', 'shortened' => 'Certificado de Haberes de los últimos 36 meses de pago.', 'name' => 'Certificado de Haberes otorgado por el Comando General de la Policía Boliviana (Papeletas de haberes Original O Fotocopia Legalizada) de los últimos 36 meses de pago.'],
            ['id' => '37', 'retirement_fund_modality_id' => '4', 'shortened' => 'Reposición de Obrados Desglosado o Certificado de Años de Servicio.', 'name' => 'Reposición de Obrados Desglosado (Original) o Certificado de Años de Servicio (Copias Originales o fotocopia legalizada), emitidos por el C.A.S. desde la fecha de ingreso a la fecha de fallecimiento.'],
            ['id' => '38', 'retirement_fund_modality_id' => '4', 'shortened' => 'Computo General Desglosado de Años de Servicio.', 'name' => 'Computo General Desglosado de Años de Servicio otorgado por el Comando General de la Policía Boliviana (Original).'],
            ['id' => '39', 'retirement_fund_modality_id' => '4', 'shortened' => 'Certificado de Defunción ó certificado de obito en caso de fallecimiento de los beneficiarios del fallecido.', 'name' => 'Certificado de Defunción original y actualizado ó certificado de obito en caso de fallecimiento de los beneficiarios del fallecido.'],
            ['id' => '40', 'retirement_fund_modality_id' => '5', 'shortened' => 'Depósito Bancario para el canje de formulario y Carpeta.', 'name' => 'Depósito de Bs. 25.- en cuenta N° 1-13809229 del Banco Unión a para el canje de formulario y Carpeta.'],
            ['id' => '41', 'retirement_fund_modality_id' => '5', 'shortened' => 'Solicitud dirigida a la Dirección General Ejecutiva.', 'name' => 'Solicitud dirigida a la Dirección General Ejecutiva.'],
            ['id' => '42', 'retirement_fund_modality_id' => '5', 'shortened' => 'Fotocopia de Cédula de Identidad del solicitante.', 'name' => 'Fotocopia simple de Cédula de Identidad del solicitante.'],
            ['id' => '43', 'retirement_fund_modality_id' => '5', 'shortened' => 'Fotocopia de Cédula de Identidad del titular prestatario.', 'name' => 'Fotocopia simple de Cédula de Identidad del titular prestatario.'],
            ['id' => '44', 'retirement_fund_modality_id' => '5', 'shortened' => 'Memorándum de Baja  o Resolución Administrativa de Baja Definitiva', 'name' => 'Memorándum de Baja otorgado por el Comando General de la Policía Boliviana o Resolución Administrativa de Baja Definitiva (Fotocopia legalizada).'],
            ['id' => '45', 'retirement_fund_modality_id' => '5', 'shortened' => 'Certificado de Haberes de los últimos 36 meses de pago.', 'name' => 'Certificado de Haberes otorgado por el Comando General de la Policía Boliviana(Papeletas de haberes Original O Fotocopia Legalizada) de los últimos 36 meses de pago.'],
            ['id' => '46', 'retirement_fund_modality_id' => '5', 'shortened' => 'Computo General Desglosado de Años de Servicio.', 'name' => 'Computo General Desglosado de Años de Servicio otorgado por el Comando General de la Policía Boliviana (Original).'],
            ['id' => '47', 'retirement_fund_modality_id' => '5', 'shortened' => 'En caso del fallecimineto del titular prestatario debera presentar certificado de defunción.', 'name' => 'En caso del fallecimineto del titular prestatario debera presentar certificado de defunción en original y actualizado.']
        
        ];

        foreach ($statuses as $status) {
         
            Muserpol\Requirement::create($status);
            
        }
    }
}
