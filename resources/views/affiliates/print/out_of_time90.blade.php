@extends('globalprint.print')
@section('title2')
<h3>(Página 1/2)</h3>
@endsection
@section('content')

<table>
  <p align="justify">
      En fecha {!! $date !!}, a horas {!! $hour !!} se <b>NOTIFICA</b> en forma personal al Sr.(a) {!! $eco_com_applicant->getTitleNameFull() !!} con <b>CARTA DE NOTIFICACIÓN de la Unidad de Complemento Económico N°</b> {!!$eco_com_applicant->code !!} de fecha {!! $eco_com_applicant->reception_date!!}, quien recibió en mano propia el original de dicho documento.
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
      <p align="right"> La Paz, {!! $date !!}

      <br>CITE: UCE - EGSB /{!! $eco_com_applicant->semester !!}./{!! $yearcomplement->year !!}.

      <br>CITE: UCE – EGSB /2017

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

              De la revisión efectuada por el Área Técnica la Unidad de Otorgación del Complemento Económico,  <b>se comunica a usted, que su trámite ingreso Fuera de Plazo.</b>
        </p>
    <p align="justify"><b>
      Y en estricto cumplimiento al Decreto Supremo Nº 1446</b>, de fecha 19 de diciembre de 2012, que crea la Mutual de Servicios al Policía ¨MUSERPOL¨, establece en su Artículo 17.- (Complemento Económico). El Complemento Económico es un Beneficio que otorga la MUSERPOL AL SECTOR PASIVO DE LA POLICIA BOLIVIANA y sus derechohabientes de primer grado con prestaciones por vejez en curso de pago del Sistema de Reparto y del Sistema Integral de Pensiones, cuyos montos sean inferiores al haber básico más categoría que perciban los miembros del servicio activo de la Policía Boliviana en el grado correspondiente. 
    </p>
    <p align="justify">
      Asimismo, se halla enmarcado en las normas legales vigentes, el <b>Reglamento del Complemento Económico de 2016</b>, aprobado mediante Resolución de Directorio Nº 36/2016 de fecha 09 de diciembre de 2016, que norma en su <b>ARTICULO 17° (Complemento Económico No Solicitado).<ins> Los beneficiarios nuevos</ins> </b>que no hayan presentado su solicitud de Inclusión en los plazos determinados según convocatoria semestral, <b><ins>contarán con un plazo de Noventa (90) días calendario, </ins></b> , para presentar solicitud del beneficio, posteriores a las fechas de pago, por lo que no se dará curso a solicitudes posteriores.
      </p>
          </p>

    <p align="justify">
      <ins><b>Los Beneficiarios habituales </b></ins> que no hayan presentado su solicitud, en los plazos determinados según convocatoria semestral, <ins><b>contarán con un plazo de Noventa (90) días calendario</b></ins>, para presentar solicitud del beneficio, posteriores a la fecha de pago, por lo que no se dará curso a solicitudes posteriores.   
    </p>
    <p align="justify"><b>
      Por lo que, al haber ingresado su trámite en fecha {!! $eco_com_applicant->reception_date!!}. y de acuerdo a los plazos establecidos de recepción de requisitos correspondiente al  {!! $eco_com_applicant->semester !!}. Semestre de la Gestión  {!! $yearcomplement->year !!}., que fenece el Haga clic aquí para escribir una fecha., su trámite ingreso fuera de plazo, por lo que no corresponde el pago del beneficio del Complemento Económico. </b>
    </p>
   
    <p align="justify">
          Sin otro motivo en particular, saludo a usted.<br>
          Atentamente.
    </p>
</div>
@endsection
