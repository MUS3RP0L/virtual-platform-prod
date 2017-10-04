@extends('globalprint.print')
@section('subtitle')
@if($economic_complement->old_eco_com)
  {{-- <center><b>(RECALIFICACION)</b></center> --}}
	@endif
@endsection
@section('content')
<style type="text/css">
    .number{
      text-align: right;
    }
    .info_title{
      font-size: 17px;
    }
    strong{
      font-weight: 600;
      opacity: .85;
    }
    .title3{
      font-size: 1.1em;
      text-align: right;
      margin-right: 15px;
      text-decoration: underline;
    }
</style>
   <div id="project">
    <div class="title3">
          <strong>
            Tramite N°: {!! $economic_complement->code !!}
          </strong>  
    </div>
    <br>
  		  {{--Información beneficiario--}}
  @if($economic_complement->economic_complement_modality->economic_complement_type->id > 1)
  <table class="table" style="width:100%;">
  	<tr>
  		<td colspan="6" class="grand info_title">
  			INFORMACIÓN DEL AFILIADO 
  			@if($economic_complement->economic_complement_modality->economic_complement_type->id > 1)
  			- CAUSAHABIENTE
  			@endif
  		</td>
  	</tr>
  	<tr>
  		<td colspan="1"><strong>NOMBRE:</strong></td><td colspan="5" nowrap>{!! $affiliate->getFullNamePrintTotal() !!}</td>
  	</tr>
  	<tr>
  		<td><strong>C.I.:</strong></td><td nowrap>  {!! $affiliate->identity_card !!} {!! $affiliate->city_identity_card->first_shortened ?? '' !!}</td><td><strong>FECHA NAC:</strong></td><td> {!! $affiliate->getShortBirthDate() !!}</td><td><strong>EDAD:</strong></td><td>{!! $affiliate->getHowOld() !!}</td>
  	</tr>
  </table>
  @endif
  {{--Información derechohabiente--}}
  <table class="table" style="width:100%;">
  	<tr>
  		<td colspan="6" class="grand info_title">
  			INFORMACIÓN DEL BENECIFIARIO
  			@if($eco_com_applicant->economic_complement->economic_complement_modality->economic_complement_type->id > 1)
  			- DERECHOHABIENTE
  			@endif
  		</td>
  	</tr>
  	<tr >
  		<td colspan="1"><strong>NOMBRE:</strong></td><td colspan="5" nowrap>{!! $eco_com_applicant->getFullName() !!}</td>
  	</tr>
  	<tr>
  		<td><strong>C.I.:</strong></td><td nowrap>{!! $eco_com_applicant->identity_card !!} {{$eco_com_applicant->city_identity_card->first_shortened ?? ''}}</td>
      <td><strong>FECHA NAC:</strong></td><td> {!! $eco_com_applicant->getShortBirthDate() !!}</td>
      <td><strong>EDAD:</strong></td><td>{!! $eco_com_applicant->getHowOld() !!}</td>
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
      <td>Lugar de Nac.</td>
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
    <td colspan="4" class="grand info_title">INFORMACIÓN DEL TRÁMITE</td>
  </tr>
  <tr>
    <td><strong>TIPO DE PRESTACIÓN: </strong></td><td>{{ $economic_complement->economic_complement_modality->economic_complement_type->name ?? '' }}</td>
    <td><strong>MODALIDAD: </strong></td><td>{{ $economic_complement->economic_complement_modality->shortened ?? '' }}</td>
  </tr>
  <tr>
    <td><strong>GRADO:</strong></td><td>{!! $economic_complement->degree->shortened ?? '' !!}</td>
    <td><strong>GESTIÓN:</strong></td><td> {!! $economic_complement->getYear() !!}</td>
  </tr>
  <tr>
  	<td><strong>CATEGORÍA:</strong></td><td>{!! $economic_complement->category->getPercentage() !!}</td>
    <td><strong>SEMESTRE:</strong></td><td>{!! $economic_complement->semester !!}</td>
  </tr>
  <tr>
    <td><strong>REGIONAL:</strong></td>  	
    <td>{!! $economic_complement->city->name !!}</td>  	
    <td><strong>ENTE GESTOR:</strong></td>
    <td>{!! $affiliate->pension_entity->name ?? '' !!}</td>
  </tr>
  <tr>
    <td><strong>TIPO DE TRÁMITE: </strong></td>  	
    <td>{!! $economic_complement->reception_type !!}</td>  	
    <td><strong>FECHA DE RECEPCIÓN:</strong></td>
    <td>{!! $economic_complement->getReceptionDate() !!}</td>
  </tr>
</table>
<table>
  <tr>
    <td colspan="3" class="grand info_title" ><strong>CÁLCULO DE TOTAL</strong></td>
  </tr>
  <tr>
    <td colspan="3"></td>
  </tr>
  <tr>
    <td class="grand service" rowspan="2"><b>DETALLE</b></td>
    <td class="grand service" colspan="2"><b style="text-align: center">MONTO CALCULADO</b></td>
  </tr>
  <tr>
    <td class="grand service"><b>A FAVOR</b></td><td class="grand service"><b>DESCUENTO</b></td>
  </tr>
  <tr>
    <td><b>BOLETA TOTAL</b></td><td class="number"><b>{{$total_rent}}</b></td><td></td>
  </tr>
  <tr>
    <td>RENTA O PENSIÓN PASIVO NETO</td><td class="number">{{$total_rent_calc}}</td><td></td>
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
  <td class="grand service"><b>TOTAL COMPLEMENTO ECONÓMICO EN BS.</b></td><td class="number"><b>{{$total}}</b></td><td></td>
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
    <td colspan="3"><strong>Son: </strong> {{ Util::convertir($economic_complement->total_repay) }}</td>
  </tr>
  @else
    <tr>
      <td colspan="3"><strong>Son: </strong> {{ $total_literal }}</td>
    </tr>
  @endif
</table>
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
      <td class="padding-top">Elaborado por</td>
      <td class="padding-top">Revisado por</td>
      <td class="padding-top">Aprobado por</td>
    </tr>
  </table>
	{{-- <table>
	  <tr>
	    <th class="info" style="border: 0px;text-align:center;"><p>&nbsp;</p><br>____________________________________________</th>
	  </tr>
	  <tr>
	    <th class="info" style="border: 0px;text-align:center;"><b>Elaborado por {!! $user->getFullName() !!} <br> {{ $user->position }}</b></th>        
	  </tr>
	</table> --}}

</div>
@endsection