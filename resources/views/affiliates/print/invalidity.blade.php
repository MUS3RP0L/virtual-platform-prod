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
      <p align="right"> {!!$user->city->name ?? 'La Paz'!!}, {{ $dateHeader }}<br>CITE: UCE – EGSB /2017
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
             De la revisión efectuada por el Área Técnica de la Unidad de Otorgación del Beneficio del Complemento Económico, <b>se comunica a usted que percibe una prestación por INVALIDEZ COMUN.</b>
        </p>
    <p align="justify">
      Y en estricto cumplimiento al Decreto Supremo Nº 1446, de fecha 19 de diciembre de 2012, que crea la Mutual de Servicios al Policía ¨MUSERPOL¨, establece en su Artículo 17.- (Complemento Económico). Parágrafo I, modificado mediante D. S. Nº 3231 de fecha 27 de junio de 2017, con el siguiente texto: El Complemento Económico, es un beneficio que otorga la MUSERPOL al sector pasivo de la Policía Boliviana y sus derechohabientes de primer grado, <b><ins>con prestaciones por vejez</ins></b> en curso de pago del Sistema de Reparto y <b><ins>del Sistema Integral de Pensiones</ins></b> y con prestaciones por invalidez del Sistema de Reparto, cuyos montos sean inferiores al haber básico más categoría que perciban los miembros del servicio activo de la Policía en el grado correspondiente y los titulares hayan alcanzado la edad requerida para la jubilación por vejez y cumplido como mínimo con dieciséis (16) años de servicio en la Policía Boliviana
    <p align="justify">
      <b>Del Reglamento del Complemento Económico de 2017</b>, aprobado mediante Resolución de Directorio Nº 27/2017 de fecha 11 de agosto de 2017, norma en su <b>ARTÍCULO 7° (Exclusión).</b>Quedan excluidos del pago del beneficio del Complemento Económico: inc. 5.- Los titulares, derechohabientes de primer grado o huérfanos absolutos, <b>que perciben pensiones por Riesgo Común y/o Profesional e Invalidez Común y/o Profesional o muerte.</b></p>
    </p>
    <p align="justify"><b>
      Es decir, que en su boleta de jubilación no percibe una prestación por VEJEZ; por lo que no podrá acceder al Pago del Beneficio del Complemento Económico, correspondiente al {{ $current_semester }} Semestre de la Gestión {{ $current_year}}.
    </b></p>
    <p align="justify">
          Sin otro motivo en particular, saludo a usted.<br>
          Atentamente.
    </p>
</div>
@endsection
