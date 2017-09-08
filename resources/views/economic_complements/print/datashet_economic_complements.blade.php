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
<style type="text/css">
    
    .number{
      text-align: right;
    }
  </style>
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
           <br>
          </b>
            <b>FICHA PAGO COMPLEMENTO ECONÓMICO</b>
            <br>
            <b>SEMESTRE I - 2017</b> 
          </h4>
          <br>
          <h3>(Expresado en Bs.)</h3>
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
          <div class="title"><b>Fecha Emisión: </b> La Paz, <br> </div>
      </tr>
    </table>
    <br>
    <h1>
      <center><b></b></center>
     
    </h1>
    <br>
   
  </header>

<table>
      <tr>
        <td colspan="4"><strong>DERECHOHABIENTE</strong></td>
      </tr>
      <tr>
        <td>TIPO DE RENTA:</td><td>{{$economic_complement->economic_complement_modality->shortened}}</td><td>REGIONAL:</td><td></td>
      </tr>
      <tr>
        <td>BENEFICIARIO:</td><td colspan="3">{{$eco_com_applicant->last_name}} {{$eco_com_applicant->mothers_last_name}} {{$eco_com_applicant->first_name}}</td>
      </tr>
      <tr>
        <td>CI:</td><td></td><td>MATRÍCULA:</td><td></td>
      </tr>
      <tr>
        <td>FECHA:</td><td colspan="3"></td>
      </tr>
      <tr>
        <td colspan="4"></td>
      </tr>
      <tr>
        <td colspan="4"><strong>CAUSAHABIENTE - DATOS TITULAR</strong></td>
      </tr>
      <tr>
        <td>DATOS TITULAR:</td><td colspan="3">{{$affiliate->last_name}} {{$affiliate->mothers_last_name}} {{$affiliate->first_name}}</td>
      </tr>
      <tr>
        <td>CI:</td><td>{{$affiliate->identity_card}}</td><td>MATRÍCULA:</td><td></td>
      </tr>
      <tr>
        <td>CARGO:</td><td></td><td>CATEGORÍA:</td><td></td>
      </tr>
      <tr>
        <td>AÑOS DE SERVICIO:</td><td colspan="3"></td>
      </tr>

</table>
<table>
  <tr>
    <td colspan="3"><strong>CÁLCULO DEL TOTAL PAGADO</strong></td>
  </tr>
  <tr>
    <td><b>DETALLE</b></td><td><b>FRACCIÓN A FAVOR</b></td><td><b>DESCUENTO</b></td>
  </tr>
  <tr>
    <td>FRACCIÓN DE SALDO ACUMULADO</td><td class="number">{{$economic_complement->aps_total_fsa}}</td><td></td>
  </tr>
  <tr>
    <td>FRACCIÓN COMPLEMENTARIA</td><td class="number">{{$economic_complement->aps_total_cc}}</td><td></td>
  </tr>
  <tr>
    <td>FRACCIÓN SOLIDARIA</td><td class="number">{{$economic_complement->aps_total_fs}}</td><td></td>
  </tr>
  <tr>
    <td><b>TOTAL</b></td><td class="number"><b>{{$eco_tot_frac}}</b></td><td></td>
  </tr>
  <tr>
    <td colspan="3"></td>
  </tr>
  <tr>
    <td><b>CONCEPTO</b></td><td><b>MONTO A FAVOR</b></td><td><b>DESCUENTO</b></td>
  </tr>
  <tr>
    <td>RENTA BOLETA</td><td class="number">{{$sub_total_rent}}</td><td></td>
  </tr>
  <tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;REINTEGRO</td><td></td><td>{{$reimbursement}}</td>
  </tr>
  <tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RENTA DIGNIDAD</td><td></td><td>{{$dignity_pension}}</td>
  </tr>
  <tr>
    <td><b>RENTA TOTAL NETA</b></td><td class="number"><b>{{$total_rent_calc}}</b></td><td></td>
  </tr>
  <tr>
    <td>REFERENTE SALARIAL</td><td class="number">{{$salary_reference}}</td><td></td>
  </tr>
  <tr>
    <td>ANTIGÜEDAD</td><td class="number">{{$seniority}}</td><td></td>
  </tr>
  <tr>
    <td>SALARIO COTIZABLE</td><td class="number">{{$salary_quotable}}</td><td></td>
  </tr>
  <tr>
    <td colspan="3"></td>
  </tr>
  <tr>
    <td>DIFERENCIA</td><td class="number">{{$difference}}</td><td></td>
  </tr>
  <tr>
    <td>TOTAL SEMESTRE(DIF * 6 Meses)</td><td class="number">{{$total_amount_semester}}</td><td></td>
  </tr>
  <tr>
    <td>FACTOR COMPLEMENTO</td><td class="number">{{$factor_complement}} %</td><td></td>
  </tr>
  <tr>
    <td colspan="3"></td>
  </tr>
  <tr>
    <td><b>TOTAL COMP. EC. (TS * FC)</b></td><td class="number"><b>{{$eco_com_prev}}</b></td><td></td>
  </tr>
  <tr>
    <td colspan="3"></td>
  </tr>
  <tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CUENTAS POR COBRAR</td><td></td><td></td>
  </tr>
  <tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MORA POR PRÉSTAMOS</td><td></td><td class="number" >{{$economic_complement->amount_loan}}</td>
  </tr>
  <tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DISPOSICIÓN DE FONDOS</td><td></td><td></td>
  </tr>
  <tr>
    <td colspan="3"></td>
  </tr>
  <tr>
    <td><b>TOTAL PAGADO COMP. ECO.</b></td><td class="number"><b>{{$economic_complement->total}}</b></td><td></td>
  </tr>
</table>
 <footer>
    PLATAFORMA VIRTUAL DE LA MUTUAL DE SERVICIOS AL POLICÍA - 2017

      <div class="visible-print text-right">
        <table>
          <tr>
            <th class="info" style="border: 0px;text-align:right;width: 100% ">
                
            </th>
          </tr>
        </table>
      </div>
  </footer>
</body>
</html>




