<!DOCTYPE html>
<html lang="es">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>PLATAFORMA VIRTUAL - MUSERPOL</title>
  <link rel="stylesheet" href="css/style.css" media="all" />
  <style>
    .qrCode{
      position: absolute;
      left: 80%;
      bottom: 15%;
    }
  </style>
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
          <div class="title"><b>Fecha Emisión: </b> {{ $user->city->name ?? 'La Paz'}}, {!! $date !!} - {!! $hour !!}<br></div>
        </td>
        @if(isset($user))
        <td style="border: 0px;text-align:right;">
          <div class="title"><b>Usuario: </b> {!! $user->username !!} - {!! $user_role !!} <br></div>
        </td>
        @endif
      </tr>
    </table>
    <br>
    @if($title)
    <h1>
      <center><b>{{ $title }}</b></center>
      @yield('subtitle')
      @yield('title2')
    </h1>
    @endif
    <br>
    @yield('content')
  </header>
  <footer>
    PLATAFORMA VIRTUAL DE LA MUTUAL DE SERVICIOS AL POLICÍA - 2017
      <div class="visible-print text-right">
        <table>
          <tr>
            <th class="info" style="border: 0px;text-align:right;width: 100% ">
                @if(isset($eco_com_applicant))
                    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(90)->generate(
                    $title.'                                     '.
                    'Registro: Nº '.$eco_com_applicant->code.' || '.
                    $eco_com_applicant->getTitleNameFull().' || '.
                    'Carnet de Identidad: '.$eco_com_applicant->identity_card.' '.($eco_com_applicant->city_identity_card->first_shortened ?? '').' || '.
                    'Edad del Afiliado: '.$eco_com_applicant->getHowOld().' || '.
                    'Numero de CUA/NUA: '.$eco_com_applicant->nua
                    )) !!} ">
                    @else
                        @if(isset($affiliate))
                            <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(90)->generate(
                            $title.'                                     '.
                            $affiliate->getTitleNameFull().' || '.
                            'Carnet de Identidad: '.$affiliate->identity_card.' '.($affiliate->city_identity_card->first_shortened ?? '').' || '.
                            'Edad del Afiliado: '.$affiliate->getHowOld().' || '.
                            'Numero de CUA/NUA: '.$affiliate->nua
                            )) !!} ">
                        @endif
                @endif
                @if(isset($double_perception_eco_complements))
                    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(90)->generate(
                    $title.'                                     '
                    )) !!} ">
                @endif
                @if(isset($representative_eco_complements))
                    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(90)->generate(
                    $title.'                                     '
                    )) !!} ">
                @endif
                @if(isset($beneficiary_eco_complements))
                    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(90)->generate(
                    $title.'                                     '
                    )) !!} ">
                @endif
            </th>
          </tr>
        </table>
      </div>
  </footer>
</body>
</html>
