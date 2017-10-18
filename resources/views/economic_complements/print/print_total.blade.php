@extends('globalprint.wkhtml')
@section('subtitle')
@if($economic_complement->old_eco_com)
  {{-- <center><strong>(RECALIFICACION)</strong></center> --}}
	@endif
@endsection
@section('content')
<style type="text/css">
    .number{
      text-align: right;
    }
</style>
<div class="title2"><strong class="code">DOC - {!! $doc_number !!} </strong><strong class="code">Trámite Nº: {!! $economic_complement->code !!} </strong></div>
   <div id="project">  
  {{--Información derechohabiente--}}
  <table class="table" style="width:100%;">
  	<tr>
  		<td colspan="6" class="grand info_title">
  			INFORMACIÓN DEL BENECIFIARIO
  		</td>
  	</tr>
  	<tr >
  		<td colspan="1"><strong>NOMBRE:</strong></td><td colspan="5" nowrap>{!! $eco_com_applicant->getFullName() !!}</td>
  	</tr>
  	<tr>
  		<td><strong>C.I.:</strong></td><td nowrap>{!! $eco_com_applicant->identity_card !!} {{$eco_com_applicant->city_identity_card->first_shortened ?? ''}}</td>
      <td><strong>FECHA NAC:</strong></td><td> {!! $eco_com_applicant->getShortBirthDate() !!}</td>
      <td><strong>EDAD:</strong></td><td>{!! $eco_com_applicant->getAge() !!} AÑOS</td>
  	</tr>
  	<tr>
  		<td><strong>TELÉFONO:</strong></td>
  		<td>
        {!! explode(',',$eco_com_applicant->phone_number)[0] !!}<br/>
      </td>
      <td><strong>CELULAR:</strong></td>
      <td>
  			{!! explode(',',$eco_com_applicant->cell_phone_number)[0] !!}<br/>
  		</td>
      <td><strong>LUGAR DE NAC.</strong></td>
      <td>{!! $eco_com_applicant->city_birth->second_shortened ?? '' !!}</td>
  	</tr>
  </table>

  {{--Información apoderado--}}  
@if($economic_complement->has_legal_guardian)
    <table>
      <tr>
        <td colspan="4" class="grand info_title">INFORMACIÓN DEL APODERADO</td>
      </tr>
      <tr>
        <td><strong>NOMBRE:</strong></td><td nowrap>{!! $economic_complement_legal_guardian->getFullName() !!}</td>
        <td><strong>C.I.:</strong></td><td nowrap>{!! $economic_complement_legal_guardian->identity_card !!} {!! $economic_complement_legal_guardian->city_identity_card->first_shortened ?? '' !!}</td>
      </tr>
    </table>
@endif

{{--Información del trámite--}}
<table>
  <tr>
    <td colspan="6" class="grand info_title">INFORMACIÓN DEL TRÁMITE</td>
  </tr>
  <tr>
    <td><strong>MODALIDAD: </strong></td><td>{{ $economic_complement->economic_complement_modality->shortened ?? '' }}</td>
    <td><strong>GRADO:</strong></td><td>{!! $economic_complement->degree->shortened ?? '' !!}</td>
  	<td><strong>CATEGORÍA:</strong></td><td>{!! $economic_complement->category->getPercentage() !!}</td>
  </tr>
  <tr>
    <td><strong>REGIONAL:</strong></td><td>{!! $economic_complement->city->name !!}</td>  	
    <td><strong>GESTIÓN:</strong></td><td> {!! $economic_complement->getYear() !!}</td>
    <td><strong>SEMESTRE:</strong></td><td>{!! $economic_complement->getSemester() !!}</td>
  </tr>
  <tr>
    <td><strong>ENTE GESTOR:</strong></td><td>{!! $affiliate->pension_entity->name ?? '' !!}</td>
    <td><strong>TIPO DE TRÁMITE: </strong></td><td>{!! $economic_complement->reception_type !!}</td>  	
    <td><strong>FECHA DE RECEPCIÓN:</strong></td><td>{!! $economic_complement->getReceptionDate() !!}</td>
  </tr>
