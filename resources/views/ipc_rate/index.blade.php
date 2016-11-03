@extends('app')
@section('contentheader_title')
  {!! Breadcrumbs::render('ipc_rates') !!}
@endsection

@section('main-content')
    <div class="row">
        <div class="col-md-12">
            @can('manage')
                <div class="row">
                    <div class="col-md-12 text-right">
                        <div class="btn-group" style="margin:-6px 1px 12px;" data-toggle="tooltip" data-placement="top" data-original-title="Modificar">
                            <a href="" data-target="#myModal-edit" class="btn btn-raised btn-success dropdown-toggle" data-toggle="modal">&nbsp;<i class="glyphicon glyphicon-wrench"></i>&nbsp;</a>
                        </div>
                    </div>
                </div>
            @endcan
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Despliegue</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row"><p>
                                <div class="col-md-12">
                                    <table class="table table-hover" id="afiliados-table">
                                        <thead>
                                            <tr class="success">
                                                <th>Año</th>
                                                <th>Mes</th>
                                                <th>Índice de Precio al Consumidor</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>

<div id="myModal-edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog">
        <div class="modal-content panel-warning">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Editar Tasas de Índice de Precio al Consumidor</h4>
            </div>
            <div class="modal-body">

                {!! Form::model($last_ipc_rate, ['method' => 'PATCH', 'route' => ['ipc_rate.update', $last_ipc_rate->id], 'class' => 'form-horizontal']) !!}

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                    {!! Form::label('month_year', 'Mes y Año', ['class' => 'col-md-5 control-label']) !!}
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input type="text" class="form-control datepicker" name="month_year" value="{!! $last_ipc_rate->getMonthYearEdit() !!}">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                    {!! Form::label('index', 'Tasa IPC', ['class' => 'col-md-5 control-label']) !!}
                                <div class="col-md-3">
                                    {!! Form::text('index', $last_ipc_rate->index, ['class'=> 'form-control', 'required' => 'required']) !!}
                                    <span class="help-block">Monto de IPC</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row text-center">
                        <div class="form-group">
                            <div class="col-md-12">
                                <a href="{!! url('ipc_rate') !!}" class="btn btn-raised btn-warning" data-toggle="tooltip" data-placement="bottom" data-original-title="Cancelar">&nbsp;<i class="glyphicon glyphicon-remove"></i>&nbsp;</a>
                                &nbsp;&nbsp;
                                <button type="submit" class="btn btn-raised btn-success" data-toggle="tooltip" data-placement="bottom" data-original-title="Guardar">&nbsp;<i class="glyphicon glyphicon-floppy-disk"></i>&nbsp;</button>
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
});

$('.datepicker').datepicker({
    format: "mm/yyyy",
    viewMode: "months",
    minViewMode: "months",
    language: "es",
    orientation: "bottom right",
    autoclose: true
});

$(function() {
    $('#afiliados-table').DataTable({
        "dom": '<"top">t<"bottom"p>',
        processing: true,
        serverSide: true,
        pageLength: 10,
        ajax: '{!! route('get_ipc_rate') !!}',
        order: [0, "desc"],
        columns: [
            { data: 'year', name:'month_year' },
            { data: 'month', bSortable: false },
            { data: 'index', "sClass": "text-center", bSortable: false }
        ]
    });
});
</script>
@endpush
