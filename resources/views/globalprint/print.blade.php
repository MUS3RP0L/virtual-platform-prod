<!DOCTYPE html>
<html lang="es">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>PLATAFORMA VIRTUAL - MUSERPOL</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" media="all" />
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
          <div class="title"><b>Fecha Emisión: </b>{{ $user->city->name ?? 'La Paz'}}, {!! $date !!} - {!! $hour !!}<br></div>
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
    <table class="no-border">
      <td>
        PLATAFORMA VIRTUAL DE LA MUTUAL DE SERVICIOS AL POLICÍA - 2018
      </td>
      <td class="no-border text-right">
        {{-- @if($title != 'NOTIFICACIÓN')
        <img width="90px" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->generate(
                      $title.' || '.
                      'Trámite Nº: '.($economic_complement->code).' || '.
                      $eco_com_applicant->getFullName().' || '.
                      'Carnet de Identidad: '.$eco_com_applicant->identity_card.' '.($eco_com_applicant->city_identity_card->first_shortened ?? '').' || '.
                      'Regional: '.($economic_complement->city->name ?? '') .' || '.
                      'Fecha: '.($date ?? '') .' || '.
                      $user->id
                      )) !!} ">
        @else
        <img width="90px" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->generate(
                      $title.' || '.
                      $eco_com_applicant->getFullName().' || '.
                      'Carnet de Identidad: '.$eco_com_applicant->identity_card.' '.($eco_com_applicant->city_identity_card->first_shortened ?? '').' || '.
                      'Fecha: '.($date ?? '') .' || '.
                      $user->id
                      )) !!} ">
        @endif --}}
      </td>
    </table> 
  </footer>
</body>
</html>
