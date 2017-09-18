@extends('globalprint.print')
@section('title2')
<h3>(Página 1/3)</h3>
@endsection
@section('content')

<table>
   <p align="justify">
      En fecha {!! $date !!}, a horas {!! $hour !!} se <b>NOTIFICA</b> en forma personal al Sr.(a) {!! $eco_com_applicant->getTitleNameFull() !!} con <b>CARTA DE NOTIFICACIÓN</b> CITE N° {!!$eco_com_applicant->code !!} de la <b>UNIDAD DE OTORGACIÓN DEL BENEFICIO DEL COMPLEMENTO ECONÓMICO - MUSERPOL</b> de fecha {!! $eco_com_applicant_date!!}, quien recibió en mano propia el original de dicho documento.
  </p>
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
        <h4><b>MUTUAL DE SERVICIOS AL POLICÍA<br>
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
      <p align="right"> La Paz, {!! $dateHeader !!}
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
              De la revisión efectuada por el Área Técnica de la Unidad de Otorgación del Complemento Económico, <b>se comunica a usted  que no cumple con los requisitos establecidos según Reglamento vigente, para acceder al Beneficio del Complemento Económico del  {!! $eco_com_applicant->semester !!}. Semestre de la Gestión {!! $yearcomplement->year !!}.</b>
        </p>
    <p align="justify"><b>
      Y en estricto cumplimiento al Decreto Supremo Nº 1446</b>, de fecha 19 de diciembre de 2012, que crea la Mutual de Servicios al Policía ¨MUSERPOL¨, establece en su Artículo 3º.- (Funciones y fines). La MUSERPOL tiene las siguientes funciones y fines: inc. <b>5) Pagar el Complemento Económico al sector pasivo de la Policía Boliviana conforme a Reglamento</b>.
    <p align="justify">
      <b>Del Reglamento del Beneficio del Complemento Económico de 2017</b>, aprobado mediante Resolución de Directorio Nº 27/2017 de fecha 11 de agosto de 2017, <b>norma en su Artículo 22° (Requisitos para la Inclusión y Calificación).</b> Los requisitos para la habilitación de nuevos beneficiaros para el cobro del Beneficio del Complemento Económico, serán presentados en fotocopias simples, previamente verificados con los originales, por los Agentes Regionales y Atención en Ventanilla, MUSERPOL – La Paz y asimismo el Área Técnica de la Unidad de Complemento Económico, realizará la revisión de los requisitos establecidos en el presente Reglamento, que se detallan a continuación: </p>
      <p align="justify">
      <b>1. Titulares.</b>
      </p>
   
    <ul type="a">
        <li>
              Adquisición del folder y la solicitud escrita pre diseñada de Inclusión, dirigida al Director (a) General Ejecutivo (a) de la MUSERPOL y/o carta generada por el módulo de la Unidad de Complemento Económico; por una sola vez para nuevos beneficiarios, por un valor de Bs. 5.-, a ser depositados en la cuenta fiscal de la MUSERPOL.
        </li>
        <li>
          Fotocopia de Cédula de Identidad.
        </li>
        <li>
          Fotocopia legible de memorándum de Agradecimiento de servicios emitido por el Comando General de la Policía Boliviana.
        </li>
        <li>
          Fotocopia legible de Certificación de Años de Servicio emitida por el Comando General de la Policía Boliviana, que acredite como mínimo Dieciséis (16) años de servicio en la Policía Boliviana.
        </li>
        <li>
          Fotocopia de la Resolución de SENASIR o contrato de la AFP o de la Aseguradora; excepcionalmente se podrá admitir fotocopia legalizada de la Resolución otorgada de renta de vejez o Certificación original de AFP donde indique que se cuenta con la Compensación de Cotizaciones activa.
        </li>
        <li>
          Fotocopia legible de boleta de renta y/o pensión de jubilación del mes de enero o anterior (diciembre), (para habilitarse al pago del primer semestre) y fotocopia de boleta de renta y/o pensión de jubilación, del mes de julio o anterior (junio), (para habilitarse al pago del segundo semestre). 
        </li>
        <li>
          Documento con carácter de Declaración Jurada, firmada por la (el) solicitante, en observancia de la Constitución Política del Estado Plurinacional de Bolivia y la Ley Nº 1178 de Administración y Control Gubernamentales.
        </li>
    </ul>
          </p>
    <p align="justify">
      Estos requisitos deben ser presentados en doble ejemplar.<br>
      Al fallecimiento del titular solo podrán cobrar el beneficio del Complemento Económico, la Viuda o Huérfanos Absolutos.
    </p>
    <p align="justify">
      <b>En observancia del Artículo 26º</b>, Parágrafo III.  En los siguientes casos, se emitirá respuesta prediseñada, <b>Inc. h) Incumplimiento de requisitos de Inclusión.</b>
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
            <h4><b>MUTUAL DE SERVICIOS AL POLICÍA<br>
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
      Respecto a los incisos <b>h)</b> e <b>i)</b> contaran con un plazo de 90 días calendarios a partir de la notificación, para presentar los requisitos faltantes, vencido el plazo no podrá acceder al pago del Beneficio del Complemento Económico del Semestre solicitado.
    </p>    
    <p align="justify">
          Por lo que usted no podrá acceder al Beneficio del Complemento Económico, correspondiente al <strong>{!! $eco_com_applicant->semester !!}</strong>. Semestre de la gestión <strong>{!! $yearcomplement->year !!}</strong>, en tanto no subsane los requisitos faltantes citados lineas arriba, pintados en negrilla.<br>
          Sin otro motivo en particular, saludo a usted.<br>
          Atentamente.
    </p>
</div>
@endsection
