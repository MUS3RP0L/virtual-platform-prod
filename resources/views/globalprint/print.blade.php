<!DOCTYPE html>
<html lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>PLATAFORMA VIRTUAL - MUSERPOL</title>
    <link rel="stylesheet" href="css/style.css" media="all" />
  </head>
  <body>
      <header class="clearfix">
        <table class="table">
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
      PLATAFORMA VIRUTAL - MUTUAL DE SERVICIOS AL POLICIA
    </footer>
  </body>
</html>
