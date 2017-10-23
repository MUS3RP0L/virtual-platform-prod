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
  			INFORMACIÓN DEL BENEFICIARIO
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
  

  {{--Información apoderado--}}  
@if($economic_complement->has_legal_guardian)
      <tr><td class="no-border" colspan="6"></td></tr>
      <tr>
        <td colspan="6" class="grand info_title">INFORMACIÓN DEL APODERADO</td>
      </tr>
      <tr>
        <td><strong>NOMBRE:</strong></td><td nowrap colspan="3">{!! $economic_complement_legal_guardian->getFullName() !!}</td>
        <td><strong>C.I.:</strong></td><td nowrap>{!! $economic_complement_legal_guardian->identity_card !!} {!! $economic_complement_legal_guardian->city_identity_card->first_shortened ?? '' !!}</td>
      </tr>
@endif

{{--Información del trámite--}}
  <tr><td class="no-border" colspan="6"></td></tr>
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
    <td><strong>SEMESTRE:</strong></td><td>{!! $economic_complement->getSemester() !!}/{!! $economic_complement->getYear() !!}</td>
  </tr>
  <tr>
    <td><strong>ENTE GESTOR:</strong></td><td>{!! $affiliate->pension_entity->name ?? '' !!}</td>
    <td><strong>TIPO DE TRÁMITE: </strong></td><td>{!! $economic_complement->reception_type !!}</td>  	
    <td><strong>FECHA DE RECEPCIÓN:</strong></td><td>{!! $economic_complement->getReceptionDate() !!}</td>
  </tr>
</table>
<table>
  <tr>
    <td colspan="3" class="grand service info_title" ><strong>COMPLEMENTO ECONÓMICO</strong></td>
  </tr>
  <tr>
    <td class="grand service text-left"><strong>TOTAL LIQUIDO A PAGAR EN BS.</strong></td><td class="number"><strong>{{$total}}</strong></td>
  </tr>
  <tr>
    <td colspan="3"><strong>Son: </strong> {{ $total_literal }} Bolivianos</td>
  </tr>

</table>
<table>
  <tr>
    <td class="padding-top"><strong>Elaborado y Revisado por:</strong></td>
    <td class="padding-top"><strong>Aprobado por:</strong></td>
    <td class="padding-top"><strong>Aprobado por:</strong></td>
  </tr>
</table>
</div>
@endsection