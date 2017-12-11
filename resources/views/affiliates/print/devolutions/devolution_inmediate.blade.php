<table class="table" style="width:100%;">
	<tr>
		<td colspan="6" class="grand info_title">
			DEVOLUCIÓN VOLUNTARIA INMEDIATA 
		</td>
	</tr>
	
	<tr >
		<td><strong>CONCEPTO</strong></td><td><strong>MONTO DE LA DEUDA (BS.)</strong></td><td><strong>FECHA DE PAGO</strong></td><td><strong>ENTIDAD FINANCIERA</strong></td>
	</tr>
	<tr>
		<td>Devolución por: <strong>Pagos en demasía del Complemento Económico.</strong></td>
		<td style="width:100px">{!! Util::formatMoney($devolution->total) !!}</td>
		<td style="width:100px">{!! Util::getDateShort($devolution->payment_date) !!}</td>
		<td>Deposito a realizar en la Cuenta Fiscal de la Mutual de Servicios al Policía - MUSERPOL, N° 1-21495276 del BANCO UNIÓN.</td>
	</tr>
</table>
