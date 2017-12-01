<table class="table" style="width:100%;">
	<tr>
		<td colspan="6" class="grand info_title">
			MONTOS ADEUDADOS POR SEMESTRE Y GESTIÓN
		</td>
	</tr>
	<tr >
		<td><strong>GESTIÓN</strong></td><td><strong>MONTO ADEUDADO</strong></td>
		@foreach($dues as $index=>$due)
		{{-- @if($index%2 == 0) --}}
			<tr>
		{{-- @endif --}}
			<td>{{ $due->eco_com_procedure->getShortenedName() }}</td><td><strong>Bs. </strong>	{!! Util::formatMoney($due->amount) ?? '0.00' !!}</td>
		{{-- @if($index%2 == 1) --}}
			</tr>
		{{-- @endif --}}
		@endforeach
	</tr>
	<tr>
		<td colspan="1" class="no-border"></td>
	</tr>
	<tr>
		<td class="grand">MONTO TOTAL ADEUDADO A LA MUSERPOL</td>
		<td colspan="1" class="size-15 bold">Bs.{{ Util::formatMoney($devolution->total) ?? '0.00' }}</td>
	</tr>
</table>
