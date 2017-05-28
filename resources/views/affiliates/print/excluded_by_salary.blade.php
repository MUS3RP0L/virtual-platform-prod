@extends('globalprint.print')
@section('title2')
<h3>(Página 1/2)</h3>
@endsection
@section('content')

<table>
  <p align="justify">
     En fecha {!! $date !!}, a horas {!! $hour !!} se <b>NOTIFICA</b> en forma personal al Sr.(a) {!! $eco_com_applicant->getTitleNameFull() !!} con <b>CARTA DE NOTIFICACIÓN de la Unidad de Complemento Económico N°</b> {!!$eco_com_applicant->code !!} de fecha {!! $eco_com_applicant->reception_date!!}, quien recibió en mano propia el original de dicho documento.
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
      <p align="right"> La Paz, {{!!$date!!}}
      <br>CITE: UCE – EGSB /2017
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
         <p>
              De la revisión efectuada por el Área Técnica de la Unidad de otorgación del Complemento Económico, <b>se comunica a usted, que <ins>es excluido (a) por salario.</ins></b>
        </p>
    <p align="justify"><b>Y en estricto cumplimiento al Decreto Supremo Nº 1446</b>, de fecha 19 de diciembre de 2012, que crea la Mutual de Servicios al Policía ¨MUSERPOL¨, establece en su Artículo 3º.- (Funciones y fines). La MUSERPOL tiene las siguientes funciones y fines: inc. <b>5) Pagar el Complemento Económico al sector pasivo de la Policía Boliviana conforme a Reglamento</b>.
    <p align="justify">Asimismo, se halla enmarcado en las normas legales vigentes,  <b>el Reglamento del Complemento Económico de 2016</b>, aprobado mediante Resolución de Directorio Nº 36/2016 de fecha 09 de diciembre de 2016, que norma en su <b>ARTÍCULO 7° (Exclusión). Quedan excluidos del pago del beneficio del Complemento Económico: inc. 2.- Los titulares o derechohabientes de primer grado, con rentas en curso de pago iguales o superiores al haber básico más categoría que perciban los miembros del servicio activo de la Policía Boliviana en el grado correspondiente.</b></p>
    </p>
    <p align="justify">
              Por lo que usted, <b>es excluido (a) por salario</b>, por percibir una prestación por vejez igual o superior al haber básico más categoría que perciben los miembros del servicio activo de la Policía Boliviana en el grado correspondiente y no podrá cobrar el Beneficio del Complemento Económico, correspondiente al   {!! $eco_com_applicant->semester !!} Semestre de {!! $yearcomplement->year !!} .
    </p>
        <p align="justify">
          Se sugiere aguardar a la fecha de convocatoria del ... Semestre de ... <b> para presentar la boleta de jubilación de vejez;</b> para que se proceda con una nueva calificación y determinar si procede o no el Pago del Beneficio del Complemento Económico.<br>
          Sin otro motivo en particular, saludo a usted. <br>
          Atentamente,
        </p>
</div>
@endsection
