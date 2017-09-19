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
                <th class="info" style="border: 0px;text-align:center;"><b>C.I. N°: {{$eco_com_applicant->identity_card}} {{$eco_com_applicant->city_identity_card->first_shortened ?? ''}}</b></th>
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
  PLATAFORMA VIRTUAL - MUTUAL DE SERVICIOS AL POLICÍA
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
      <p align="right"> {!! $user->city->name ?? 'La Paz'!!}, {!! $dateHeader !!}<br>CITE: UCE - EGSB {!! $eco_com_applicant->semester !!}/{!! $yearcomplement->year !!}<br>CITE: UCE – EGSB /2017

      </p>
  </table>
  <table>
      <p align="left">Señor (a): <br>
        {!! $eco_com_applicant->getTitleNameFull() !!}<br>
      Presente.-
       </p>
  </table>
         <p align="right"><b>REF.- <ins> CARTA DE NOTIFICACIÓN </ins></b></p>
        <p align="justify">De nuestra consideración.</p>
         
    <p align="justify">
      Se comunica a usted, que mediante el Área Técnica de la Unidad de Otorgación del Beneficio del Complemento Económico se procedió con la revisión de la documentación presentada por su persona, respecto al Certificado de Años de Servicio, emitido por el Comando General de la Policía Boliviana y <b>se evidenció que existe inconsistencia en la CATEGORÍA consignada, en relación con el registro en la Base de Datos de la Unidad</b>.
    </p>
    <p align="justify">
      En tal sentido, de acuerdo a instrucciones contenidas en Memorándum DIR.GRAL.EJEC. N° 171/2017 y D.B.E. N° 0024/2017 de fecha 04 de septiembre de 2017, <b>su persona contará con el plazo de Treinta (30) días calendario a partir de su notificación formal, para aclarar o confirmar la CATEGORÍA del Elija un elemento. con el cual se estaba beneficiando del Complemento Económico hasta el Cobrado {!! $eco_com_applicant->semester !!}. Semestre de la gestión {!! $yearcomplement->year !!}</b>, en caso de no confirmar dicha CATEGORÍA, deberá proceder con la devolución de los montos pagados en demasía inicialmente a partir de la gestión 2013, dado que su fecha de inclusión a la planilla de beneficio puede ser anterior.
    </p>
   
    <p align="justify">
          Sin otro motivo en particular, saludo a usted.<br>
          Atentamente.
    </p>
</div>
@endsection
