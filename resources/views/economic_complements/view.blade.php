@extends('app')

@section('contentheader_title')

	<div class="row">
		<div class="col-md-10">
			{!! Breadcrumbs::render('show_economic_complement', $economic_complement) !!}
		</div>
		<div class="col-md-2 text-right">
			<a href="{!! url('economic_complement') !!}" class="btn btn-raised btn-warning" data-toggle="tooltip" data-placement="top" data-original-title="Atrás">
				&nbsp;<span class="glyphicon glyphicon-share-alt"></span>&nbsp;
			</a>
		</div>
	</div>

@endsection

@section('main-content')

	<div class="row">
	    <div class="col-md-6">
			@include('affiliates.simple_info')
		</div>
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="box-title"><span class="glyphicon glyphicon-info-sign"></span> Información Adicional</h3>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-responsive" style="width:100%;">
                                <tr>
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                Semestre
                                            </div>
                                            <div class="col-md-6">
                                                {!! $semester !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                Gestión
                                            </div>
                                            <div class="col-md-6">
                                                {!! $year !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
								<tr>
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                Tipo
                                            </div>
                                            <div class="col-md-6">
                                                {!! $eco_com_type !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-responsive" style="width:100%;">
                                <tr>
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                Ciudad
                                            </div>
                                            <div class="col-md-6">
                                                {!! $economic_complement->city->name !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
								<tr>
									<td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
										<div class="row">
											<div class="col-md-6">
												Estado
											</div>

                                            <div class="col-md-6">
												{!! $economic_complement->economic_complement_state->economic_complement_state_type->name !!}
											</div>
										</div>
									</td>
								</tr>
                                <tr>
									<td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
										<div class="row">
											<div class="col-md-6">
												Por
											</div>
                                            <div class="col-md-6">
												{!! $economic_complement->economic_complement_state->name !!}
											</div>
										</div>
									</td>
								</tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>

    <div class="row">
        <div class="col-md-6">
			<div class="box box-warning">
                <div class="box-header with-border">
					<div class="row">
                        <div class="col-md-10">
							<h3 class="box-title"><span class="fa fa-user-plus"></span> Información de Beneficiario</h3>
                        </div>
                        <div class="col-md-2 text-right">
                            <div data-toggle="tooltip" data-placement="left" data-original-title="Editar">
                                <a href="" class="btn btn-raised btn-xs btn-primary" data-toggle="modal" data-target="#myModal-applicant">&nbsp;&nbsp;
                                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp;&nbsp;
                                </a>
                            </div>
                        </div>
                    </div>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="col-md-6">
							<table class="table" style="width:100%;">
								<tr>
									<td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
										<div class="row">
											<div class="col-md-6">
												Carnet Identidad
											</div>
											<div class="col-md-6">
												{!! $eco_com_applicant->identity_card !!}
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
										<div class="row">
											<div class="col-md-6">
												Apellido Paterno
											</div>
											<div class="col-md-6">
												{!! $eco_com_applicant->last_name !!}
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
										<div class="row">
											<div class="col-md-6">
												Apellido Materno
											</div>
											<div class="col-md-6">
												{!! $eco_com_applicant->mothers_last_name !!}
											</div>
										</div>
									</td>
								</tr>
								@if ($eco_com_applicant->surname_husband)
	                                <tr>
	                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
	                                        <div class="row">
	                                            <div class="col-md-6">
	                                                Apellido de Esposo
	                                            </div>
	                                            <div class="col-md-6">
	                                                {!! $eco_com_applicant->surname_husband !!}
	                                            </div>
	                                        </div>
	                                    </td>
	                                </tr>
								@endif
								<tr>
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                Primer Nombre
                                            </div>
                                            <div class="col-md-6">
                                                {!! $eco_com_applicant->first_name !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
								<tr>
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                Segundo Nombre
                                            </div>
                                            <div class="col-md-6">
                                                {!! $eco_com_applicant->second_name !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
							</table>
						</div>
						<div class="col-md-6">
                            <table class="table" style="width:100%;">
                                <tr>
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                Fecha Nacimiento
                                            </div>
                                            <div class="col-md-6">
                                                 {!! $eco_com_applicant->getShortBirthDate() !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                Edad
                                            </div>
                                            <div class="col-md-6">
                                                {!! $eco_com_applicant->getHowOld() !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
								<tr>
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                NUA/CUA
                                            </div>
                                            <div class="col-md-6">
                                                {!! $eco_com_applicant->nua !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                Estado Civil
                                            </div>
                                            <div class="col-md-6">
                                                {!! $eco_com_applicant->getCivilStatus() !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
								<tr>
									<td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
										<div class="row">
											<div class="col-md-6">
												Teléfono(s)
											</div>
											<div class="col-md-6">
												{!! $eco_com_applicant->getPhone() !!}
											</div>
										</div>
									</td>
								</tr>
                            </table>
                        </div>
					</div>
				</div>
			</div>
			<div class="box box-warning">
                <div class="box-header with-border">
					<div class="row">
                        <div class="col-md-10">
							<h3 class="box-title"><span class="glyphicon glyphicon-inbox"></span> Requisitos Presentados</h3>
                        </div>
                        <div class="col-md-2 text-right">
                            <div data-toggle="tooltip" data-placement="left" data-original-title="Editar">
                                <a href="" class="btn btn-raised btn-xs btn-primary" data-toggle="modal" data-target="#myModal-requirements">&nbsp;&nbsp;
                                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp;&nbsp;
                                </a>
                            </div>
                        </div>
                    </div>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="col-md-12">
							<table class="table table-bordered table-hover" style="width:100%;font-size: 14px">
								<thead>
									<tr>
										<th>Nombre de Requisito</th>
										<th class="text-center">Estado</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($eco_com_submitted_documents as $item)
										<tr>
											<td>{!! $item->economic_complement_requirement->shortened !!}</td>
											<td>
												<div class="text-center">
													@if($item->status)
													<span class="fa fa-check-square-o fa-lg"></span>
													@else
													<span class="fa fa-square-o fa-lg"></span>
													@endif
												</div>
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
                        </div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="box box-warning">
                <div class="box-header with-border">
					<h3 class="box-title"><span class="fa fa-money"></span> Cálculo de Totales</h3>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="col-md-12">
							@if($economic_complement->base_wage_id)
								<table class="table table-bordered table-hover" style="width:100%;font-size: 14px">
									<tbody>
										<tr>
											<td style="width: 70%">Renta Total Cotizable</td>
											<td style="text-align: right">{!! $sub_total_rent !!}</td>
										</tr>
										<tr>
											<td style="width: 70%">Referente Salarial</td>
											<td style="text-align: right">{!! $salary_reference !!}</td>
										</tr>
										<tr>
											<td style="width: 70%">Antigüedad</td>
											<td style="text-align: right">{!! $seniority !!}</td>
										</tr>
										<tr>
											<td style="width: 70%">Salario Cotizable</td>
											<td style="text-align: right">{!! $salary_quotable !!}</td>
										</tr>
										<tr>
											<td style="width: 70%">Diferencia</td>
											<td style="text-align: right">{!! $difference !!}</td>
										</tr>
										<tr>
											<td style="width: 70%">Total Semestre</td>
											<td style="text-align: right">{!! $total_amount_semester !!}</td>
										</tr>
										<tr>
											<td style="width: 70%">Factor de Complementación</td>
											<td style="text-align: right">{!! $complementary_factor !!}</td>
										</tr>

									</tbody>
								</table>
								<table class="table table-bordered table-hover" style="width:100%;font-size: 14px">
									<tbody>
										<tr>
											<td style="width: 70%">Total a Cancelar</td>
											<td  style="text-align: right">{!! $total !!}</td>
										</tr>
									</tbody>
								</table>
							@endif
                        </div>
					</div>
				</div>
			</div>
		</div>
	</div>




	<div id="myModal-applicant" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="box-header with-border">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="box-title">Editar Beneficiario - {{ $eco_com_applicant->economic_complement_applicant_type->name }}</h4>
				</div>
				<div class="modal-body">
					{!! Form::model($economic_complement, ['method' => 'PATCH', 'route' => ['economic_complement.update', $economic_complement->id], 'class' => 'form-horizontal']) !!}
						<input type="hidden" name="step" value="second"/>
						<input type="hidden" name="type" value="update"/>
						<div class="row">
							<div class="col-md-6">
                                <div class="form-group">
                                    <div class="col-md-12">
                                            {!! Form::label('identity_card', 'Carnet de Identidad', ['class' => 'col-md-5 control-label']) !!}
                                        <div class="col-md-5">
                                            {!! Form::text('identity_card', $eco_com_applicant->identity_card, ['class'=> 'form-control', 'required']) !!}
                                            <span class="help-block">Número de CI</span>
                                        </div>
                                            {!! Form::select('city_identity_card_id', $cities_list_short, $eco_com_applicant->city_identity_card_id, ['class' => 'col-md-2 combobox form-control', 'required']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                        {!! Form::label('last_name', 'Apellido Paterno', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-6">
                                        {!! Form::text('last_name', $eco_com_applicant->last_name, ['class'=> 'form-control', 'required', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                                        <span class="help-block">Escriba el Apellido Paterno</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                        {!! Form::label('mothers_last_name', 'Apellido Materno', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-6">
                                        {!! Form::text('mothers_last_name', $eco_com_applicant->mothers_last_name, ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                                        <span class="help-block">Escriba el Apellido Materno</span>
                                    </div>
                                </div>
                                @if ($eco_com_applicant->gender == 'F')
                                    <div class="form-group">
                                            {!! Form::label('surname_husband', 'Apellido de Esposo', ['class' => 'col-md-5 control-label']) !!}
                                        <div class="col-md-6">
                                            {!! Form::text('surname_husband', $eco_com_applicant->surname_husband, ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                                            <span class="help-block">Escriba el Apellido de Esposo (Opcional)</span>
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group">
                                        {!! Form::label('first_name', 'Primer Nombre', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-6">
                                        {!! Form::text('first_name', $eco_com_applicant->first_name, ['class'=> 'form-control','required', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                                        <span class="help-block">Escriba el  Primer Nombre</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                        {!! Form::label('second_name', 'Segundo Nombre', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-6">
                                        {!! Form::text('second_name', $eco_com_applicant->second_name, ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                                        <span class="help-block">Escriba el Segundo Nombre</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                        {!! Form::label('birth_date', 'Fecha de Nacimiento', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-6">
                            			<div class="input-group">
                                            <input type="text" id="birth_date_mask" class="form-control" name="birth_date" value="{!! $eco_com_applicant->getEditBirthDate() !!}" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                        {!! Form::label('nua', 'CUA/NUA', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-6">
                                        {!! Form::text('nua', $eco_com_applicant->nua, ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                                        <span class="help-block">Escriba el Segundo Nombre</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                            {!! Form::label('civil_status', 'Estado Civil', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-6">
                                        {!! Form::select('civil_status', $gender_list, $eco_com_applicant->civil_status, ['class' => 'combobox form-control', 'required']) !!}
                                        <span class="help-block">Seleccione el Estado Civil</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                        {!! Form::label('phone_number', 'Teléfono fijo', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-6">
                                        <input type="text" id="phone_number" class="form-control" name="phone_number" value="{!! $eco_com_applicant->phone_number !!}" data-inputmask="'mask': '(9) 999 999'" data-mask>
                                        <span class="help-block">Escriba el Teléfono fijo</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                        {!! Form::label('cell_phone_number', 'Teléfono Celular', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-6">
                                        <input type="text" id="cell_phone_number" class="form-control" name="cell_phone_number" value="{!! $eco_com_applicant->cell_phone_number !!}" data-inputmask="'mask': '(999) 99999'" data-mask>
                                        <span class="help-block">Escriba el Teléfono Celular</span>
                                    </div>
                                </div>
                            </div>
						</div>

						<div class="row text-center">
							<div class="form-group">
								<div class="col-md-12">
									<a href="{!! url('economic_complement/' . $economic_complement->id) !!}" data-target="#" class="btn btn-raised btn-warning">&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;&nbsp;</a>
									&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-raised btn-success">&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;</button>
								</div>
							</div>
						</div>

					{!! Form::close() !!}

				</div>
			</div>
		</div>
	</div>

	<div id="myModal-requirements" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="box-header with-border">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Editar Documentos</h4>
				</div>
				<div class="box-body" data-bind="event: {mouseover: save, mouseout: save}">
					{!! Form::model($economic_complement, ['method' => 'PATCH', 'route' => ['economic_complement.update', $economic_complement->id], 'class' => 'form-horizontal']) !!}
						<input type="hidden" name="step" value="third"/>
						<div class="row">
							<div class="col-md-12">
								<table class="table table-bordered table-hover" style="font-size: 16px">
									<thead>
										<tr class="success">
											<th class="text-center">Requisitos</th>
											<th class="text-center">Estado</th>
										</tr>
									</thead>
									<tbody data-bind="foreach: requirements">
										<tr>
											<td data-bind='text: name'></td>
											<td>
												<div class="row text-center">
													<div class="checkbox">
														<label><input type="checkbox" data-bind='checked: status, valueUpdate: "afterkeydown"'/></label>
													</div>
												</div>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						{!! Form::hidden('data', null, ['data-bind'=> 'value: lastSavedJson']) !!}
						<br>
						<div class="row text-center">
							<div class="form-group">
								<div class="col-md-12">
									<a href="{!! url('economic_complement_reception_second_step/' . $economic_complement->id) !!}" class="btn btn-raised btn-warning" data-toggle="tooltip" data-placement="bottom" data-original-title="Volver">&nbsp;<span class="fa fa-undo"></span>&nbsp;</a>
									&nbsp;&nbsp;&nbsp;
									<button type="submit" class="btn btn-raised btn-success" data-toggle="tooltip" data-placement="bottom" data-original-title="Guardar">&nbsp;<span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;</button>
								</div>
							</div>
						</div>
					{!! Form::close() !!}

	            </div>
	        </div>
	    </div>
	</div>

@endsection

@push('scripts')
<script>

	$(document).ready(function(){
		$('.combobox').combobox();
	    $('[data-toggle="tooltip"]').tooltip();
		$("#birth_date_mask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/aaaa"});
		$("#phone_number").inputmask();
		$("#cell_phone_number").inputmask();
	});

	function SelectRequeriments(requirements) {

		var self = this;

		@if ($status_documents)
			self.requirements = ko.observableArray(ko.utils.arrayMap(requirements, function(document) {
			return { id: document.eco_com_requirement_id, name: document.economic_complement_requirement.shortened, status: document.status };
			}));
		@else
			self.requirements = ko.observableArray(ko.utils.arrayMap(requirements, function(document) {
			return { id: document.id, name: document.shortened, status: false };
			}));
		@endif

		self.save = function() {
			var dataToSave = $.map(self.requirements(), function(requirement) {
				return  {
					id: requirement.id,
					name: requirement.name,
					status: requirement.status
				}
			});
			self.lastSavedJson(JSON.stringify(dataToSave));
		};
		self.lastSavedJson = ko.observable("");

	};

	@if ($status_documents)
		window.model = new SelectRequeriments({!! $eco_com_submitted_documents !!});
	@else
		window.model = new SelectRequeriments({!! $eco_com_requirements !!});
	@endif

	ko.applyBindings(model);

</script>
@endpush
