@extends('globalprint.print')
@section('title2')

@endsection
@section('content')
	<div class="title2"><b>{!! $economic_complement->getCode() !!} </div>
	<div id="project">
	  <table>
		  	<tr>
		  		<th colspan="2" class="grand service"><b>DATOS DEL TRÁMITE<b></th>
		  	</tr>
		  	<tr>
		  		<th class="grand service"><h4><b>TIPO DE RENTA</h4></b></th>
		  		<td ><h3> {!! $economic_complement->economic_complement_modality->economic_complement_type->name !!}</h3></td>
		  	</tr>
		  	<tr>
		  		<th class="grand service"><h4><b>CIUDAD</h4></b></th>
		  		<td ><h3> {!! $economic_complement->city->name !!} </h3></td>
		  	</tr>
		  	<tr>
		  		<th class="grand service"><h4><b>SEMESTRE</h4></b></th>
		  		<td><h3> {!! $economic_complement->semester !!}</h3></td>
		  	</tr>
		  	<tr>
		  		<th class="grand service"><h4><b>GESTION</b></h4></th>
		  		<td><h3>{!! $yearcomplement->year !!}</h3></td>
		  	</tr>
		  	<tr>
		  		<th class="grand service"><h4><b>FECHA DE RECEPCION</h4></b></th>
		  		<td ><h3> {!! $economic_complement->reception_date !!}</h3></td>
		  	</tr>
		  	<tr>
		  		<th colspan="2" class="grand service"><b>DATOS DEL BENEFICIARIO<b></th>
		  	</tr>
		  	<tr>
		  		<th class="grand service"><h4><b>NOMBRE Y APELLIDOS</h4></b></th>
		  		<td><h3> {!! $eco_com_applicant->getTitleNameFull() !!}</h3></td>
		  	</tr>
		  	<tr>
		  		<th class="grand service"><h4><b>CARNET DE IDENTIDAD</b></h4></th>
		  		<td><h3>{!! $eco_com_applicant->identity_card !!} {!! $eco_com_applicant->city_identity_card->first_shortened !!}</h3></td>
		  	</tr>
		  	<tr>
		  		<th class="grand service"><h4><b>FECHA DE NACIMIENTO</h4></b></th>
		  		<td ><h3>{!! $eco_com_applicant->getShortBirthDate() !!}</h3></td>
		  	</tr>
	  </table>
      <table align="center">
      		<tr>
      		  <th colspan="3" class="grand service"><b>DOCUMENTOS RECEPCIONADOS<b></th>
      		</tr>
            <tr>
              <th class="grand">N°</th>
              <th class="grand">Requisitos de {!! $economic_complement->economic_complement_modality->economic_complement_type->name !!}</th>
              <th class="grand">ESTADO</th>
            </tr>
            @foreach($eco_com_submitted_document as $i=>$item)
            <tr>
                <td style='text-align:center;'> <h3>{!! $i+1 !!}</h3></td>
                <td style='text-align:center;'> <h3>{!! $item->economic_complement_requirement->shortened !!} </h3></td>
                @if ($item->status == 1)
                    <td class="info" style='text-align:center;'>
                    	<img class="circle" src="img/check.png" style="width:70%" alt="icon">
                    </td>
                @else
                	<td class="info" style='text-align:center;'>
                		<img class="circle" src="img/uncheck.png" style="width:60%" alt="icon">
                	
                	</td>
                @endif
            </tr>
            @endforeach
	  </table>
	  <table>
	            <tr>
	                <th class="info" style="border: 0px;text-align:center;"><p>&nbsp;</p><br>-------------------------------------------</th>
	            </tr>
	            <tr>
	              <th class="info" style="border: 0px;text-align:center;"><b>{!! $eco_com_applicant->getTitleNameFull() !!}<br />C.I. {!! $eco_com_applicant->identity_card !!} {!! $eco_com_applicant->city_identity_card->first_shortened !!} <br /> Telefono. {!! $eco_com_applicant->getPhone() !!}</b></th>        
	            </tr>
	  </table>
	</div>
	<br>
@endsection
