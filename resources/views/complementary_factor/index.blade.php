@extends('app')

@section('contentheader_title')

    <div class="row">
        <div class="col-md-8">
            {!! Breadcrumbs::render('complementarity_factors') !!}
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
                    <h3 class="panel-title">Caso Vejez</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-hover" id="complementarity_factor_old_age-table">
                        <thead>
                            <tr class="warning">
                                <th>AÑO</th>
                                <th>Semestre</th>
                                <th><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="00 - GENERALES">GENERALES</div></th>
                                <th><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="01 - JEFES Y OFICIALES">JEFES Y OFICIALES</div></th>
                                <th><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="02 - JEFES Y OFICIALES ADMINISTRATIVOS">JEFES Y OFICIALES ADMTVOS.</div></th>
                                <th><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="03 - JEFES Y OFICIALES ADMINISTRATIVOS">SUBOFICIALES, CLASES Y POLICIAS</div></th>
                                <th><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="04 - SUBOFICIALES, CLASES Y POLICIAS ADMINSTRATIVOS">SUBOFICIALES, CLASES Y POLICIAS ADMTVOS.</div></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="panel-title">Caso Viudez</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-hover" id="complementary_factor_widowhood-table">
                        <thead>
                            <tr class="warning">
                                <th>AÑO</th>
                                <th>Semestre</th>
                                <th><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="00 - GENERALES">GENERALES</div></th>
                                <th><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="01 - JEFES Y OFICIALES">JEFES Y OFICIALES</div></th>
                                <th><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="02 - JEFES Y OFICIALES ADMINISTRATIVOS">JEFES Y OFICIALES ADMTVOS.</div></th>
                                <th><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="03 - JEFES Y OFICIALES ADMINISTRATIVOS">SUBOFICIALES, CLASES Y POLICIAS</div></th>
                                <th><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="04 - SUBOFICIALES, CLASES Y POLICIAS ADMINSTRATIVOS">SUBOFICIALES, CLASES Y POLICIAS ADMTVOS.</div></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @if($cf1_old_age)
        <div id="myModal-edit" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="box-header with-border">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Editar Factores de Complemantación</h4>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['method' => 'POST', 'route' => ['complementary_factor.store'], 'class' => 'form-horizontal']) !!}
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                            {!! Form::label('year', 'Año', ['class' => 'col-md-5 control-label']) !!}
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <input type="text" class="form-control datepicker" name="year" value="{!! $year !!}">
                                                <div class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <div class="radio radio-primary">
                                            <label>
                                                <input type="radio" name="semester" value='Primer'>Primer Semestre
                                            </label>
                                        </div>
                                        <div class="radio radio-primary">
                                            <label>
                                                <input type="radio" name="semester" value='Segundo'>Segundo Semestre
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="modal-title">Caso Vejez</h4>
                                    <div class="form-group">
                                            {!! Form::label('cf1_old_age', 'GENERALES', ['class' => 'col-md-8 control-label']) !!}
                                        <div class="col-md-3">
                                            {!! Form::text('cf1_old_age', $cf1_old_age, ['class'=> 'form-control', 'required' => 'required']) !!}
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                            {!! Form::label('cf2_old_age', 'JEFES Y OFICIALES', ['class' => 'col-md-8 control-label']) !!}
                                        <div class="col-md-3">
                                            {!! Form::text('cf2_old_age', $cf2_old_age, ['class'=> 'form-control', 'required' => 'required']) !!}
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                            {!! Form::label('cf3_old_age', 'JEFES Y OFICIALES ADMTVOS.', ['class' => 'col-md-8 control-label']) !!}
                                        <div class="col-md-3">
                                            {!! Form::text('cf3_old_age', $cf3_old_age, ['class'=> 'form-control', 'required' => 'required']) !!}
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                            {!! Form::label('cf4_old_age', 'SUBOFICIALES, CLASES Y POLICIAS', ['class' => 'col-md-8 control-label']) !!}
                                        <div class="col-md-3">
                                            {!! Form::text('cf4_old_age', $cf4_old_age, ['class'=> 'form-control', 'required' => 'required']) !!}
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                            {!! Form::label('cf5_old_age', 'SUBOFICIALES, CLASES Y POLICIAS ADMTVOS.', ['class' => 'col-md-8 control-label']) !!}
                                        <div class="col-md-3">
                                            {!! Form::text('cf5_old_age', $cf5_old_age, ['class'=> 'form-control', 'required' => 'required']) !!}
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h4 class="modal-title">Caso Viudez</h4>
                                    <div class="form-group">
                                            {!! Form::label('cf1_widowhood', 'GENERALES', ['class' => 'col-md-8 control-label']) !!}
                                        <div class="col-md-3">
                                            {!! Form::text('cf1_widowhood', $cf1_widowhood, ['class'=> 'form-control', 'required' => 'required']) !!}
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                            {!! Form::label('cf2_widowhood', 'JEFES Y OFICIALES', ['class' => 'col-md-8 control-label']) !!}
                                        <div class="col-md-3">
                                            {!! Form::text('cf2_widowhood', $cf2_widowhood, ['class'=> 'form-control', 'required' => 'required']) !!}
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                            {!! Form::label('cf3_widowhood', 'JEFES Y OFICIALES ADMTVOS.', ['class' => 'col-md-8 control-label']) !!}
                                        <div class="col-md-3">
                                            {!! Form::text('cf3_widowhood', $cf3_widowhood, ['class'=> 'form-control', 'required' => 'required']) !!}
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                            {!! Form::label('cf4_widowhood', 'SUBOFICIALES, CLASES Y POLICIAS', ['class' => 'col-md-8 control-label']) !!}
                                        <div class="col-md-3">
                                            {!! Form::text('cf4_widowhood', $cf4_widowhood, ['class'=> 'form-control', 'required' => 'required']) !!}
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                            {!! Form::label('cf5_widowhood', 'SUBOFICIALES, CLASES Y POLICIAS ADMTVOS.', ['class' => 'col-md-8 control-label']) !!}
                                        <div class="col-md-3">
                                            {!! Form::text('cf5_widowhood', $cf5_widowhood, ['class'=> 'form-control', 'required' => 'required']) !!}
                                            <span class="help-block"></span>
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
    @else

        <div id="myModal-edit" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="box-header with-border">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Añadir Factores de Complemantación</h4>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['method' => 'POST', 'route' => ['complementary_factor.store'], 'class' => 'form-horizontal']) !!}
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                            {!! Form::label('year', 'Año', ['class' => 'col-md-5 control-label']) !!}
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <input type="text" class="form-control datepicker" name="year" value="{!! $year !!}">
                                                <div class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <div class="radio radio-primary">
                                            <label>
                                                <input type="radio" name="semester" value='Primer'>Primer Semestre
                                            </label>
                                        </div>
                                        <div class="radio radio-primary">
                                            <label>
                                                <input type="radio" name="semester" value='Segundo'>Segundo Semestre
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="modal-title">Caso Vejez</h4>
                                    <div class="form-group">
                                            {!! Form::label('cf1_old_age', 'GENERALES', ['class' => 'col-md-8 control-label']) !!}
                                        <div class="col-md-3">
                                            {!! Form::text('cf1_old_age', null, ['class'=> 'form-control', 'required' => 'required']) !!}
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                            {!! Form::label('cf2_old_age', 'JEFES Y OFICIALES', ['class' => 'col-md-8 control-label']) !!}
                                        <div class="col-md-3">
                                            {!! Form::text('cf2_old_age', null, ['class'=> 'form-control', 'required' => 'required']) !!}
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                            {!! Form::label('cf3_old_age', 'JEFES Y OFICIALES ADMTVOS.', ['class' => 'col-md-8 control-label']) !!}
                                        <div class="col-md-3">
                                            {!! Form::text('cf3_old_age', null, ['class'=> 'form-control', 'required' => 'required']) !!}
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                            {!! Form::label('cf4_old_age', 'SUBOFICIALES, CLASES Y POLICIAS', ['class' => 'col-md-8 control-label']) !!}
                                        <div class="col-md-3">
                                            {!! Form::text('cf4_old_age', null, ['class'=> 'form-control', 'required' => 'required']) !!}
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                            {!! Form::label('cf5_old_age', 'SUBOFICIALES, CLASES Y POLICIAS ADMTVOS.', ['class' => 'col-md-8 control-label']) !!}
                                        <div class="col-md-3">
                                            {!! Form::text('cf5_old_age', null, ['class'=> 'form-control', 'required' => 'required']) !!}
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h4 class="modal-title">Caso Viudez</h4>
                                    <div class="form-group">
                                            {!! Form::label('cf1_widowhood', 'GENERALES', ['class' => 'col-md-8 control-label']) !!}
                                        <div class="col-md-3">
                                            {!! Form::text('cf1_widowhood', null, ['class'=> 'form-control', 'required' => 'required']) !!}
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                            {!! Form::label('cf2_widowhood', 'JEFES Y OFICIALES', ['class' => 'col-md-8 control-label']) !!}
                                        <div class="col-md-3">
                                            {!! Form::text('cf2_widowhood', null, ['class'=> 'form-control', 'required' => 'required']) !!}
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                            {!! Form::label('cf3_widowhood', 'JEFES Y OFICIALES ADMTVOS.', ['class' => 'col-md-8 control-label']) !!}
                                        <div class="col-md-3">
                                            {!! Form::text('cf3_widowhood', null, ['class'=> 'form-control', 'required' => 'required']) !!}
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                            {!! Form::label('cf4_widowhood', 'SUBOFICIALES, CLASES Y POLICIAS', ['class' => 'col-md-8 control-label']) !!}
                                        <div class="col-md-3">
                                            {!! Form::text('cf4_widowhood', null, ['class'=> 'form-control', 'required' => 'required']) !!}
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                            {!! Form::label('cf5_widowhood', 'SUBOFICIALES, CLASES Y POLICIAS ADMTVOS.', ['class' => 'col-md-8 control-label']) !!}
                                        <div class="col-md-3">
                                            {!! Form::text('cf5_widowhood', null, ['class'=> 'form-control', 'required' => 'required']) !!}
                                            <span class="help-block"></span>
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

    @endif


