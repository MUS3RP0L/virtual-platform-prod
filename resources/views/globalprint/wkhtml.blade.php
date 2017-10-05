<!DOCTYPE html>
<html lang="es">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>PLATAFORMA VIRTUAL - MUSERPOL</title>
  <link rel="stylesheet" href="{{ asset('css/wkhtml.css') }}">
</head>
<body>
  <header class="clearfix">
    <table class="tableh">
      <tr>
        <th style="width: 25%;border: 0px;">
          <div id="logo">
            <img src="{{ asset('img/logo.jpg') }}" >
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
            <img src="{{ asset('img/escudo.jpg') }}" >
          </div>
        </th>
      </tr>
    </table>
    <table >
      <tr>
        <td class="izq no-border">
          <strong>Fecha de Emisi&#243n: </strong> La Paz, {!! $date !!} - {!! $hour !!}    
        </td>
        <td class="der no-border">
          @if(isset($user))
            <strong>Usuario: </strong>{!! $user->first_name !!} {!! $user->last_name !!} - {!! $user_role !!}
          @endif
        </td>
      </tr>
    </table>
    <h2 class="title">
      {{ $title }}
      @yield('title2')
    </h2>
    @yield('content')
  </header>

  {{-- <div class="qr-code"> --}}
    {{-- <span>PLATAFORMA VIRTUAL DE LA MUTUAL DE SERVICIOS AL POLIC&#205A - 2017</span> --}}
      {{-- <div align="right"> --}}
                @if(isset($eco_com_applicant))
                    <img  class="qr-code" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(80)->margin(0)->generate(
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
                {{-- </div> --}}
      {{-- </div> --}}
</body>
</html>
