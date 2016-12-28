<!DOCTYPE html>
<html lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>PLATAFORMA VIRTUAL - MUSERPOL</title>
    <link rel="stylesheet" href="assets/css/style.css" media="all" />
  </head>
  <body>
    <header class="clearfix">
      <table class="tableh">
            <tr>
              <th style="width: 25%;border: 0px;">
                <div id="logo">
                  <img src="assets/images/logo.jpg">
                </div>
              </th>
              <th style="width: 50%;border: 0px">
                <h3><b>MUTUAL DE SERVICIOS AL POLICÍA<br>
                    DIRECCIÓN DE BENEFICIOS ECONÓMICOS<br>
                    UNIDAD DE FONDO DE RETIRO POLICIAL INDIVIDUAL<br>
                    @yield('title')
                    </b></h3>
              </th>
              <th style="width: 25%;border: 0px">
                <div id="logo2">
                  <img src="assets/images/escudo.jpg">
                </div>
              </th>
            </tr>
      </table>
      <table class="tablet">
        <tr>
          <td style="border: 0px;">
            <div class="title"><b>N° de Tramite: {{ $retirement_fund->getNumberTram() }}</b></div>
          </td>
          <td style="border: 0px;text-align:right;">
            <div class="title"><b>Fecha de Emisión: La Paz, {!! $date !!}</b></div>
          </td>
        </tr>
        <tr>
            <td  colspan="2" style="border: 0px;text-align:right;">
             <div class="title">Usuario: {{ Auth::user()->last_name }} {{ Auth::user()->first_name }}</div>
            </td>
        </tr>
      </table>
      <h1>
        <b>
          FONDO DE RETIRO POLICIAL INDIVIDUAL<br>
          MODALIDAD: {!! $retirement_fund->retirement_fund_modality->name !!}<br>
          @yield('title2')
        </b>
      </h1>
      <br>

      @yield('content')

    </header>
    <footer>
      PLATAFORMA VIRUTAL - MUTUAL DE SERVICIOS AL POLICIA
    </footer>
  </body>
</html>
