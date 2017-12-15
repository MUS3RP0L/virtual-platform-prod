<table class="table" style="width:100%;">
	<tr>
		<td colspan="6" class="grand info_title">
			INFORMACIÓN DEL BENEFICIARIO
		</td>
	</tr>
	<tr >
		<td colspan="1"><strong>NOMBRE:</strong></td><td colspan="3" nowrap>{!! $eco_com_applicant->getFullName() !!}</td>
		<td><strong>C.I.:</strong></td><td nowrap>{!! $eco_com_applicant->identity_card !!} {{$eco_com_applicant->city_identity_card ? $eco_com_applicant->city_identity_card->first_shortened.'.' : ''}}</td>
	</tr>
	<tr>
		<td><strong>FECHA NAC:</strong></td><td> {!! $eco_com_applicant->getShortBirthDate() !!}</td>
		<td><strong>EDAD:</strong></td><td>{!! $eco_com_applicant->getAge() !!} AÑOS</td>
		<td><strong>LUGAR DE NAC.:</strong></td><td>{!! $eco_com_applicant->city_birth->name ?? '' !!}</td>
	</tr>
</table>