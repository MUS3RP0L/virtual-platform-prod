@extends('globalprint.print')
@section('title2')

@endsection
@section('content')
<style type="text/css">
    
    .number{
      text-align: right;
    }
  </style>
    <div id="project">
    <div class="title2"><b>{!! $economic_complement->getCode() !!} </div>
        <table>
      <tr>
        <td colspan="4" class="grand service"><strong>DERECHOHABIENTE</strong></td>
      </tr>
      <tr>
        <td>TIPO DE RENTA:</td><td>{{$economic_complement->economic_complement_modality->shortened}}</td><td>REGIONAL:</td><td>{!! $economic_complement->city->name !!} </td>
      </tr>
      <tr>
        <td>BENEFICIARIO:</td><td colspan="3">{{$eco_com_applicant->last_name}} {{$eco_com_applicant->mothers_last_name}} {{$eco_com_applicant->first_name}}</td>
      </tr>
      <tr>
        <td>CI:</td><td>{!! $eco_com_applicant->identity_card !!} {!! $eco_com_applicant->city_identity_card->first_shortened !!}</td><td>MATRÍCULA:</td><td>{{$affiliate->registration}}</td>
      </tr>
      <tr>
        <td>FECHA RECEPCIÓN:</td><td colspan="3">{!!$reception_date!!}</td>
      </tr>
      <tr>
        <td colspan="4"></td>
      </tr>
       @if($modality  != 1)
      <tr>
        <td colspan="4" class="grand service"><strong>CAUSAHABIENTE - DATOS TITULAR</strong></td>
      </tr>
      <tr>
        <td>DATOS TITULAR:</td><td colspan="3">{{$affiliate->last_name}} {{$affiliate->mothers_last_name}} {{$affiliate->first_name}}</td>
      </tr>
      <tr>
        <td>CI:</td><td>{!! $eco_com_applicant->identity_card !!} {!! $eco_com_applicant->city_identity_card->first_shortened !!}</td><td>MATRÍCULA:</td><td></td>
      </tr>
      <tr>
        <td>GRADO:</td><td>{!! $economic_complement->degree->shortened ?? '' !!}</td><td>CATEGORÍA:</td><td>{!! $economic_complement->category->getPercentage() !!}</td>
      </tr>
      <tr>
        <td>AÑOS DE SERVICIO:</td><td colspan="3"></td>status_documents
      </tr>
      @endif  
</table>
<table>
  <tr>
    <td colspan="3" class="grand service" ><strong>CÁLCULO DEL TOTAL PAGADO</strong></td>
  </tr>
  <tr>
    <td class="grand service" rowspan="2"><b>DETALLE</b></td>
    <td class="grand service" colspan="2"><b style="text-align: center">FRACCIÓN CALCULADO</b></td>
  </tr>
  <tr>
    <td class="grand service"><b>A FAVOR</b></td><td class="grand service"><b>DESCUENTO</b></td>
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
    <td class="grand service"><b>TOTAL</b></td><td class="number"><b>{{$eco_tot_frac}}</b></td><td></td>
  </tr>
  <tr>
    <td colspan="3"></td>
  </tr>
  <tr>
    <td class="grand service" rowspan="2"><b>CONCEPTO</b></td>
    <td class="grand service" colspan="2"><b style="text-align: center">MONTO CALCULADO</b></td>
  </tr>
  <tr>
    <td class="grand service"><b>A FAVOR</b></td><td class="grand service"><b>DESCUENTO</b></td>
  </tr>
  <tr>
    <td>RENTA BOLETA</td><td class="number">{{$sub_total_rent}}</td><td></td>
  </tr>
  <tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;REINTEGRO</td><td></td><td class="number">{{$reimbursement}}</td>
  </tr>
  <tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RENTA DIGNIDAD</td><td></td><td class="number">{{$dignity_pension}}</td>
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
    <td class="grand service">TOTAL SEMESTRE(DIF * 6 Meses)</td><td class="number">{{$total_amount_semester}}</td><td></td>
  </tr>
  <tr>
    <td>FACTOR COMPLEMENTO</td><td class="number">{{$factor_complement}} %</td><td></td>
  </tr>
  <tr>
    <td colspan="3"></td>
  </tr>
  <tr>
    <td class="grand service"><b>TOTAL COMP. EC. (TS * FC)</b></td><td class="number"><b>{{$eco_com_prev}}</b></td><td></td>
  </tr>
  <tr>
    <td colspan="3"></td>
  </tr>
  <tr>
    <td &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CUENTAS POR COBRAR</td><td></td><td></td>
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
    <td class="grand service"><b>TOTAL PAGADO COMP. ECO.</b></td><td class="number"><b>{{$total}}</b></td><td></td>
  </tr>
</table>
<br><br>
<table>
          <tr>
            <th class="info" style="border: 0px;text-align:center;"><p>&nbsp;</p><br>-------------------------------------------</th>
          </tr>
          <tr>
            <th class="info" style="border: 0px;text-align:center;"><b>ELABORADO POR:<br/>{!! $user_1->first_name !!} {!! $user_1->last_name !!} <br> {!! $user_1->getAllRolesToString() !!}</b></th>        
          </tr>
</table>

    </div>


@endsection