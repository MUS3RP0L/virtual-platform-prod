@extends('app')

@section('contentheader_title')

    <div class="row">
        <div class="col-md-10">
			{!! Breadcrumbs::render('create_economic_complement') !!}
        </div>
        <div class="col-md-2 text-right">
            <a href="{!! url('affiliate/' . $affiliate->id) !!}" class="btn btn-raised btn-warning" data-toggle="tooltip" data-placement="top" data-original-title="Atrás">
                &nbsp;<span class="glyphicon glyphicon-share-alt"></span>&nbsp;
            </a>
        </div>
    </div>

@endsection

@section('main-content')

    <div class="row">
        <div class="col-md-6">
            @include('affiliates.simple_info')
        </div>
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="box-title"><span class="glyphicon glyphicon-info-sign"></span> Información Adicional</h3>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-responsive" style="width:100%;">
                                <tr>
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                Semestre
                                            </div>
                                            <div class="col-md-6">
                                                {!! $semester !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                Gestión
                                            </div>
                                            <div class="col-md-6">
                                                {!! $year !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row text-center">
        <div class="col-md-12">
            <div class="form-group">
                <ul class="nav nav-pills" style="display:flex;justify-content:center;">
                    <li class="active"><a href="#"><span class="badge">1</span> Selecciones el Tipo de Proceso</a></li>
                    <li><a href="#"><span class="badge">2</span> Añada los Beneficiario</a></li>
                    <li><a href="#"><span class="badge">3</span> Seleccione Requisitos</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Selecciones el Tipo de Proceso</h3>
                </div>
                <div class="box-body">
                    {!! Form::open(['method' => 'POST', 'route' => ['economic_complement.store'], 'class' => 'form-horizontal']) !!}
                        <br>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-5">
                                <div class="form-group">
                                    <div class="radio radio-primary">
                                        <label>
                                            {!! Form::radio('eco_com_type', '1', ($eco_com_type == '1'), ['required' => 'required']) !!} Vejez
                                        </label>
                                    </div><br>
                                    <div class="radio radio-primary">
                                        <label>
                                            {!! Form::radio('eco_com_type', '2', ($eco_com_type == '2')) !!} Viudedad
                                        </label>
                                    </div><br>
                                    <div class="radio radio-primary">
                                        <label>
                                            {!! Form::radio('eco_com_type', '3', ($eco_com_type == '3')) !!} Orfandad
                                        </label>
                                    </div><br>
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

    </script>
@endpush
