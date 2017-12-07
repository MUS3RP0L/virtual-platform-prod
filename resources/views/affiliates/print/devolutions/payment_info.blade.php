<table class="table" style="width:100%;">
	<tr>
		<td colspan="6" class="grand info_title">
			REGISTRO DE PAGO
		</td>
	</tr>
	
	<tr >
		<td><strong>Nro.</strong></td><td><strong>Constancia de Deposito</strong></td><td><strong>Monto (Bs)</strong></td><td><strong>Fecha de Pago</strong></td>
	</tr>
	<tr>
		<td></td>
		<td>{!! $devolution->deposit_number !!}</td>
		<td class="text-right">
		@if($devolution->payment_amount)
			{!! Util::formatMoney($devolution->payment_amount) !!}
		@else
			{!! Util::formatMoney($devolution->total) !!}
		@endif
		</td>
		<td>{!! Util::getDateShort($devolution->payment_date) !!}</td>
	</tr>
</table>
