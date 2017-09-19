@extends('app')

@section('contentheader_title')

	{!! Breadcrumbs::render('create_user') !!}

@endsection

@section('main-content')

	{!! Form::open(['method' => 'POST', 'route' => ['user.store'], 'class' => 'form-horizontal']) !!}
	    <div class="row">
	        <div class="col-md-6">
				<div class="box box-warning box-solid">
	                <div class="box-header with-border">
						<h3 class="panel-title">Datos Personales</h3>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
										{!! Form::label('username', 'Usuario', ['class' => 'col-md-4 control-label']) !!}
									<div class="col-md-6">
										{!! Form::text('username', null, ['class'=> 'form-control', 'required' => 'required']) !!}
											<span class="help-block">Nombre de Usuario</span>
									</div>
								</div>
								<div class="form-group">
										{!! Form::label('first_name', 'Nombres', ['class' => 'col-md-4 control-label']) !!}
									<div class="col-md-6">
										{!! Form::text('first_name', null, ['class'=> 'form-control', 'required' => 'required']) !!}
										<span class="help-block">Primer y Segundo Nombre</span>
									</div>
								</div>
								<div class="form-group">
										{!! Form::label('last_name', 'Apellidos', ['class' => 'col-md-4 control-label']) !!}
									<div class="col-md-6">
										{!! Form::text('last_name', null, ['class'=> 'form-control', 'required' => 'required']) !!}
										<span class="help-block">Apellido Paterno y Apellido Materno</span>
									</div>
								</div>
								<div class="form-group">
										{!! Form::label('phone', 'Núm de Celular', ['class' => 'col-md-4 control-label']) !!}
									<div class="col-md-6">
										 <input type="text" id="phone" class="form-control" required = "required" name="phone" data-inputmask="'mask': '(999) 99999'" data-mask>
										 <span class="help-block">Teléfono Celular</span>
									</div>
								</div>
								<div class="form-group">
									{!! Form::label('city', 'Departamento', ['class' => 'col-md-4 control-label']) !!}
									<div class="col-md-6">
										{!! Form::select('city', $cities_list, '', ['class' => 'col-md-2 combobox form-control','required' => 'required']) !!}
										<span class="help-block">Departamento</span>
									</div>
								</div>
								<div class="form-group">
									{!! Form::label('position', 'Cargo', ['class' => 'col-md-4 control-label']) !!}
									<div class="col-md-6">
										{!! Form::text('position', '', ['class' => 'form-control','required' => 'required']) !!}
										<span class="help-block">Cargo</span>
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="box box-warning box-solid">
	                <div class="box-header with-border">
						<h3 class="panel-title">Datos de Ingreso</h3>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									{!! Form::label('module', 'Unidad', ['class' => 'col-md-4 control-label']) !!}
									<div class="col-md-6">
										{!! Form::select('module', $list_modules, null, ['class' => 'form-control', 'required' => 'required']) !!}
										<span class="help-block">Selecione la Unidad correspondiente</span>
									</div>
								</div>
								<div class="form-group">
									{!! Form::label('role', 'Rol', ['class' => 'col-md-4 control-label']) !!}
									<div class="col-md-6 checks" id='check'>
									{{-- <span class="help-block">Selecione el Cargo</span> --}}
									</div>
								</div>
								<div class="form-group">
										{!! Form::label('password', 'Contraseña', ['class' => 'col-md-4 control-label']) !!}
									<div class="col-md-6">
										{!! Form::password('password', ['class' => 'form-control', 'required' => 'required']) !!}
										<span class="help-block">Ingrese la Contraseña</span>
									</div>
								</div>
								<div class="form-group">
										{!! Form::label('confirm_password', 'Repetir Contraseña', ['class' => 'col-md-4 control-label']) !!}
									<div class="col-md-6">
										{!! Form::password('password_confirmation', ['class' => 'form-control', 'required' => 'required']) !!}
										<span class="help-block">Ingrese de nuevo la Contraseña</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<br>
		<div class="row text-center">
            <div class="form-group">
				<div class="col-md-12">
					<a href="{!! url('user') !!}" class="btn btn-raised btn-warning" data-toggle="tooltip" data-placement="bottom" data-original-title="Cancelar">&nbsp;<i class="glyphicon glyphicon-remove"></i>&nbsp;</a>
					&nbsp;&nbsp;<button type="submit" class="btn btn-raised btn-success" data-toggle="tooltip" data-placement="bottom" data-original-title="Guardar">&nbsp;<i class="glyphicon glyphicon-floppy-disk"></i>&nbsp;</button>
				</div>
            </div>
    	</div>
	{!! Form::close() !!}

@endsection

@push('scripts')

	<script type="text/javascript">

		$(document).ready(function(){
			$('select[name="module"]').on('change', function() {
				var moduleID = $(this).val();
				if(moduleID) {
					$.ajax({
						url: '{!! url('get_role') !!}',
						type: "GET",
						dataType: "json",
						data:{
							"module_id" : moduleID
						},
						success: function(data) {
							$('select[name="role"]').empty();
							$('#check').empty();
							$.each(data.list_roles, function(key, value) {
								var div=$('<div>').addClass('checkbox');
								var label=$('<label>');
								var input=$('<input>').attr({
									type: 'checkbox',
									name: 'role[]'
								}).val(value.id);
								input.appendTo(label);
								label.append("<span class='checkbox-material'><span class='check'></span></span>");
								label.append(' '+value.name);
								div.append(label);
								$('#check').append(div);
							});
						}
					});
				}
				else{
					$('select[name="role"]').empty();
				}
			});
		});

		$(document).ready(function(){
			$('.combobox').combobox();
			$('[data-toggle="tooltip"]').tooltip();
			$("#phone").inputmask();

		});

	</script>

@endpush
