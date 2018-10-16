<table class="table" style="width:100%;">
	<tr>
		<td colspan="6" class="grand info_title">
			MONTOS ADEUDADOS POR SEMESTRE Y GESTIÓN
		</td>
	</tr>
	<tr >
		<td class="text-center" style="width:25%"><strong>GESTIÓN</strong></td><td class="text-center" style="width:25%"><strong>MONTO ADEUDADO</strong></td>
		<td class="text-center" style="width:25%"><strong>GESTIÓN</strong></td><td class="text-center" style="width:25%"><strong>MONTO ADEUDADO</strong></td>
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
</table>

<table class="table" style="width:100%;">
	<tr>
		<td class="grand">MONTO TOTAL ADEUDADO A LA MUSERPOL</td>
		<td class="bold text-rightleft">Bs. {{ Util::formatMoney($total) }} ({!! $total_dues_literal ?? '' !!} BOLIVIANOS)</td>
	</tr>
</table>
