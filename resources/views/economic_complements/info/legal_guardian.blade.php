<table>
	<tr>
		<td colspan="6" class="grand info_title">INFORMACIÓN DEL APODERADO ({{($economic_complement->has_legal_guardian && !$economic_complement->has_legal_guardian_s) ? "COBRADOR" : "SOLICITANTE" }})</td>
	</tr>
	<tr>
		<td><strong>NOMBRE:</strong></td><td nowrap colspan="3">{!! $economic_complement_legal_guardian->getFullName() !!}</td>
		<td><strong>C.I.:</strong></td><td nowrap>{!! $economic_complement_legal_guardian->identity_card !!} {!! $economic_complement_legal_guardian->city_identity_card->first_shortened ?? '' !!}</td>
	</tr>
</table>