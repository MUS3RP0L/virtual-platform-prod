@extends('globalprint.print')
@section('title2')
<h3>(Página 1/3)</h3>
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
<br>
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
              De la revisión efectuada por el Área Técnica de la Unidad de otorgación del Complemento Económico, <b>se comunica a usted, que no cumple con los requisitos establecidos según Reglamento vigente, para acceder al Beneficio del Complemento Económico del  {!! $eco_com_applicant->semester !!} semestre de la Gestión {!! $yearcomplement->year !!}  .</b>
        </p>
        <p align="justify"><b>Y en estricto cumplimiento al Decreto Supremo Nº 1446</b>, de fecha 19 de diciembre de 2012, que crea la Mutual de Servicios al Policía ¨MUSERPOL¨, establece en su Artículo 3º.- (Funciones y fines). La MUSERPOL tiene las siguientes funciones y fines: inc. <b>5) Pagar el Complemento Económico al sector pasivo de la Policía Boliviana conforme a Reglamento</b>.
              <p align="justify">Asimismo, se halla enmarcado en las normas legales vigentes, el <b>Reglamento del Complemento Económico de 2016</b>, aprobado mediante Resolución de Directorio Nº 36/2016 de fecha 09 de diciembre de 2016, <b> que norma en su ARTÍCULO 22° (Requisitos para la Inclusión y Calificación).</b> Los requisitos para la habilitación de nuevos beneficiaros para el cobro del Complemento Económico son los siguientes: </p>
        </p>
    <table>
    <ol type="1">
      <li>
                Titulares.-
      </li>
            <ol type="a">
                <li> Adquisición del folder y la solicitud escrita pre diseñada de Inclusión, dirigida al Director (a) General Ejecutivo (a) de la MUSERPOL; por una sola vez para nuevos beneficiarios, por un valor de Bs. 5.-, a ser depositados en la cuenta fiscal de la MUSERPOL. </li>
                <li> Fotocopia de Cédula de Identidad.</li>
                <li> Fotocopia legible de memorándum de Agradecimiento de servicios emitido por el Comando General de la Policía Boliviana.</li>
                <li> Fotocopia legible de Certificación de Años de Servicio emitida por el Comando General de la Policía Boliviana, que acredite como mínimo Dieciséis (16) años de servicio en la Policía Boliviana.</li>
                <li> Fotocopia de la Resolución de SENASIR o contrato de la AFP o de la Aseguradora; excepcionalmente se podrá admitir fotocopia legalizada de la Resolución otorgada de renta de vejez o Certificación original de AFP donde indique que se cuenta con la Compensación de Cotizaciones activa.</li>
                <li> Fotocopia legible de boleta de renta y/o pensión de jubilación del mes de enero o anterior (diciembre), (para habilitarse al pago del primer semestre) y fotocopia de boleta de renta y/o pensión de jubilación, del mes de julio o anterior (junio), (para habilitarse al pago del segundo semestre).</li>
                <li> Documento con carácter de Declaración Jurada, firmada por la (el) solicitante, en observancia de la Ley Nº 1178 de Administración y Control Gubernamentales, Constitución Política del Estado Plurinacional de Bolivia.</li>
            </ol>
    </ol>
    </table>
    <table>
                  <p align="left">
                          Estos requisitos deben ser presentados en doble ejemplar.
                  </p>
    </table>
                  <p align="justify">
                          Al fallecimiento del titular solo podrán cobrar el beneficio del Complemento Económico, la Viuda o Huérfanos Absolutos.
                  </p>
                  <p align="justify">
                            <b>En observancia al Artículo 28° (Observación documental). </b> I. En los casos que se haya presentado solicitud de Pago del Complemento Económico y se evidencie alguna observación o inconsistencia de índole documental, será comunicado mediante carta de notificación <b> y tendrá un plazo de 90 días calendario, para gestionar la documentación faltante.</b> En caso de no presentar la documentación faltante y prescrito el plazo señalado, no podrá acceder al Pago del Complemento Económico del semestre o semestres solicitados. En caso de ser representada dicha carta, se procederá con la emisión de un Informe Técnico – Legal.
                  </p>
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
                  <h3>(Página 3/3)</h3>
                </b>
              </h1>
            </header>
                      <table>
                              <p align="justify">
                                Por lo que usted no podrá cobrar el Beneficio del Complemento Económico, correspondiente al {!! $eco_com_applicant->semester !!} . Semestre de {!! $yearcomplement->year !!} , en tanto continúe registrado en cartera en mora por préstamos otorgados por la MUSERPOL.<br>
                                Sin otro motivo en particular, saludo a usted.<br>
                                Atentamente.
                              </p>
                      </table>

</div>
@endsection
