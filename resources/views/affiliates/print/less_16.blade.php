@extends('globalprint.print')
@section('title2')
<h3>(Página 1/2)</h3>
@endsection
@section('content')

<table>
  <p align="justify">
      En fecha {!! $date !!}, a horas {!! $hour !!} se <b>NOTIFICA</b> en forma personal al Sr.(a) {!! $eco_com_applicant->getTitleNameFull() !!} con <b>CARTA DE NOTIFICACIÓN</b> CITE N° {!!$eco_com_applicant->code !!} de la <b>UNIDAD DE OTORGACIÓN DEL BENEFICIO DEL COMPLEMENTO ECONÓMICO - MUSERPOL</b> de fecha {!! $eco_com_applicant_date!!}, quien recibió en mano propia el original de dicho documento.
  </p>
</table>
<br><br>
  <table align="center" width="10" >
    <thead>
      <tr>
        <th align="center"></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="grand service" style="text-align:center;width: 10%;height: 10%"><p align="center">FIRMA DEL NOTIFICADO(A).</p>
        <table>
             <tr>
                <th class="info" style="border: 0px;text-align:center;"><p>&nbsp;</p><br>-------------------------------------------</th>
              </tr>
              <tr>
                <th class="info" style="border: 0px;text-align:center;"><b>C.I. N°: {{$eco_com_applicant->identity_card}}</b></th>
              </tr>
              <tr>
                @if($eco_com_applicant->getPhone())
                <th class="info" style="border: 0px;text-align:center;"><b>TELF/CEL: <br><ins>{{ $eco_com_applicant->getPhone() }}</ins></b></th>        
              </tr>
              @else
              <th class="info" style="border: 0px;text-align:center;"><b>TELF/CEL:</b><br><br>-------------------------------------------</th>
              @endif
        </table>
        </td>
      </tr>
        <tr>
        <td class="grand service" style="text-align:center;width: 10%;height: 10%"><p align="center">NOTIFICADO POR:</p>
          <table>
              <tr>
                <th class="info" style="border: 0px;text-align:center;"><p>&nbsp;</p><br>-------------------------------------------</th>
              </tr>
              <tr>
                <th class="info" style="border: 0px;text-align:center;"><b>{!! Auth::user()->first_name !!} {!! Auth::user()->last_name !!} <br> {!! Auth::user()->getAllRolesToString() !!}</b></th>        
              </tr>
          </table>
        </td>
      </tr>
    </tbody>
  </table>
<footer>
  PLATAFORMA VIRTUAL - MUTUAL DE SERVICIOS AL POLICIA
</footer>
<div class="page-break"></div>
<header class="clearfix">
  <table class="tableh">
    <tr>
      <th style="width: 25%;border: 0px;">
        <div id="logo">
          <img src="img/logo.jpg">
        </div>
      </th>
      <th style="width: 50%;border: 0px">
        <h4><b>MUTUAL DE SERVICIOS AL POLICIA<br>
          {!! $header1 !!} <br> {!! $header2 !!}
        </b></h4>
      </th>
      <th style="width: 25%;border: 0px">
        <div id="logo2">
          <img src="img/escudo.jpg">
        </div>
      </th>
    </tr>
  </table>
  <h1>
    <b>
      {{ $title }}<br>
      <h3>(Página 2/2)</h3>
    </b>
  </h1>
</header>
  <table>
      <p align="right"> La Paz {!!$dateHeader!!}<br>CITE: UCE – EGSB /2017
      </p>
  </table>
  <table>
      <p align="left">Señor (a): <br>
      {!! $eco_com_applicant->getTitleNameFull() !!} .<br>
      Presente.-
       </p>
  </table>
         <p align="right"><b>REF.- <ins> CARTA DE NOTIFICACIÓN </ins></b></p>
        <p align="justify">De nuestra consideración.</p>
         <p>
              De la revisión efectuada por el Área Técnica de la Unidad de otorgación del Complemento Económico, <b>se comunica que usted no acredita como mínimo 16 años de servicio en la Policía Boliviana.</b>
        </p>
    <p align="justify"><b>
      Y en estricto cumplimiento al Decreto Supremo Nº 1446</b>, de fecha 19 de diciembre de 2012, que crea la Mutual de Servicios al Policía ¨MUSERPOL¨, establece en su Artículo 3º.- (Funciones y fines). La MUSERPOL tiene las siguientes funciones y fines: inc. 5) <b>Pagar el Complemento Económico al sector pasivo de la Policía Boliviana conforme a Reglamento.</b>
    <p align="justify">
      <b>Del Reglamento del Beneficio del Complemento Económico de 2017</b>, aprobado mediante Resolución de Directorio Nº 27/2017 de fecha 11 de agosto de 2017, norma en su <b>ARTÍCULO 7° (Exclusión). Quedan excluidos del pago del beneficio del Complemento Económico:</b> inc. 6) Los Titulares, Viudas y Huérfanos absolutos con rentas en curso de pago del Sistema de Reparto o del Sistema Integral de Pensiones, que soliciten su inclusión al beneficio <b>y no acrediten en la Certificación de Años de Servicio, emitida por el Comando General de la Policía Boliviana; como mínimo 16 años de servicio.</b>
      <p aling="justify">
      En concordancia con el CAPITULO III BENEFICIARIOS, ARTICULO 21° (Beneficiarios). Son beneficiarios del cobro del beneficio del Complemento Económico:
      </p>
      <ul type="1">
        <li><b>
              Los titulares</b> con rentas por vejez e invalidez, en curso de pago del Sistema de Reparto y vejez del Sistema Integral de Pensiones, <b>que acrediten como mínimo Dieciséis (16) años de servicio en la Policía Boliviana</b> de acuerdo con los requisitos establecidos y que no se encuentren comprendidos en los casos señalados en los artículos 7 y 8 del presente Reglamento.
        </li>
        <li><b>
              Las viudas</b> con rentas por vejez e invalidez en curso de pago del Sistema de Reparto y vejez del Sistema Integral de Pensiones, <b>cuyos causahabientes hayan acreditado como mínimo Dieciséis (16) años de servicio en la Policía Boliviana</b> de acuerdo con los requisitos establecidos y que no se encuentren comprendidos en los casos señalados en los artículos 7 y 8 del presente Reglamento.
        </li>
        <li>
              Los huérfanos absolutos con rentas por vejez e invalidez en curso de pago del Sistema de Reparto y vejez del Sistema Integral de Pensiones, que se encuentren en total dependencia. De manera excepcional el beneficio se extenderá hasta los Veinticinco (25) años de edad, siempre cuando se acredite estado de incapacidad o condición de estudios, <b>cuyos causahabientes hayan acreditado como mínimo Dieciséis (16) años de servicio en la Policía Boliviana</b> de acuerdo con los requisitos y que no se encuentren comprendidos en los casos señalados en los artículos 7 y 8 del presente Reglamento.
        </li>
          </ul>
          </p>

    <p align="justify">
    En consecuencia, <b> siendo que usted no  cuenta con un mínimo de 16 años de servicio en la Policía Boliviana</b>, no podrá acceder al Pago del Beneficio del Complemento Económico correspondiente al <strong>{!! $eco_com_applicant->semester !!}</strong> Semestre de la Gestión <strong>{!! $yearcomplement->year !!}</strong>.</p> 
          Sin otro motivo en particular, saludo a usted.<br>
          Atentamente.
    </p>
</div>
@endsection
