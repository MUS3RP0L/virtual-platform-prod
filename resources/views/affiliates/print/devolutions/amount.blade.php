<table class="table" style="width:100%;">
	<tr>
		<td colspan="6" class="grand info_title">
			MONTOS ADEUDADOS POR SEMESTRE Y GESTIÓN
		</td>
	</tr>
	<tr >
		<td><strong>GESTIÓN</strong></td><td class="text-center"><strong>MONTO ADEUDADO</strong></td>
		<td><strong>GESTIÓN</strong></td><td class="text-center"><strong>MONTO ADEUDADO</strong></td>
		@foreach($dues as $index=>$due)
		@if($index%2 == 0)
			<tr>
		@endif
			<td>{{ $due->eco_com_procedure->getShortenedName() }}</td><td class="text-right"><strong>Bs. </strong>	{!! Util::formatMoney($due->amount) ?? '0.00' !!}</td>
		@if($index%2 == 1)
			</tr>
		@endif
		@endforeach
	</tr>
	<tr>
		<td colspan="4"></td>
	</tr>
	<tr>
		<td class="grand" colspan="2">MONTO TOTAL ADEUDADO A LA MUSERPOL</td>
		<td colspan="2" class="size-13 bold text-right">Bs. {!! $total_dues_literal ?? '' !!}</td>
		{{-- <td colspan="2" class="size-15 bold text-right">Bs.{{ Util::formatMoney($devolution->total) ?? '0.00' }}</td> --}}
	</tr>
</table>
