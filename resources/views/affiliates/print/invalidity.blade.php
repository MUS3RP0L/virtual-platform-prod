@extends('globalprint.print')
@section('title2')
<h3>(Página 1/2)</h3>
@endsection
@section('content')

<table>
  <p align="justify">
      En fecha ……../…..…./.…., a horas…..…………se <b>NOTIFICA</b> en forma personal al Sr.(a)…………………………………………..………………….con <b>CARTA DE NOTIFICACIÓN de la Unidad de Complemento Económico N°</b> …………de fecha….…/………/……., quien recibió en mano propia el original de dicho documento.
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
      <p align="right"> La Paz, Elija un elemento. de Elija un elemento. de 2017
      <br>CITE: UCE – EGSB /2017
      </p>
  </table>
  <table>
      <p align="left">Señor (a): <br>
      Haga clic aquí para escribir texto.……………………………………………..<br>
      Presente.-
       </p>
  </table>
         <p align="right"><b>REF.- <ins> CARTA DE NOTIFICACIÓN </ins></b></p>
        <p align="justify">De nuestra consideracion.</p>
         <p>
              De la revisión efectuada por el Área Técnica de la Unidad de otorgación del Complemento Económico, <b>se comunica a usted que percibe una prestación por ... .</b>
        </p>
    <p align="justify"><b>
      Y en estricto cumplimiento al Decreto Supremo Nº 1446</b>, de fecha 19 de diciembre de 2012, que crea la Mutual de Servicios al Policía ¨MUSERPOL¨, establece en su Artículo 17.- (Complemento Económico). El Complemento Económico es un Beneficio que otorga la MUSERPOL AL SECTOR PASIVO DE LA POLICIA BOLIVIANA y sus derechohabientes de primer grado <b><ins>CON PRESTACIONES POR VEJEZ</b></ins>en curso de pago del Sistema de Reparto y del Sistema Integral de Pensiones, cuyos montos sean inferiores al haber básico más categoría que perciban los miembros del servicio activo de la Policía Boliviana en el grado correspondiente.
    <p align="justify">
      Asimismo, se halla enmarcado en las normas legales vigentes, el <b>Reglamento del Complemento Económico de 2016</b>, aprobado mediante Resolución de Directorio Nº 36/2016 de fecha 09 de diciembre de 2016, que norma en su <b>ARTÍCULO 7° (Exclusión).</b>Quedan excluidos del pago del beneficio del Complemento Económico: inc. 6.- Los titulares, derechohabientes de primer grado o huérfanos absolutos, <b>que perciben rentas y/o pensión por Riesgo Común y/o Profesional e Invalidez Común y/o Profesional o muerte.</b></p>
    </p>
    <p align="justify"><b>
      Es decir, que en su boleta de jubilación no percibe una prestación por VEJEZ; por lo que no podrá acceder al Pago del Beneficio del Complemento Económico, correspondiente al ... Semestre de la Gestión ... .
    </b></p>
    <p align="justify">
          Sin otro motivo en particular, saludo a usted.<br>
          Atentamente.
    </p>
</div>
@endsection
