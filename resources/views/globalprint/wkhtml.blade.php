<!DOCTYPE html>
<html lang="es">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>PLATAFORMA VIRTUAL - MUSERPOL</title>
  <link rel="stylesheet" href="{{ asset('css/wkhtml.css') }}">
</head>
<body>
  
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
        <td class="izq no-border size-10">
          <strong>Fecha de Emisi&#243n: </strong> {!! $date !!} - {!! $hour !!}    
        </td>
        <td class="der no-border size-10">
          @if(isset($user))
            <strong>Usuario: </strong>{!! $user->username !!} - {!! $user_role !!}
          @endif
        </td>
      </tr>
    </table>
    @if(isset($title))
    <h2 class="title">
      {{ $title ?? ''}}
      @yield('title2')
    </h2>
    @endif
    @yield('content')

  {{-- <div class="qr-code"> --}}
    {{-- <span>PLATAFORMA VIRTUAL DE LA MUTUAL DE SERVICIOS AL POLIC&#205A - 2017</span> --}}
      {{-- <div align="right"> --}}
              
          
                
                {{-- </div> --}}
      {{-- </div> --}}
</body>
</html>
