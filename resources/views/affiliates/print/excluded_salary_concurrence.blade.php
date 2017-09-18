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
      <h3>(Página 2/2)</h3>
    </b>
  </h1>
</header>
  <table>
      <p align="right">La Paz {!! $dateHeader !!}<br>CITE: UCE – EGSB /2017
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
              En atención al reclamo realizado por su persona en Secretaria de la Dirección General Ejecutiva, MUSERPOL – La Paz, <b>referente al Beneficio del Complemento Económico del {!! $eco_com_applicant->semester !!} Semestre de la gestión {!! $yearcomplement->year !!}</b>, se comunica lo siguiente: 
        </p>
    <p align="justify"><b>En estricto cumplimiento al Decreto Supremo Nº 1446</b>, de fecha 19 de diciembre de 2012, que crea la Mutual de Servicios al Policía ¨MUSERPOL¨, establece en su Artículo 3º.- (Funciones y fines). La MUSERPOL tiene las siguientes funciones y fines: inc. <b>5) Pagar el Complemento Económico al sector pasivo de la Policía Boliviana conforme a Reglamento</b>.
    <p align="justify">
     Del <b>Reglamento del Beneficio del Complemento Económico de la Gestión 2017</b>, aprobado mediante Resolución de Directorio Nº 27/2017 de fecha 11 de agosto de 2017, norma en su <b>Artículo 7° (Exclusión). Quedan excluidos del pago del beneficio del Complemento Económico:</b> inc. 2) Los titulares o derechohabientes de primer grado, con rentas en curso de pago iguales o superiores al haber básico más categoría que perciban los miembros del servicio activo de la Policía Boliviana en el grado correspondiente. 
    </p>
    <p align="justify">
      En concordancia con el <b>Artículo 24° (Casos especiales)</b>. Se consideran casos especiales los siguientes:
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
      En caso de Titulares, Viudas o Huérfanos Absolutos, que perciban sus prestaciones por vejez del Sistema Integral de Pensiones y tengan temporalmente suspendido uno de sus componentes, el cálculo del beneficio del Complemento Económico será realizado tomando en cuenta el monto del componente suspendido, <b>asimismo en caso de percibir la pensión de vejez o solidaria de vejez y simultáneamente la prestación de invalidez (concurrencia)</b>, el cálculo del beneficio será realizado sumando ambas prestaciones, a efecto de estandarizar el pago del beneficio del Complemento Económico, dicho procedimiento será realizado conforme la información proporcionada por la Autoridad de Fiscalización y Control de Pensiones y Seguros – APS. 
    </p>
    
    <p align="justify">
      Es decir que la renta y/o pensión de jubilación por vejez que percibe, es mayor al haber básico más categoría que perciben los miembros del servicio activo de la Policía Boliviana en el mismo grado, motivo por el cual <b>no le corresponde el Pago del Beneficio del Complemento Económico.</b><br><br>
      Con este motivo saludo a usted. <br><br>
      Atentamente,
        </p>
</div>
@endsection
