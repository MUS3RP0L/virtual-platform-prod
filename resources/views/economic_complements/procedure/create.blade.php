@extends('app')

@section('contentheader_title')

	{!! Breadcrumbs::render('edit_eco_com_procedure') !!}

@endsection

@section('main-content')

	{!! Form::open(['method' => 'POST', 'route' => ['economic_complement_procedure.store'], 'class' => 'form-horizontal']) !!}
	    <div class="row">
	        <div class="col-md-12">
				<div class="box box-warning box-solid">
	                <div class="box-header with-border">
						<h3 class="panel-title">Crear un Nuevo Rango de Fechas</h3>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
										{!! Form::label('year', 'Año', ['class' => 'col-md-4 control-label']) !!}
										<div class="col-md-3">
											{!! Form::number('year', $year ?? null, ['class' => ' form-control','required']) !!}
										</div>
								</div>
								<div class="form-group">
									{!! Form::label('semester', 'Semestre', ['class' => 'col-md-4 control-label']) !!}
									<div class="col-md-4">
										{!! Form::select('semester', ['Primer' => 'Primer', 'Segundo' => 'Segundo'], $semester ?? null,['class' => 'form-control combobox','required']) !!}
									</div>
								</div>
								<div class="form-group">
									{!! Form::label('rent_month', 'Mes Renta', ['class' => 'col-md-4 control-label']) !!}
									<div class="col-md-4">
										{!! Form::select('rent_month',['Enero' => 'Enero', 'Febrero' => 'Febrero', 'Marzo' => 'Marzo', 'Abril' => 'Abril', 'Mayo' => 'Mayo', 'Junio' => 'Junio', 'Julio' => 'Julio', 'Agosto' => 'Agosto', 'Septiembre' => 'Septiembre', 'Octubre' => 'Octubre','Noviembre' => 'Noviembre', 'Diciembre' => 'Diciembre'],null,['class' => 'form-control combobox','required']) !!}
									</div>
								</div>

								<div class="form-group">
									{!! Form::label('normal_range_date', 'Normal', ['class' => 'col-md-4 control-label']) !!}
								    <div class='col-md-6'>
								    	<div class="col-md-6">
								            <div class='input-group date' id='normal_start_date'>
								            	{!! Form::text('normal_start_date', null , ['class'=> 'form-control', 'required' => 'required']) !!}
								                <span class="input-group-addon">
								                    <span class="glyphicon glyphicon-calendar"></span>
								                </span>
								            </div>
								    	</div>
								    	<div class="col-md-6">
								            <div class='input-group date' id='normal_end_date'>
								                {!! Form::text('normal_end_date', null, ['class'=> 'form-control', 'required' => 'required']) !!}
								                <span class="input-group-addon">
								                    <span class="glyphicon glyphicon-calendar"></span>
								                </span>
								    	</div>
								        </div>
								    </div>
								</div>
								<div class="form-group">
									{!! Form::label('lagging_range_date', 'Rezagados', ['class' => 'col-md-4 control-label']) !!}
								    <div class='col-md-6'>
								    	<div class="col-md-6">
								            <div class='input-group date' id='lagging_start_date'>
								            	{!! Form::text('lagging_start_date', null, ['class'=> 'form-control', 'required' => 'required']) !!}
								                <span class="input-group-addon">
								                    <span class="glyphicon glyphicon-calendar"></span>
								                </span>
								            </div>
								    	</div>
								    	<div class="col-md-6">
								            <div class='input-group date' id='lagging_end_date'>
								                {!! Form::text('lagging_end_date', null, ['class'=> 'form-control', 'required' => 'required']) !!}
								                <span class="input-group-addon">
								                    <span class="glyphicon glyphicon-calendar"></span>
								                </span>
								    	</div>
								        </div>
								    </div>
								</div>
								<div class="form-group">
									{!! Form::label('additional_range_date', 'Adicionales', ['class' => 'col-md-4 control-label']) !!}
								    <div class='col-md-6'>
								    	<div class="col-md-6">
								            <div class='input-group date' id='additional_start_date'>
								            	{!! Form::text('additional_start_date', null, ['class'=> 'form-control', 'required' => 'required']) !!}
								                <span class="input-group-addon">
								                    <span class="glyphicon glyphicon-calendar"></span>
								                </span>
								            </div>
								    	</div>
								    	<div class="col-md-6">
								            <div class='input-group date' id='additional_end_date'>
								                {!! Form::text('additional_end_date',null, ['class'=> 'form-control', 'required' => 'required']) !!}
								                <span class="input-group-addon">
								                    <span class="glyphicon glyphicon-calendar"></span>
								                </span>
								    	</div>
								        </div>
								    </div>
								</div>
								<div class="form-group">
									{!! Form::label('indicator', 'Indicador', ['class' => 'col-md-4 control-label']) !!}
									<div class="col-md-6">
									{!! Form::text('indicator', null , ['class' => 'form-control aps', "data-inputmask"=>"'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'",'required' => 'required']) !!}
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
					<a href="{!! url('economic_complement_procedure') !!}" class="btn btn-raised btn-warning" data-toggle="tooltip" data-placement="bottom" data-original-title="Cancelar">&nbsp;<i class="glyphicon glyphicon-remove"></i>&nbsp;</a>
					&nbsp;&nbsp;<button type="submit" class="btn btn-raised btn-success" data-toggle="tooltip" data-placement="bottom" data-original-title="Guardar">&nbsp;<i class="glyphicon glyphicon-floppy-disk"></i>&nbsp;</button>
				</div>
            </div>
    	</div>
	{!! Form::close() !!}
<link rel="stylesheet" href="/css/bootstrap-datetimepicker.css">
@endsection
@push('scripts')
<script src="/js/moment-with-locales.min.js"></script>
<script src="/js/bootstrap-datetimepicker.js"></script>
<script>
$(function () {
	$('#indicator').inputmask();
        $('#normal_start_date').datetimepicker({
        	format:"D/M/YYYY"
        });
        $('#normal_end_date').datetimepicker({
            useCurrent: false,
            format:"D/M/YYYY"
        });
        $("#normal_start_date").on("dp.change", function (e) {
            $('#normal_end_date').data("DateTimePicker").minDate(e.date);
        });
        $("#normal_end_date").on("dp.change", function (e) {
            $('#normal_start_date').data("DateTimePicker").maxDate(e.date);
        });

        $('#lagging_start_date').datetimepicker({
        	format:"D/M/YYYY"
        });
        $('#lagging_end_date').datetimepicker({
            useCurrent: false,
            format:"D/M/YYYY"
        });
        $("#lagging_start_date").on("dp.change", function (e) {
            $('#lagging_end_date').data("DateTimePicker").minDate(e.date);
        });
        $("#lagging_end_date").on("dp.change", function (e) {
            $('#lagging_start_date').data("DateTimePicker").maxDate(e.date);
        });

        $('#additional_start_date').datetimepicker({
        	format:"D/M/YYYY"
        });
        $('#additional_end_date').datetimepicker({
            useCurrent: false,
            format:"D/M/YYYY"
        });
        $("#additional_start_date").on("dp.change", function (e) {
            $('#additional_end_date').data("DateTimePicker").minDate(e.date);
        });
        $("#additional_end_date").on("dp.change", function (e) {
            $('#lagging_start_date').data("DateTimePicker").maxDate(e.date);
        });
        $('#semester').combobox();
    });
</script>
@endpush
