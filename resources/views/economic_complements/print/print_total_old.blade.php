@extends('globalprint.wkhtml')
@section('subtitle')
@if($economic_complement->old_eco_com)
	{{-- <center><b>(TRÁMITE ANTERIOR)</b></center> --}}
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
  <table class="table" style="width:100%;">
  	<tr>
  		<td colspan="6" class="grand info_title">
  			INFORMACIÓN DEL BENECIFIARIO
  		</td>
  	</tr>
  	<tr>
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
  			{{ explode(',',$eco_com_applicant->phone_number)[0] }}
  		</td>
  		<td><strong>CELULAR:</strong></td>
  		<td>
  			{{ explode(',',$eco_com_applicant->cell_phone_number)[0] }}
  		</td>
      <td><strong>Lugar de Nac.</strong></td>
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
	@if($economic_complement->old_eco_com)
		<table>
		  <tr>
		    <td colspan="6" class="grand info_title">INFORMACIÓN DEL TRÁMITE</td>
		  </tr>
		  <tr>
		    <td><strong>MODALIDAD: </strong></td><td>{{ $old_eco_com_modality }}</td>
		    <td><strong>GRADO:</strong></td><td>{!! $old_eco_com_degree !!}</td>
		  	<td><strong>CATEGORÍA:</strong></td><td>{!! $old_eco_com_category !!}</td>
		  <tr>
		  </tr>
		    <td><strong>REGIONAL:</strong></td><td>{!! $old_eco_com_city !!}</td>  	
		    <td><strong>GESTIÓN:</strong></td><td> {!! $old_eco_com_year!!}</td>
		    <td><strong>SEMESTRE:</strong></td><td>{!! $old_eco_com->semester !!}</td>
		  </tr>
		  <tr>
		    <td><strong>ENTE GESTOR:</strong></td><td>{!! $affiliate->pension_entity->name ?? '' !!}</td>
		    <td><strong>TIPO DE TRÁMITE: </strong></td><td>{!! $old_eco_com->reception_type !!}</td>  	
		    <td><strong>FECHA DE RECEPCIÓN:</strong></td><td>{!! $old_eco_com_reception_date!!}</td>
		  </tr>
		</table>
		<table>
		  <tr>
		    <td colspan="3" class="grand info_title" ><strong>CÁLCULO DE TOTAL PAGADO</strong></td>
		  </tr>
		  <tr>
		    <td class="grand service" rowspan="2"><b>DETALLE</b></td>
		    <td class="grand service" colspan="2"><b style="text-align: center">MONTO CALCULADO</b></td>
		  </tr>
		  <tr>
		    <td class="grand service"><b>A FAVOR</b></td><td class="grand service"><b>DESCUENTO</b></td>
		  </tr>
		  <tr>
		    <td><b>BOLETA TOTAL</b></td><td class="number"><b>{{$old_eco_com->total_rent}}</b></td><td></td>
		  </tr>
		  <tr>
		    <td>RENTA O PENSIÓN PASIVO NETO</td><td class="number">{{Util::formatMoney($old_eco_com->total_rent_calc)}}</td><td></td>
		  </tr>
		  <tr>
		    <td>REFERENTE SALARIO DEL ACTIVO</td><td class="number">{{Util::formatMoney($old_eco_com->salary_reference)}}</td><td></td>
		  </tr>
		  <tr>
		    <td>ANTIGÜEDAD (SEGÚN CATEGORÍA)</td><td class="number">{{Util::formatMoney($old_eco_com->seniority)}}</td><td></td>
		  </tr>
		  <tr>
		    <td>SALARIO COTIZABLE (SALARIO DEL ACTIVO + ANTIGÜEDAD)</td><td class="number">{{Util::formatMoney($old_eco_com->salary_quotable)}}</td><td></td>
		  </tr>
		  <tr>
		    <td>DIFERENCIA (SALARIO ACTIVO Y RENTA PASIVO)</td><td class="number">{{Util::formatMoney($old_eco_com->difference)}}</td><td></td>
		  </tr>
		  <tr>
		    <td>TOTAL SEMESTRE (DIFERENCIA SE MULTIPLICA POR 6 MESES)</td><td class="number">{{$total_amount_semester}}</td><td></td>
		  </tr>
		  <tr>
		    <td>FACTOR DE COMPLEMENTACIÓN</td><td class="number">{{ Util::formatMoney($old_eco_com->complementary_factor) }} %</td><td></td>
		  </tr>
		  @if($old_eco_com->amount_loan)
		  <tr>
		    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MORA POR PRÉSTAMOS</td><td></td><td class="number" >{{Util::formatMoney($old_eco_com->amount_loan)}}</td>
		  </tr>
		  @endif
		  @if($old_eco_com->amount_accounting)
		  <tr>
		    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MONTO POR CONTABILIDAD</td><td></td><td class="number" >{{Util::formatMoney($old_eco_com->amount_accounting)}}</td>
		  </tr>
		  @endif
		  @if($old_eco_com->amount_replacement)
		  <tr>
		    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MONTO POR REPOSICION DE FONDOS</td><td></td><td class="number" >{{Util::formatMoney($old_eco_com->amount_replacement)}}</td>
		  </tr>
		  @endif
		  <tr>
		  <td class="grand service"><b>TOTAL COMPLEMENTO ECONÓMICO EN BS.</b></td><td class="number"><b>{{ Util::formatMoney($old_eco_com->total)}}</b></td><td></td>
		  </tr>
		  <tr>
		  	<td colspan="3"><strong>Son: </strong>{!! $total_literal !!} Bolivianos</td>
		  </tr>
		</table>
	@endif
	<table>
	<tr>
	<td colspan="3" class="grand service">NOTA</td>
	</tr>
	<tr>
	<td colspan="3"><b> </b>{!!$economic_complement->comment!!}</td>
	</tr>
	</table>
	<br>
	<table>
		<tr>
			<td class="padding-top">Elaborado y Revisado por:</td>
			<td class="padding-top">Aprobado por:</td>
			<td class="padding-top">Aprobado por:</td>
		</tr>
	</table>
	{{-- <table>
	  <tr>
	    <th class="info" style="border: 0px;text-align:center;"><p>&nbsp;</p><br>____________________________________________</th>
	  </tr>
	  <tr>
	    <th class="info" style="border: 0px;text-align:center;"><b>Elaborado por {!! $user->getFullName() !!} <br> {!! $user->position !!} </b></th>        
	  </tr>
	</table> --}}

</div>
@endsection