@endsection

@push('scripts')

    <script type="text/javascript">

        $('.datepicker').datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            language: "es",
            orientation: "bottom right",
            autoclose: true
        });

        $(function() {
            $('#complementarity_factor_old_age-table').DataTable({
                "dom": '<"top">t<"bottom"p>',
                "order": [[ 0, "desc" ]],
                processing: true,
                serverSide: true,
                pageLength: 10,
                autoWidth: false,
                ajax: '{!! route('get_complementary_factor_old_age') !!}',
                columns: [
                    { data: 'year', sClass: "text-center" },
                    { data: 'semester', sClass: "text-center", bSortable: false },
                    { data: 'cf1', sClass: "text-right", bSortable: false },
                    { data: 'cf2', sClass: "text-right", bSortable: false },
                    { data: 'cf3', sClass: "text-right", bSortable: false },
                    { data: 'cf4', sClass: "text-right", bSortable: false },
                    { data: 'cf5', sClass: "text-right", bSortable: false }
                ]
            });
        });

        $(function() {
            $('#complementary_factor_widowhood-table').DataTable({
                "dom": '<"top">t<"bottom"p>',
                "order": [[ 0, "desc" ]],
                processing: true,
                serverSide: true,
                pageLength: 10,
                autoWidth: false,
                ajax: '{!! route('get_complementary_factor_widowhood') !!}',
                columns: [
                    { data: 'year', sClass: "text-center" },
                    { data: 'semester', sClass: "text-center", bSortable: false },
                    { data: 'cf1', sClass: "text-right", bSortable: false },
                    { data: 'cf2', sClass: "text-right", bSortable: false },
                    { data: 'cf3', sClass: "text-right", bSortable: false },
                    { data: 'cf4', sClass: "text-right", bSortable: false },
                    { data: 'cf5', sClass: "text-right", bSortable: false }
                ]
            });
        });

    </script>

@endpush
