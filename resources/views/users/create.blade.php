@extends('app')
@section('contentheader_title')
	{!! Breadcrumbs::render('create_user') !!}
@endsection

@section('main-content')
    <div class="row">
        <div class="col-md-12">
					{!! Form::open(['method' => 'POST', 'route' => ['user.store'], 'class' => 'form-horizontal']) !!}

			    <div class="row">
			        <div class="col-md-6">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h3 class="panel-title">Datos Personales</h3>
							</div>
							<div class="panel-body">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
												{!! Form::label('first_name', 'Nombres', ['class' => 'col-md-4 control-label']) !!}
											<div class="col-md-6">
												{!! Form::text('first_name', null, ['class'=> 'form-control', 'required' => 'required', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
												<span class="help-block">Primer y Segundo Nombre</span>
											</div>
										</div>
										<div class="form-group">
												{!! Form::label('last_name', 'Apellidos', ['class' => 'col-md-4 control-label']) !!}
											<div class="col-md-6">
												{!! Form::text('last_name', null, ['class'=> 'form-control', 'required' => 'required', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
												<span class="help-block">Apellido Paterno y Apellido Materno</span>
											</div>
										</div>
										<div class="form-group">
												{!! Form::label('phone', 'Núm de Teléfono', ['class' => 'col-md-4 control-label']) !!}
											<div class="col-md-6">
												{!! Form::text('phone', null, ['class'=> 'form-control', 'required' => 'required']) !!}
												<span class="help-block">Teléfono Celular</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h3 class="panel-title">Datos de Ingreso</h3>
							</div>
							<div class="panel-body">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
												{!! Form::label('username', 'Nombre de Usuario', ['class' => 'col-md-4 control-label']) !!}
											<div class="col-md-6">
												{!! Form::text('username', null, ['class'=> 'form-control', 'required' => 'required']) !!}
													<span class="help-block">Número de Carnet de Identidad</span>
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

							            <div class="form-group">
							              	{!! Form::label('role', 'Tipo de Usuario', ['class' => 'col-md-4 control-label']) !!}
							              <div class="col-md-6">
							              	{!! Form::select('role', $list_roles, null, ['class' => 'combobox form-control', 'required' => 'required']) !!}
						                	<span class="help-block">Selecione el Tipo de Usuario</span>
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
		</div>
	</div>

@endsection

@push('scripts')

<script type="text/javascript">

	  $(document).ready(function(){

	  	$('.combobox').combobox();

	  });

</script>

@endpush
