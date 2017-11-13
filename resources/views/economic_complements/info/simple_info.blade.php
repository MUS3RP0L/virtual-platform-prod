<table class="table" style="width:100%;">
	<tr>
		<td colspan="6" class="grand info_title">INFORMACIÓN DEL TRÁMITE</td>
	</tr>
	<tr>
		<td><strong>TIPO DE PRESTACIÓN:</strong></td><td>{{ $economic_complement->economic_complement_modality->shortened ?? '' }}</td>
		<td><strong>GRADO:</strong></td><td>{!! $economic_complement->degree->shortened ?? '' !!}</td>
		<td><strong>CATEGORÍA:</strong></td><td>{!! $economic_complement->category->getPercentage() !!}</td>
	</tr>
	<tr>
		<td><strong>REGIONAL:</strong></td><td>{!! $economic_complement->city->name !!}</td>    
		{{-- <td><strong>GESTIÓN:</strong></td><td> {!! $economic_complement->getYear() !!}</td>
		<td><strong>SEMESTRE:</strong></td><td>{!! $economic_complement->getSemester()!!}/{!! $economic_complement->getYear() !!}</td> --}}
	{{-- </tr>
	<tr> --}}
		<td><strong>ENTE GESTOR:</strong></td><td>{!! $affiliate->pension_entity->name ?? '' !!}</td>
		<td><strong>TIPO DE TRÁMITE: </strong></td><td>{!! strtoupper($economic_complement->reception_type) !!}</td>    
		{{-- <td><strong>FECHA DE RECEPCIÓN:</strong></td><td>{!! $economic_complement->getReceptionDate() !!}</td> --}}
	</tr>
</table>