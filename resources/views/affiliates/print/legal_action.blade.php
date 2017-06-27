@extends('globalprint.print')
@section('title2')
<h3>(Página 1/2)</h3>
@endsection
@section('content')

<table>
  <p align="justify">
      En fecha {!! $date !!}, a horas {!! $hour !!} se <b>NOTIFICA</b> en forma personal al Sr.(a) {!! $eco_com_applicant->getTitleNameFull() !!} con <b>CARTA DE NOTIFICACIÓN de la Unidad de Complemento Económico N°</b> {!! $eco_com_applicant->code !!} de fecha {!! $eco_com_applicant_date !!}, quien recibió en mano propia el original de dicho documento.
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
        <td class="grand service" style="text-align:center;width: 10%;height: 10%"><p align="center">FIRMA DEL NOTIFICADO.</p></td>
      </tr>
        <tr>
        <td class="grand service" style="text-align:center;width: 10%;height: 10%"><p align="center">ACLARACIÓN DE FIRMA.</p></td>
      </tr>
    </tbody>
  </table>
<footer>
  PLATAFORMA VIRUTAL - MUTUAL DE SERVICIOS AL POLICIA
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
      <p align="right"> La Paz {!! $dateHeader !!}<br>CITE: UCE – EGSB /2017
      </p>
  </table>
  <table>
      <p align="left">Señor (a): <br>
      {!! $eco_com_applicant->getTitleNameFull() !!}<br>
      Presente.-
       </p>
  </table>
         <p align="right"><b>REF.- <ins> CARTA DE NOTIFICACIÓN </ins></b></p>
        <p align="justify">De nuestra consideracion.</p>
         <p>
              De la revisión efectuada por el Área Técnica de la Unidad de Otorgación del Complemento Económico, <b>Se comunica que usted, figura como :Acusado en los Procesos Judiciales seguido por la MUSEPOL y/o MUSERPOL.</b>
        </p>
    <p align="justify"><b>
      Y en estricto cumplimiento al Decreto Supremo Nº 1446</b>, de fecha 19 de diciembre de 2012, que crea la Mutual de Servicios al Policía ¨MUSERPOL¨, establece en su Artículo 3º.- (Funciones y fines). La MUSERPOL tiene las siguientes funciones y fines: inc. 5) <b>Pagar el Complemento Económico al sector pasivo de la Policía Boliviana conforme a Reglamento. </b>
    <p align="justify">
      Asimismo, se halla enmarcado en las normas legales vigentes, el <b>Reglamento del Complemento Económico de 2016</b>, aprobado mediante Resolución de Directorio Nº 36/2016 de fecha 09 de diciembre de 2016, que norma en su <b>ARTÍCULO 7° (Exclusión). Quedan excluidos del pago del beneficio del Complemento Económico:</b>inc. 4.-  Cuando el afiliado semestralmente se encuentre en calidad de imputado, acusado o sentenciado en proceso judicial seguido por la MUSEPOL y/o MUSERPOL en su contra. La sentencia absolutoria ejecutoriada, que pueda emitir el órgano judicial a favor del procesado por MUSEPOL y/o MUSERPOL, es el documento que permitirá la viabilidad de pago a solicitud del interesado, a partir del siguiente semestre de pago de Complemento Económico.</p>

    </p>

    <p align="justify">

          Por lo que no se puede efectuar el Pago del Beneficio del Complemento Económico, correspondiente al <strong>{!! $eco_com_applicant->semester !!}</strong>  Semestre de la Gestión <strong>{!! $yearcomplement->year !!}</strong>, en tanto continúe figurando con Procesos Judiciales<br>

          Sin otro motivo en particular, saludo a usted.<br>
          Atentamente.
    </p>
</div>
@endsection
