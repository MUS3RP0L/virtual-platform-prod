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
      <p align="right"> {!!$user->city->name ?? 'La Paz'!!}, {!! $dateHeader !!}<br>CITE: UCE - EGSB {!! $eco_com_applicant->semester !!}/{!! $yearcomplement->year !!}<br>CITE: UCE – EGSB /2017

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
         <p>

              De la revisión efectuada por el Área Técnica la Unidad de Otorgación del Complemento Económico,  <b>se comunica a usted, que su solicitud ingreso Fuera de Plazo.</b>
        </p>
    <p align="justify"><b>
      Y en estricto cumplimiento al Decreto Supremo Nº 1446</b>, de fecha 19 de diciembre de 2012, que crea la Mutual de Servicios al Policía ¨MUSERPOL¨, establece en su Artículo 3°, inc. 5.- Pagar el Complemento Económico al sector pasivo de la Policía Boliviana conforme a Reglamento. 
    </p>
    <p align="justify"><b>
      Del Reglamento del Beneficio del Complemento Económico de 2017</b>, aprobado mediante Resolución de Directorio Nº 27/2017 de fecha 11 de agosto de 2017, norma en su <b>ARTÍCULO 18° (Complemento Económico No Cobrado).</b> El importe del Complemento Económico no cobrado por los beneficiarios permanecerá en el auxiliar contable individual por <b>Ciento Veinte (120) días calendario para presentar solicitud del beneficio posterior a realizado el pago por la Entidad Bancaria o Financiera.</b> Cumplido el plazo, al igual que los importes remanentes de las transferencias por Gestión, con aprobación de la Máxima Autoridad Ejecutiva de la MUSERPOL, serán transferidos al saldo contable financiero del Complemento Económico. Situación que será puesta en conocimiento del Honorable Directorio.
      </p>
    <p align="justify">
      <b>Por lo que, al haber ingresado su solicitud de pago (rezagado) en fecha {!! $eco_com_applicant->reception_date!!}. y de acuerdo a los plazos establecidos según Reglamento del Complemento Económico no Cobrado {!! $eco_com_applicant->semester !!}. Semestre de la {!! $yearcomplement->year !!}., que feneció el {!! $procedure->additional_end_date !!}, su solicitud ingresó fuera de plazo, por lo que no corresponde el pago del beneficio del Complemento Económico.
      </b>
    </p>
   
    <p align="justify">
          Sin otro motivo en particular, saludo a usted.<br>
          Atentamente.
    </p>
</div>
@endsection
