@extends('app')

@section('contentheader_title')

    <div class="row">
        <div class="col-md-8">
            {!! Breadcrumbs::render('base_wages') !!}
        </div>
        <div class="col-md-4 text-right">
            @can('manage')
                <a href="" data-target="#myModal-import" class="btn btn-raised btn-success dropdown-toggle" data-toggle="modal">&nbsp;
                    <i class="glyphicon glyphicon-import"></i>&nbsp;
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
                    <h3 class="panel-title">Primer Nivel</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-hover" id="first_level_base_wage-table">
                        <thead>
                            <tr class="warning">
                                <th>AÑO</th>
                                <th><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="00 00 - COMANDANTE GENERAL">CMTE GRAL</div></th>
                                <th><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="00 01 - COMANDANTE GENERAL">CMTE GRAL</div></th>
                                <th><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="00 02 - SUBCOMANDANTE GENERAL">SBCMTE</div></th>
                                <th><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="00 03 - INSPECTOR GENERAL">INSP GRAL</div></th>
                                <th><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="00 04 - DIRECTOR GENERAL">DIR GRAL</div></th>
                                <th><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="01 01 - CORONEL CON SUELDO DE GENERAL">CNL</div></th>
                                <th><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="01 02 - CORONEL">CNL</div></th>
                                <th><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="01 03 - TENIENTE CORONEL">TCNL</div></th>
                                <th><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="01 04 - MAYOR">MY</div></th>
                                <th><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="01 05 - CAPITAN">CAP</div></th>
                                <th><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="01 06 - TENIENTE">TTE</div></th>
                                <th><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="01 07 - SUBTENIENTE">SBTTE</div></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="myModal-import" class="modal fade bs-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="box-header with-border">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Importar Archivo con Sueldos</h4>
                </div>
                <div class="modal-body">

                    {!! Form::open(['method' => 'POST', 'route' => ['base_wage.store'], 'class' => 'form-horizontal', 'files' => true ]) !!}

                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                        {!! Form::label('archive', 'Archivo', ['class' => 'col-md-3 control-label']) !!}
                                    <div class="col-md-8">
                                        <input type="file" id="inputFile" name="archive" required>
                                        <input type="text" readonly="" class="form-control " placeholder="Formato Excel">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                        {!! Form::label('month_year', 'Mes y Año', ['class' => 'col-md-3 control-label']) !!}
                                    <div class="col-md-7">
                                        <div class="input-group">
                                            <input type="text" class="form-control datepicker" name="month_year" value="" required>
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row text-center">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <a href="{!! url('base_wage') !!}" class="btn btn-raised btn-warning" data-toggle="tooltip" data-placement="bottom" data-original-title="Cancelar">&nbsp;<i class="glyphicon glyphicon-remove"></i>&nbsp;</a>
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

    <script type="text/javascript">

        $('.datepicker').datepicker({
            format: "mm/yyyy",
            viewMode: "months",
            minViewMode: "months",
            language: "es",
            orientation: "bottom right",
            autoclose: true
        });

        $(function() {
            $('#first_level_base_wage-table').DataTable({
                "dom": '<"top">t<"bottom"p>',
                "order": [[ 0, "desc" ]],
                processing: true,
                serverSide: true,
                pageLength: 10,
                autoWidth: false,
                ajax: '{!! route('get_complementarity_factor') !!}',
                columns: [
                    { data: 'month_year', sClass: "text-center" },
                    { data: 'c1', sClass: "text-right", bSortable: false },
                    { data: 'c2', sClass: "text-right", bSortable: false },
                    { data: 'c3', sClass: "text-right", bSortable: false }
                ]
            });

        });

    </script>

@endpush
