<!DOCTYPE html>
<html lang="es">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>PLATAFORMA VIRTUAL - MUSERPOL</title>
  <link rel="stylesheet" href="css/style.css" media="all" />
</head>
<body>
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
            {!! $header1 !!}<br>{!! $header2 !!}
            @yield('title')
          </b></h4>
        </th>
        <th style="width: 25%;border: 0px">
          <div id="logo2">
            <img src="img/escudo.jpg">
          </div>
        </th>
      </tr>
    </table>
    <table class="table">
      <tr>
        <td style="border: 0px;text-align:left;">
          <div class="title"><b>Fecha Emisión: </b> La Paz, {!! $date !!}-{!! $hour !!}<br></div>
        </td>

        <td style="border: 0px;text-align:right;">
          <div class="title"><b>@yield('formnumber') <br><b> </div>
        </td>
      </tr>
    </table>
    <h1>
      <center><b>{{ $title }}</b></center>
      @yield('title2')
    </h1>
    <br>
    @yield('content')
  </header>

  <footer>
    PLATAFORMA VIRUTAL - MUTUAL DE SERVICIOS AL POLICÍA

      {{-- <div class="visible-print text-right">
        <table>
          <tr>
            <th class="info" style="border: 0px;text-align:right;width: 100% ">
                <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(115)->generate(
                $title.'                                     '.
                'Registro: Nº '.$economic_complement->code.' || '.
                $eco_com_applicant->getTitleNameFull().' || '.
                'Carnet de Identidad: '.$eco_com_applicant->identity_card.' '.$eco_com_applicant->city_identity_card->first_shortened.' || '.
                'Edad del Afiliado: '.$eco_com_applicant->getHowOld().' || '.
                'Numero de CUA/NUA: '.$eco_com_applicant->nua.' || '.
                'Tipo Renta: '.$economic_complement->economic_complement_modality->economic_complement_type->name
                )) !!} ">
            </th>
          </tr>
        </table>
      </div> --}}
  </footer>
</body>
</html>
