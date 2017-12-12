<table class="table" style="width:100%;">
	<tr>
		<td colspan="6" class="grand info_title">
			DEVOLUCIÓN VOLUNTARIA INMEDIATA 
		</td>
	</tr>
	
	<tr >
		<td class="text-center"><strong>CONCEPTO</strong></td><td class="text-center"><strong>MONTO DE LA DEUDA</strong></td><td class="text-center"><strong>FECHA DE PAGO</strong></td><td class="text-center"><strong>ENTIDAD FINANCIERA</strong></td>
	</tr>
	<tr>
		<td>Devolución por: <strong>Pagos en demasía del Complemento Económico.</strong></td>
		<td style="width:100px" class="text-right">Bs. {!! Util::formatMoney($devolution->total) !!}</td>
		<td style="width:100px" class="text-center">{!! Util::getDateShort($devolution->payment_date) !!}</td>
		<td>Deposito a realizar en la Cuenta Fiscal de la Mutual de Servicios al Policía - MUSERPOL, N° 1-21495276 del BANCO UNIÓN.</td>
	</tr>
</table>
