@extends('globalprint.print')
@section('title2')

@endsection
@section('content')

	  <table>
		  	<tr>
		  		<th colspan="2" class="grand service"><b>DATOS DEL TITULAR<b></th>
		  	</tr>
		  	<tr>
		  		<th class="grand service"><h5><b>NOMBRE Y APELLIDOS</h5></b></th>
		  		<td><h4> {!! $eco_com_applicant->getTitleNameFull() !!}</h4></td>
		  	</tr>
		  	<tr>
		  		<th class="grand service"><h5><b>CARNET DE IDENTIDAD</b></h5></th>
		  		<td><h4>{!! $eco_com_applicant->identity_card !!} {!! $eco_com_applicant->city_identity_card->first_shortened !!}</h4></td>
		  	</tr>

		  	<tr>
		  		<th class="grand service"><h5><b>FECHA DE NACIMIENTO</h5></b></th>
		  		<td ><h4>{!! $eco_com_applicant->getShortBirthDate() !!}</h4></td>
		  	</tr>
		  	<tr>
		  		<th class="grand service"><h5><b>TIPO DE RENTA</h5></b></th>
		  		<td ><h4> {!! $economic_complement->economic_complement_modality->economic_complement_type->name !!}</h4></td>
		  	</tr>
		  	<tr>
		  		<th class="grand service"><h5><b>Nº. CUA/NUA</h5></b></th>
		  		<td ><h4>{!! $eco_com_applicant->nua !!}</h4></td>
		  	</tr>
	  </table>
	  <br><br>
      <table align="center">
      		<tr>
      		  <th colspan="3" class="grand service"><b>DOCUMENTOS RECEPCIONADOS<b></th>
      		</tr>
            <tr>
              <th class="grand">N°</th>
              <th class="grand">REQUISITOS</th>
              <th class="grand">ESTADO</th>
            </tr>
            @foreach($eco_com_submitted_document as $i=>$item)
            <tr>
                <td style='text-align:center;'>{!! $i+1 !!}</td>
                <td style='text-align:center;'>{!! $item->economic_complement_requirement->shortened !!}</td>
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
	  
	  <br><br><br><br><br><br>
	  <table>
	            <tr>
	                <th class="info" style="border: 0px;text-align:center;"><p>&nbsp;</p><br>-------------------------------------------</th>
	                <th class="info" style="border: 0px;text-align:center;"><p>&nbsp;</p><br>-------------------------------------------</th>
	            </tr>
	            <tr>
	              <th class="info" style="border: 0px;text-align:center;"><b>{!! $eco_com_applicant->getTitleNameFull() !!}<br />C.I. {!! $eco_com_applicant->identity_card !!} {!! $eco_com_applicant->city_identity_card->first_shortened !!} <br /> Telefono. {!! $eco_com_applicant->getPhone() !!}</b></th>
	              <th class="info" style="border: 0px;text-align:center;"><b>{!! $user->first_name !!} {!! $user->last_name !!}<br>Teléfono: {!! $user->phone !!} <br>{!! $user->getAllRolesToString() !!}</b></th>          
	            </tr>
	  </table>
@endsection
