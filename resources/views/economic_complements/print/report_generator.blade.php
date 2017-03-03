@extends('app')

@section('contentheader_title')
    {!! Breadcrumbs::render('report_generator') !!}
@endsection

@section('main-content')

<div class="row">
    <div class="col-md-12">
        <div class="box box-info box-solid">
            <div class="box-header with-border">
                    <h3 class="box-title"><span class="glyphicon glyphicon-search"></span>&nbsp;&nbsp;Reporte de complemento económico</h3>
            </div>
            <br />
            <div class="box-body">
                    <div class="row">
                            {!! Form::open(['method' => 'POST', 'route' => ['report_generator'], 'class' => 'form-horizontal']) !!}
                            <div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('year', 'Tipo Reporte', ['class' => 'col-md-4 control-label']) !!}
                                        <div class="col-md-8">
                                            {!! Form::select('year', $report_type_list, null, ['class' => 'combobox form-control', 'required' ]) !!}
                                            <span class="help-block">Tipo Reporte</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('city', 'Regional', ['class' => 'col-md-4 control-label']) !!}
                                        <div class="col-md-7">
                                            {!! Form::select('city', $all_cities_list, null, ['class' => 'combobox form-control', 'required' ]) !!}
                                            <span class="help-block">Seleccione Regional</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('year', 'Gestión', ['class' => 'col-md-4 control-label']) !!}
                                        <div class="col-md-7">
                                            {!! Form::select('year', $year_list, null, ['class' => 'combobox form-control', 'required' ]) !!}
                                            <span class="help-block">Seleccione Gestión</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('semester', 'Semestre', ['class' => 'col-md-4 control-label']) !!}
                                        <div class="col-md-7">
                                            {!! Form::select('semester', $all_semester_list, null, ['class' => 'combobox form-control', 'required' ]) !!}
                                            <span class="help-block">Seleccione Semestre</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <div class="col-md-12">
                                <div class="row text-center">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <button type="reset" class="btn btn-raised btn-warning" data-toggle="tooltip" data-placement="bottom" data-original-title="Limpiar">&nbsp;<span class="glyphicon glyphicon-erase"></span>&nbsp;</button>
                                            &nbsp;&nbsp;<button type="submit" class="btn btn-raised btn-success" data-toggle="tooltip" data-placement="bottom" data-original-title="Generar">&nbsp;<span class="glyphicon glyphicon-search"></span>&nbsp;</button>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </form>
                    </div>

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

</script>
@endpush
