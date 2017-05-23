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
      <p align="right"> La Paz, {!! $date !!}
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
              De la revisión efectuada por el Área Técnica de la Unidad de otorgación del Complemento Económico, <b>se comunica a usted que a usted .figura como deudor, por registrar cartera en mora por préstamos otorgados por la MUSERPOL.</b>
        </p>
    <p align="justify"><b>Y en estricto cumplimiento al Decreto Supremo Nº 1446</b>, de fecha 19 de diciembre de 2012, que crea la Mutual de Servicios al Policía ¨MUSERPOL¨, establece en su Artículo 3º.- (Funciones y fines). La MUSERPOL tiene las siguientes funciones y fines: inc. <b>5) Pagar el Complemento Económico al sector pasivo de la Policía Boliviana conforme a Reglamento</b>.
    <p align="justify">Asimismo, se halla enmarcado en las normas legales vigentes, el <b>Reglamento del Complemento Económico de 2016</b>, aprobado mediante Resolución de Directorio Nº 36/2016 de fecha 09 de diciembre de 2016, que norma en su <b>ARTÍCULO 8° (Suspensión y habilitación).</b></p>

    </p>
    <table>
    <ol type="I">
      <li>
      El pago del beneficio del Complemento Económico quedará suspendido temporalmente en los siguientes  casos:
      </li>
            <ol type="1">
                <li>Cuando el beneficiario se encuentre registrado en el sistema contable de MUSERPOL como deudor por rendición de cuentas o fondos en avance. </li>
                <li><b>Cuando el beneficiario <ins>se encuentre registrado en cartera en mora</ins> por préstamos otorgados por la MUSERPOL.</b></li>
            </ol>
      <li>
          En los numerales 1 y 2 se efectuará las previsiones presupuestarias necesarias para la restitución del beneficio; el importe suspendido permanecerá en el auxiliar contable individual <b>y en caso de no presentar carta de autorización de amortización de deuda con el beneficio del Complemento de Económico; el importe suspendido, prescribirá en el lapso de Ciento Veinte (120) días calendario</b> a partir de efectuado el pago regular del beneficio semestralmente y será revertido al saldo contable financiero del Complemento Económico.
      </li>
      <li>
          El Beneficio del Complemento Económico será habilitado en los siguientes casos:
          <ol type="1">
              <li>
                A La presentación de certificación de no adeudo emitido por el Departamento Financiero de la MUSERPOL, documento que permitirá la viabilidad del pago a solicitud del interesado.
              </li>
              <li>
                <b>A La presentación de certificación de no adeudo o estado de cuotas de amortización semestral al día, emitido por la Dirección de Estrategias Sociales e Inversión de la MUSERPOL, documento que permitirá la viabilidad del pago a solicitud del interesado. Excepcionalmente se podrá amortizar la deuda con el beneficio del Complemento Económico en su integridad o como mínimo con el 50% del mismo, a solicitud escrita del interesado; procedimiento que será aprobado por la Dirección de Estrategias Sociales e Inversiones de la MUSERPOL, de acuerdo con su Reglamento</b>.
              </li>
          </ol>
      </li>
    </ol>
    </table>
        <p align="justify">
          Por lo que usted no podrá cobrar el Beneficio del Complemento Económico, correspondiente al <b> {!! $eco_com_applicant->semester !!} .</b> Semestre de   <b> {!! $yearcomplement->year !!} </b> , en tanto continúe registrado en cartera en mora por préstamos otorgados por la MUSERPOL.<br>
      Sin otro motivo en particular, saludo a usted.<br>
      Atentamente.
        </p>
</div>
@endsection
