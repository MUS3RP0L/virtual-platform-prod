<table class="table" style="width:100%;">
	<tr>
		<td colspan="6" class="grand info_title">
			REGISTRO DE PAGO
		</td>
	</tr>
	
	<tr >
		<td class="text-center"><strong>NRO.</strong></td><td class="text-center"><strong>CONSTANCIA DE DEPOSITO</strong></td><td class="text-center"><strong>MONTO</strong></td><td class="text-center"><strong>FECHA DE PAGO</strong></td>
	</tr>
	<tr>
		<td></td>
		<td class="text-center">{!! $devolution->deposit_number !!}</td>
		<td class="text-right">
			Bs.
		@if($devolution->payment_amount)
			{!! Util::formatMoney($devolution->payment_amount) !!}
		@else
			{!! Util::formatMoney($devolution->total) !!}
		@endif
		</td>
		<td class="text-center">{!! Util::getDateShort($devolution->payment_date) !!}</td>
	</tr>
</table>
