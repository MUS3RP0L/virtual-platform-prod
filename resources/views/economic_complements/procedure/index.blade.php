@extends('app')
@section('contentheader_title')
    <div class="row">
        <div class="col-md-8">
            {!! Breadcrumbs::render('eco_com_procedure') !!}
        </div>
    	<div class="col-md-4 text-right">
            <a href="{!! url('economic_complement_procedure/create') !!}" class="btn btn-raised btn-success" data-toggle="tooltip" data-placement="top" data-original-title="Nuevo">&nbsp;
                <i class="fa fa-plus"></i>&nbsp;
            </a>
        </div>
    </div>
@endsection
@section('main-content')
<div class="row">
	<div class="col-md-12">
		<div class="box box-danger">
			<div class="box-header with-border">
				<h3 class="box-title">Rango de fechas</h3>
			</div>
			<div class="box-body" style="width: 95%">
				<table id="procedure" class="table table-hover table-striped table-condensed">
				<thead>
				<tr>
					<th>Año</th>
					<th>Semestre</th>
					<th>Inicio Normal</th>
					<th>Fin Normal</th>
					<th>Inicio Rezagados</th>
					<th>Fin Rezagados</th>
					<th>Inicio Adicionales</th>
					<th>Fin Adicionales</th>
					<th>Opciones</th>
				</tr>
				</thead>
			</table>
			</div>
		</div>
	</div>
</div>
<div id="modalEditProcedure" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="box-header with-border">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Editando Rango de Fechas</h4>
            </div>
            <div class="box-body" data-bind="event: {mouseover: save, mouseout: save}">
            	{!! Form::open(['method' => 'POST', 'url' => ['economic_complement_procedure'], 'class' => 'form-horizontal']) !!}
            		<input type="hidden" id="economic_complement_procedure_id" name="economic_complement_procedure_id">
            	    		    
					<div class="form-group">
						{!! Form::label('year', 'Año', ['class' => 'col-md-4 control-label']) !!}
						<div class="col-md-6">
						{!! Form::number('year', null , ['class'=> 'form-control', 'required' => 'required']) !!}
						</div>
					</div>
					<div class="form-group">
						{!! Form::label('semester', 'Semestre',['class' => 'col-md-4 control-label']) !!}
						<div class="col-md-6">
						{!! Form::select('semester', ['Primer' => 'Primer', 'Segundo' => 'Segundo'], null, ['class' => 'form-control combobox', 'required']) !!}
						</div>
					</div>
					<div class="form-group">
						{!! Form::label('normal_range_date', 'Normal', ['class' => 'col-md-4 control-label']) !!}
					    <div class='col-md-6'>
					    	<div class="col-md-6">
					            <div class='input-group date' id='normal_start_date_edit'>
					            	{!! Form::text('normal_start_date', null , ['class'=> 'form-control', 'required' => 'required']) !!}
					                <span class="input-group-addon">
					                    <span class="glyphicon glyphicon-calendar"></span>
					                </span>
					            </div>
					    	</div>
					    	<div class="col-md-6">
					            <div class='input-group date' id='normal_end_date_edit'>
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
					            <div class='input-group date' id='lagging_start_date_edit'>
					            	{!! Form::text('lagging_start_date', null, ['class'=> 'form-control', 'required' => 'required']) !!}
					                <span class="input-group-addon">
					                    <span class="glyphicon glyphicon-calendar"></span>
					                </span>
					            </div>
					    	</div>
					    	<div class="col-md-6">
					            <div class='input-group date' id='lagging_end_date_edit'>
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
					            <div class='input-group date' id='additional_start_date_edit'>
					            	{!! Form::text('additional_start_date', null, ['class'=> 'form-control', 'required' => 'required']) !!}
					                <span class="input-group-addon">
					                    <span class="glyphicon glyphicon-calendar"></span>
					                </span>
					            </div>
					    	</div>
					    	<div class="col-md-6">
					            <div class='input-group date' id='additional_end_date_edit'>
					                {!! Form::text('additional_end_date', null, ['class'=> 'form-control', 'required' => 'required']) !!}
					                <span class="input-group-addon">
					                    <span class="glyphicon glyphicon-calendar"></span>
					                </span>
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
            </div>
        </div>
    </div>