</table>
<table>
  <tr>
    <td colspan="3" class="grand info_title" ><strong>CÁLCULO DEL COMPLEMENTO ECONÓMICO</strong></td>
  </tr>
  <tr>
    <td class="grand service info_title" rowspan="2" style="vertical-align: middle;"><strong>DETALLE</strong></td>
    <td class="grand service" colspan="2"><b style="text-align: center">MONTO CALCULADO</strong></td>
  </tr>
  <tr>
    <td class="grand service"><strong>A FAVOR</strong></td><td class="grand service"><strong>DESCUENTO</strong></td>
  </tr>
  <tr>
    <td><strong>BOLETA TOTAL</strong></td><td class="number"><strong>{{$total_rent}}</strong></td><td></td>
  </tr>
  <tr>
    <td>RENTA O PENSIÓN (PASIVO NETO)</td><td class="number">{{$total_rent_calc}}</td><td></td>
  </tr>
  <tr>
    <td>REFERENTE SALARIO DEL ACTIVO</td><td class="number">{{$salary_reference}}</td><td></td>
  </tr>
  <tr>
    <td>ANTIGÜEDAD (SEGÚN CATEGORÍA)</td><td class="number">{{$seniority}}</td><td></td>
  </tr>
  <tr>
    <td>SALARIO COTIZABLE (SALARIO DEL ACTIVO + ANTIGÜEDAD)</td><td class="number">{{$salary_quotable}}</td><td></td>
  </tr>
  <tr>
    <td>DIFERENCIA (SALARIO ACTIVO Y RENTA PASIVO)</td><td class="number">{{$difference}}</td><td></td>
  </tr>
  <tr>
    <td>TOTAL SEMESTRE (DIFERENCIA SE MULTIPLICA POR 6 MESES)</td><td class="number">{{$total_amount_semester}}</td><td></td>
  </tr>
  <tr>
    <td>FACTOR DE COMPLEMENTACIÓN</td><td class="number">{{ $factor_complement }} %</td><td></td>
  </tr>
  <tr>
  <td class="grand service info_title"><strong>TOTAL LIQUIDO A PAGAR EN BS.</strong></td><td class="number"><strong>{{$total}}</strong></td><td></td>
  </tr>
  @if($economic_complement->amount_loan)
  <tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MORA POR PRÉSTAMOS</td><td></td><td class="number" >{{Util::formatMoney($economic_complement->amount_loan)}}</td>
  </tr>
  @endif
  @if($economic_complement->amount_accounting)
  <tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MONTO POR CONTABILIDAD</td><td></td><td class="number" >{{Util::formatMoney($economic_complement->amount_accounting)}}</td>
  </tr>
  @endif
  @if($economic_complement->amount_replacement)
  <tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MONTO POR REPOSICION DE FONDOS</td><td></td><td class="number" >{{Util::formatMoney($economic_complement->amount_replacement)}}</td>
  </tr>
  @endif
  <tr>
  <td class="grand service info_title"><strong>TOTAL COMPLEMENTO ECONÓMICO EN BS.</strong></td><td class="number"><strong>{{$total}}</strong></td><td></td>
  </tr>
  @if($economic_complement->old_eco_com)
  <tr>
    <td>TOTAL COMP. ECO. PAGADO</td>
    <td></td><td class="number">{!! Util::formatMoney($old_eco_com->total) !!}</td>
  </tr>
  <tr>
    <td colspan="3"></td>
  </tr>
  <tr style="font-size: 1.1em">
    <td  class="grand service">TOTAL REEMBOLSO</td>
    <td class="number"><strong>{!! Util::formatMoney($economic_complement->total_repay) !!}</strong></td>
    <td></td>
  </tr>
  <tr>
    <td colspan="3"><strong>Son: </strong> {{ Util::convertir($economic_complement->total_repay) }} Bolivianos</td>
  </tr>
  @else
    <tr>
      <td colspan="3"><strong>Son: </strong> {{ $total_literal }} Bolivianos</td>
    </tr>
  @endif
</table>
	<table>
	<tr>
	<td colspan="3" class="grand service">NOTA</td>
	</tr>  
	<tr>
	<td colspan="3"><strong> </strong>{!!$economic_complement->comment!!}</td>
	</tr>
	</table>
  <br>
  <table>
    <tr>
      <td class="padding-top"><strong>Elaborado y Revisado por:</strong></td>
      <td class="padding-top"><strong>Aprobado por:</strong></td>
      <td class="padding-top"><strong>Aprobado por:</strong></td>
    </tr>
  </table>
</div>
@endsection