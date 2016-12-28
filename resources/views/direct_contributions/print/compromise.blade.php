@extends('print')

@section('content')

<p align="justify">
    De acuerdo a la Resolución de Directorio 03/2003 del  20 de Febrero de 2003, se autoriza a los funcionarios policiales Jubilados (Titulares y Viudas) por las A.F.Ps.,aportar voluntariamente al seguro de Auxilio Mortuorio.
    Con forme a Dictamen Legal <b>CITE: DBE/UOFRPISSV/LBE/N°0075/14</b> referente a la solicitud de Aporte Voluntario, dictamina que <b>CUMPLE</b> con los <b>REQUISITOS</b> exigidos para la afiliacion al <b>Régimen Especial de Aporte Voluntario.</b>
    En este sentido, por el presente compromiso que tendrá todo el valor jurídico reconocido por las leyes, me comprometo al cumplimiento de las siguientes clausulas:
</p>
<p align="justify">
  <b>PRIMERA.- Yo, {{ $affiliate->getTittleName() }} con C.I. N°. {{ $affiliate->identity_card }} {{ $affiliate->city_identity_card_id }}.</b>
    Declaro haber pasado a la situación del servicio pasivo de acuerdo a la Ley de Pensiones 1732, asi como la Ley 065 del nuevo sistema de Jubilación, que no me permite realizar los aportes al Regimen Especial de Seguro de Vida, en las mismas condiciones que los del Sistema de Reparto <b>SENASIR</b>, que aportan mediante descuentos directos en planillas. Comprometiendome a depositar dicho aporte de manera trimestral en las condiciones establecidas en el Reglamento de Fondo de Retiro, aprobado mediante Resolución de Directorio N° 01/14, siendo que dicho pago debera efectivizarse hasta el 20 del mes siguiente al trimestre vencido, en forma directa en las oficinas de MUSERPOL (ex MUSEPOL), de  acuerdo al lugar donde radico y percibo mi renta de <b>Jubilación</b>. En el Interior del Estado Plurinacional mediante depósito bancario en cuentas fiscales de la MUSERPOL, debiendo entregar el comprobante respectivo en la Agencia Regional de MUSERPOL.
</p>
<p align="justify">
    <b>SEGUNDA.-</b> El porcentaje del aporte es del <b>1.50%</b> sobre el total de mi renta de jubilación calificada,  porcentaje sujeto a modificación, conforme a los intereses de MUSERPOL y al cambio que se efectuare en el monto de mi renta.
</p>
<p align="justify">
    <b>TERCERA.-</b> La continuidad de los aportes otorga el derecho a recibir el Beneficio Económico del Seguro de Vida.
</p>
<footer>
  PLATAFORMA VIRUTAL - MUTUAL DE SERVICIOS AL POLICIA
</footer>
<div class="page-break"></div>
      <header class="clearfix">
        <table class="tableh">
              <tr>
                <th style="width: 25%;border: 0px;">
                  <div id="logo">
                    <img src="assets/images/logo.jpg">
                  </div>
                </th>
                <th style="width: 50%;border: 0px">
                  <h3><b>MUTUAL DE SERVICIOS AL POLICÍA<br>
                     {!! $header1 !!} <br> {!! $header2 !!}
                      </b></h3>
                </th>
                <th style="width: 25%;border: 0px">
                  <div id="logo2">
                    <img src="assets/images/escudo.jpg">
                  </div>
                </th>
              </tr>
        </table>
        <br>
</header>
<p align="justify">
    <b>CUARTA.-</b> Declaro conocer las disposiciones legales que rigen el funcionamiento de MUSERPOL, por lo que dejo expresa constancia que me someto a ellas.
</p>
<p align="justify">
    <b>QUINTA.-</b> Declaro expresamente que estoy notificado al contenido del Reglamento de Fondo de Retiro Policial Individual, que señala Art. 1 inciso b) Seguro de Vida, Art. 6  y Art. 13 parágrafo II (Afiliación) <b>"Los solicitantes del sector pasivo correspondientes a las AFP's, Aseguradoras y otros jubilados, deberan afiliarse a la MUSERPOL presentando la documentación que acredite su calidad de rentista por la Policía Boliviana".</b>
</p>
<p align="justify">
    <b>SEXTA.-</b> Declaro expresamente mi aceptación y adecuaré mi afiliación voluntaria a la reglamentación de Fondo de Retiro Policial Individual, asi como las que pudieran aprobarse con relacion al Reglamento del Seguro de Vida, las politicas y demás disposiciones que adopte la MUSERPOL.
    Como constancia de conformidad firmo el presente documento.
</p>
<br>
<br>
<br>
<br>
<center>
     <b>La Paz, {{ Util::getAllDate($date) }}<b>
</center>
@endsection
