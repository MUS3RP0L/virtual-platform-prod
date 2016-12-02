@extends('app')

@section('contentheader_title')

    <div class="row">
        <div class="col-md-8">
            {!! Breadcrumbs::render('ipc_rates') !!}
        </div>
        <div class="col-md-4 text-right">
            @can('manage')
                <a href="" data-target="#myModal-edit" class="btn btn-raised btn-success dropdown-toggle" data-toggle="modal">&nbsp;
                    <i class="glyphicon glyphicon-wrench"></i>&nbsp;
                </a>
            @endcan
        </div>
    </div>

@endsection

@section('main-content')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="panel-title">Despliegue</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-hover" id="afiliados-table">
                        <thead>
                            <tr class="warning">
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

    <div id="myModal-edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog">
            <div class="modal-content panel-warning">
                <div class="box-header with-border">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Editar Tasas de Índice de Precio al Consumidor</h4>
                </div>
                <div class="modal-body">

                    {!! Form::model($last_ipc_rate, ['method' => 'PATCH', 'route' => ['ipc_rate.update', $last_ipc_rate->id], 'class' => 'form-horizontal']) !!}
                        <br>
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
                "order": [[ 0, "desc" ]],
                processing: true,
                serverSide: true,
                pageLength: 12,
                autoWidth: false,
                ajax: '{!! route('get_ipc_rate') !!}',
                columns: [
                    { data: 'year', name:'month_year' },
                    { data: 'month', bSortable: false },
                    { data: 'index', "sClass": "text-center", bSortable: false }
                ]
            });
        });

    </script>

@endpush