</div>
<div id="modalDeleteProcedure" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="box-header with-border">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Elimando Rango de Fechas</h4>
            </div>
            <div class="box-body" data-bind="event: {mouseover: save, mouseout: save}">
            	{!! Form::open(['method' => 'POST', 'route' => ['eco_com_pro_delete'], 'class' => 'form-horizontal']) !!}
            		<input type="hidden" id="delete_economic_complement_procedure_id" name="economic_complement_procedure_id">
            		<h2 style="text-align: center">Esta seguro de eliminar</h2>    		    
            		<div class="row text-center">
                        <div class="form-group">
            				<div class="col-md-12">
            					<a href="{!! url('economic_complement_procedure') !!}" class="btn btn-raised btn-warning" data-toggle="tooltip" data-placement="bottom" data-original-title="Cancelar">&nbsp;<i class="glyphicon glyphicon-remove"></i>&nbsp;</a>
            					&nbsp;&nbsp;<button type="submit" class="btn btn-raised btn-success" data-toggle="tooltip" data-placement="bottom" data-original-title="Guardar">&nbsp;<i class="glyphicon glyphicon-floppy-disk"></i>&nbsp;</button>
            				</div>
                        </div>
                	</div>
            	{!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="/css/bootstrap-datetimepicker.css">
@endsection
@push('scripts')
@push('scripts')
<script src="/js/moment-with-locales.min.js"></script>
<script src="/js/bootstrap-datetimepicker.js"></script>
<script>
$(function () {
        $('#normal_start_date_edit').datetimepicker({
            format:"D/M/YYYY"
        });
        $('#normal_end_date_edit').datetimepicker({
            useCurrent: false,
            format:"D/M/YYYY"
        });
        $("#normal_start_date_edit").on("dp.change", function (e) {
            $('#normal_end_date_edit').data("DateTimePicker").minDate(e.date);
        });
        $("#normal_end_date_edit").on("dp.change", function (e) {
            $('#normal_start_date_edit').data("DateTimePicker").maxDate(e.date);
        });

        $('#lagging_start_date_edit').datetimepicker({
        	format:"D/M/YYYY"
        });
        $('#lagging_end_date_edit').datetimepicker({
            useCurrent: false,
            format:"D/M/YYYY"
        });
        $("#lagging_start_date_edit").on("dp.change", function (e) {
            $('#lagging_end_date_edit').data("DateTimePicker").minDate(e.date);
        });
        $("#lagging_end_date_edit").on("dp.change", function (e) {
            $('#lagging_start_date_edit').data("DateTimePicker").maxDate(e.date);
        });

        $('#additional_start_date_edit').datetimepicker({
        	format:"D/M/YYYY"
        });
        $('#additional_end_date_edit').datetimepicker({
            useCurrent: false,
            format:"D/M/YYYY"
        });
        $("#additional_start_date_edit").on("dp.change", function (e) {
            $('#additional_end_date_edit').data("DateTimePicker").minDate(e.date);
        });
        $("#additional_end_date_edit").on("dp.change", function (e) {
            $('#lagging_start_date_edit').data("DateTimePicker").maxDate(e.date);
        });
    });

	$(document).ready(function() {
		//for edit procedure
		$(document).on('click', '.editProcedure', function(event) {
            $.get('/economic_complement_procedure/'+$(this).data('procedure_id'), function(data) {
            	$('#normal_start_date_edit').find('input').val(data.normal_start_date);
            	$('#normal_end_date_edit').find('input').val(data.normal_end_date);
            	$('#additional_start_date_edit').find('input').val(data.additional_start_date);
            	$('#additional_end_date_edit').find('input').val(data.additional_end_date);
            	$('#lagging_start_date_edit').find('input').val(data.lagging_start_date);
            	$('#lagging_end_date_edit').find('input').val(data.lagging_end_date);
            	$('#semester').val(data.semester);
            	$('#year').val(data.year);
            	$('#economic_complement_procedure_id').val(data.id);
            	$('#semester').combobox();
            });
            event.preventDefault();
        });
		//for edit procedure
		$(document).on('click', '.deleteProcedure', function(event) {
            $.get('/economic_complement_procedure/'+$(this).data('procedure_id'), function(data) {
            	$('#delete_economic_complement_procedure_id').val(data.id);
            });
            event.preventDefault();
        });
		var oTable = $('#procedure').DataTable({
				"dom": '<"top">t<"bottom"p>',
				processing: true,
				serverSide: true,
                pageLength: 10,
                autoWidth: false,
				ajax: "{{ route('eco_com_pro_data') }}",
				columns: [
					{data: 'year', name: 'year'},
					{data: 'semester', name: 'release_date',bSortable: false },
					{data: 'normal_start_date', name: 'normal_start_date',bSortable: false },
					{data: 'normal_end_date', name: 'normal_end_date',bSortable: false },
					{data: 'lagging_start_date', name: 'lagging_start_date',bSortable: false },
					{data: 'lagging_end_date', name: 'lagging_end_date',bSortable: false },
					{data: 'additional_start_date', name: 'additional_start_date',bSortable: false },
					{data: 'additional_end_date', name: 'additional_end_date',bSortable: false },
					{data: 'action',bSortable: false },
				],
				search: {
					"regex": true
				}
			});
		});
	</script>
@endpush