@extends('globalprint.print')
@section('title2')
<h3>(Página 1/3)</h3>
@endsection
@section('content')

<table>
  <p align="justify">
     En fecha {!! $date !!}, a horas {!! $hour !!} se <b>NOTIFICA</b> en forma personal al Sr.(a) {!! $eco_com_applicant->getTitleNameFull() !!} con <b>CARTA DE NOTIFICACIÓN de la Unidad de Complemento Económico N°</b> {!!$eco_com_applicant->code !!} de fecha {!! $eco_com_applicant_date!!}, quien recibió en mano propia el original de dicho documento.
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
                <th class="info" style="border: 0px;text-align:center;"><b>{!! Auth::user()->getFullName() !!}<br> {!! Auth::user()->getAllRolesToString() !!}</b></th>        
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
      <h3>(Página 2/3)</h3>
    </b>
  </h1>
</header>
  <table>
      <p align="right">{!! $user->city->name ?? 'La Paz '!!} {!! $dateHeader !!}<br>CITE: UCE – EGSB /2017
      </p>
  </table>
  <table>
      <p align="left">Señor (a): <br>
      {!! $eco_com_applicant->getTitleNameFull() !!}.<br>
      Presente.-
       </p>
  </table>
         <p align="right"><b>REF.- <ins> CARTA DE NOTIFICACIÓN </ins></b></p>
        <p align="justify">De nuestra consideracion.</p>
         <p align="justify">
              Mediante la presente y en atención al reclamo realizado por su persona, se comunica que de la recalificación realizada por el Área Técnica de la Unidad de Otorgación del Complemento Económico, <b>el importe pagado de Bs. {!!$eco_com_applicant->total !!} es el correcto, considerando que su persona percibe una pensión por Jubilación y simultáneamente la prestación de invalidez (concurrencia).</b> 
        </p>
    <p align="justify"><b>Y en estricto cumplimiento al Decreto Supremo Nº 1446</b>, de fecha 19 de diciembre de 2012, que crea la Mutual de Servicios al Policía ¨MUSERPOL¨, establece en su Artículo 3º.- (Funciones y fines). La MUSERPOL tiene las siguientes funciones y fines: inc. <b>5) Pagar el Complemento Económico al sector pasivo de la Policía Boliviana conforme a Reglamento</b>.
    <p align="justify">
     Asimismo, se halla enmarcado en las normas legales vigentes, del <b>Reglamento del Complemento Económico de la gestión 2017</b>, aprobado mediante Resolución de Directorio Nº 27/2017 de fecha 11 de agosto de 2017, que norma en su <b>ARTICULO 24° (Casos Especiales)</b>. Se consideran casos especiales los siguientes:
    </p>
    <ul type="1">
      <li>
        Renta y/o pensión solo con Compensación de Cotizaciones.
      </li>
      <li>
        Renta y/o pensión solo con acumulación de saldo de capital.
      </li>
      <li>
        Renta y/o pensión calificadas con reducción de edad.
      </li>
    </ul>
    <p align="justify">
      El cálculo del importe para el pago del beneficio del Complemento Económico y la procedencia del mismo en los casos anteriormente señalados, serán determinados en el Estudio Técnico Financiero, estableciéndose como casos especiales.
    </p>
    <p align="justify">
      En caso de Titulares, Viudas o Huérfanos Absolutos, que perciban sus prestaciones por vejez del Sistema Integral de Pensiones y tengan temporalmente suspendido uno de sus componentes, el cálculo del beneficio del Complemento Económico será realizado tomando en cuenta el monto del componente suspendido, asimismo <ins>en caso de percibir la pensión de vejez o solidaria de vejez y simultáneamente la prestación de invalidez (concurrencia), el cálculo del beneficio será realizado sumando ambas prestaciones, a efecto de estandarizar el pago del beneficio del Complemento Económico, dicho procedimiento será realizado conforme la información proporcionada por la Autoridad de Fiscalización y Control de Pensiones y Seguros – APS</ins>. 
    </p>
    <p align="justify">
      Una vez recepcionado el reclamo escrito, se dará respuesta a la (el) solicitante, mediante carta de notificación, en caso de ser representado, la Unidad de Complemento Económico, efectuará un análisis técnico-legal de la documentación presentada por el beneficiario, asimismo se podrá solicitar complementaciones e información adicional a la Autoridad de Fiscalización y Control de Pensiones y Seguros, Servicio Nacional de Sistema de Reparto, Comando General de la Policía Boliviana y otras entidades requeridas. Una vez revisada la documentación presentada, se procederá a la emisión de un informe técnico-legal dentro del plazo de quince (15) días hábiles desde el día hábil siguiente a la presentación de reclamo.
    </p>
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
          <h3>(Página 3/3)</h3>
        </b>
      </h1>
    </header>

    <p align="justify">
      Por lo que de la recalificación y revisión realizada con referencia al monto de pago del Beneficio del Complemento Económico, correspondiente al {!! $eco_com_applicant->semester !!} Semestre de la gestión {!! $eco_com_applicant->year !!}, por el importe de Bs. {!! $eco_com_applicant->total !!}, <b>no existe error en el monto pagado</b>. Asimismo, comunicar a su persona que el monto individual del Complemento Económico es <b>variable</b>, determinado semestralmente en base a un Estudio Técnico Financiero y Reglamentación, aprobado por el Directorio de la MUSERPOL, en función a las transferencias determinadas por Ley para el pago del Complemento Económico.
      <br><br>
      Sin otro motivo en particular, saludo a usted. <br><br>
      Atentamente,
        </p>
</div>
@endsection
