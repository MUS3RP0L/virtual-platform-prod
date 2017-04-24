@extends('app')

@section('contentheader_title')

	{!! Breadcrumbs::render('edit_user') !!}

@endsection

@section('main-content')

	{!! Form::model($user, ['method' => 'PATCH', 'route' => ['user.update', $user->id], 'class' => 'form-horizontal']) !!}
	    <div class="row">
	        <div class="col-md-6">
				<div class="box box-warning box-solid">
	                <div class="box-header with-border">
						<h3 class="panel-title">Datos Personales</h3>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								@can('manage')
								<div class="form-group">
										{!! Form::label('username', 'Usuario', ['class' => 'col-md-4 control-label']) !!}
									<div class="col-md-6">
										{!! Form::text('username', $user->username, ['class'=> 'form-control', 'required' => 'required']) !!}
											<span class="help-block">Nombre de Usuario</span>
									</div>
								</div>
								@endcan
								<div class="form-group">
										{!! Form::label('first_name', 'Nombres', ['class' => 'col-md-4 control-label']) !!}
									<div class="col-md-6">
										{!! Form::text('first_name', $user->first_name, ['class'=> 'form-control', 'required' => 'required']) !!}
										<span class="help-block">Primer y Segundo Nombre</span>
									</div>
								</div>
								<div class="form-group">
										{!! Form::label('last_name', 'Apellidos', ['class' => 'col-md-4 control-label']) !!}
									<div class="col-md-6">
										{!! Form::text('last_name', $user->last_name, ['class'=> 'form-control', 'required' => 'required']) !!}
										<span class="help-block">Apellido Paterno y Apellido Materno</span>
									</div>
								</div>
								<div class="form-group">
										{!! Form::label('phone', 'Núm de Teléfono', ['class' => 'col-md-4 control-label']) !!}
									<div class="col-md-6">
										<input type="text" id="phone" class="form-control" required = "required" name="phone" value ="{!! $user->phone !!}" data-inputmask="'mask': '(999) 99999'" data-mask>										
										<span class="help-block">Teléfono Celular</span>
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
	                            @can('manage')
									<div class="form-group">
										{!! Form::label('module', 'Unidad', ['class' => 'col-md-4 control-label']) !!}
										<div class="col-md-6">
											{!! Form::select('module', $list_modules, $user->getModule()->id, ['class' => 'form-control', 'required' => 'required']) !!}
											<span class="help-block">Selecione la Unidad correspondiente</span>
										</div>
									</div>
									<div class="form-group">
										{!! Form::label('role', 'Cargo', ['class' => 'col-md-4 control-label']) !!}
										<div class="col-md-6 checks" id='check'>
											<span class="help-block">Selecione el Cargo</span>
										</div>
										{!! Form::hidden('user', $user->id,['id'=> 'user_id'])!!}
										{{-- <input type="hidden" name="user" value="Norway"> --}}
									</div>
						        @endcan
						        <div class="row">
		                            <div class="col-md-6 col-md-offset-3">
		                                <div class="form-group">
		                                    <div class="togglebutton">
		                                      <label>
		                                        <input type="checkbox" data-bind="checked: passValue" name=""> Modificar Contraseña
		                                      </label>
		                                  </div>
		                                </div>
		                            </div>
	                            </div>
	                            <div data-bind='fadeVisible: passValue, valueUpdate: "afterkeydown"'>
									<div class="form-group">
											{!! Form::label('password', 'Contraseña', ['class' => 'col-md-4 control-label']) !!}
										<div class="col-md-6">
											{!! Form::password('password', ['class' => 'form-control']) !!}
											<span class="help-block">Ingrese la Contraseña</span>
										</div>
									</div>
									<div class="form-group">
											{!! Form::label('confirm_password', 'Repetir Contraseña', ['class' => 'col-md-4 control-label']) !!}
										<div class="col-md-6">
											{!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
											<span class="help-block">Ingrese de nuevo la Contraseña</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row text-center">
            <div class="form-group">
				<div class="col-md-12">
					<a href="{!! url('user') !!}" class="btn btn-raised btn-warning" data-toggle="tooltip" data-placement="bottom" data-original-title="Cancelar">&nbsp;<i class="glyphicon glyphicon-remove"></i>&nbsp;</a>
					&nbsp;&nbsp;
					<button type="submit" class="btn btn-raised btn-success" data-toggle="tooltip" data-placement="bottom" data-original-title="Guardar">&nbsp;<i class="glyphicon glyphicon-floppy-disk"></i>&nbsp;</button>
				</div>
            </div>
    	</div>
	{!! Form::close() !!}

@endsection

@push('scripts')

	<script type="text/javascript">

		$(document).ready(function(){

			var moduleID = $('select[name="module"]').val();
			var iduser = $('#user_id').val();
			$.ajax({
						url: '{!! url('get_role') !!}',
						type: "GET",
						dataType: "json",
						data: {
							"user_id" : iduser,
							"module_id": moduleID
						},
						success: function(data) {
								$('select[name="role"]').empty();
		                        $('#check').empty();
		                        var checked=false;
		                        $.each(data.list_roles, function(key, value) {
		                 			
									$.each(data.user_roles, function(index, val) {

											if(value.name==val.name){
												checked=true;
												return false;

		                        			 }

		                        	});

		                            var div=$('<div>').addClass('checkbox');
		                            var label=$('<label>');
		                            var input=$('<input>').attr({
		                            	type: 'checkbox',
		                            	name: 'role[]',
		                            	checked:checked
		                            }).val(value.id);
		                            input.appendTo(label);
		                            label.append("<span class='checkbox-material'><span class='check'></span></span>");
		                            label.append(' '+value.name);
		                            div.append(label);
				 					$('#check').append(div);
				 					checked=false;
		                        });
							
						}
					});


			$('select[name="module"]').on('change', function() {
				var moduleID = $(this).val();
				var iduser = $('#user_id').val();
				if(moduleID) {
					$.ajax({
						url: '{!! url('get_role') !!}',
						type: "GET",
						dataType: "json",
						data: {
							"user_id": iduser,
							"module_id":moduleID
						},
						success: function(data) {
							if(data.list_roles[0].module_id==data.user_roles[0].module_id){
								$('select[name="role"]').empty();
		                        $('#check').empty();
		                        var checked=false;
		                        $.each(data.list_roles, function(key, value) {
		                 			
									$.each(data.user_roles, function(index, val) {

											if(value.name==val.name){
												checked=true;
												return false;

		                        			 }

		                        	});

		                            var div=$('<div>').addClass('checkbox');
		                            var label=$('<label>');
		                            var input=$('<input>').attr({
		                            	type: 'checkbox',
		                            	name: 'role[]',
		                            	checked:checked
		                            }).val(value.id);
		                            input.appendTo(label);
		                            label.append("<span class='checkbox-material'><span class='check'></span></span>");
		                            label.append(' '+value.name);
		                            div.append(label);
				 					$('#check').append(div);
				 					checked=false;
		                        });
							}
							else{
								$('select[name="role"]').empty();
		                        $('#check').empty();
		                        $.each(data.list_roles, function(key, value) {
		                            var div=$('<div>').addClass('checkbox');
		                            var label=$('<label>');
		                            var input=$('<input>').attr({
		                            	type: 'checkbox',
		                            	name: 'role[]',
		                            }).val(value.id);
		                            input.appendTo(label);
		                            label.append("<span class='checkbox-material'><span class='check'></span></span>");
		                            label.append(' '+value.name);
		                            div.append(label);
				 					$('#check').append(div);
		                        });
							}
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

		var Model = function() {

	        this.passValue = ko.observable(false);
	    };

	    ko.bindingHandlers.fadeVisible = {
	        init: function(element, valueAccessor) {
	            var value = valueAccessor();
	            $(element).toggle(ko.unwrap(value));
	        },
	        update: function(element, valueAccessor) {
	            var value = valueAccessor();
	            ko.unwrap(value) ? $(element).fadeIn() : $(element).fadeOut();
	        }
	    };

	    ko.applyBindings(new Model());


	</script>

@endpush
