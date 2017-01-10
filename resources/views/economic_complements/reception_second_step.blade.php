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
                            <table class="table table-responsive" style="width:100%;">
                                <tr>
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                Tipo
                                            </div>
                                            <div class="col-md-6">
                                                {!! $eco_com_type !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
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
                    <li><a href="#"><span class="badge">1</span> Tipo de Proceso</a></li>
                    <li class="active"><a href="#"><span class="badge">2</span> Beneficiario</a></li>
                    <li><a href="#"><span class="badge">3</span> Requisitos</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Añadir {{ eco_com_applicant_type->name }}</h3>
                </div>
                <div class="box-body">
                    {!! Form::model($eco_com_applicant, ['method' => 'PATCH', 'route' => ['applicant.update', $affiliate->id], 'class' => 'form-horizontal']) !!}
                        <br>
                        <input type="hidden" name="step" value="second"/>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                        {!! Form::label('identity_card', 'Carnet Identidad', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::text('identity_card', $eco_com_applicant->identity_card,['class'=> 'form-control', 'required', 'data-bind' => 'value: soli_identity_card']) !!}
                                        <span class="help-block">Núm. Carnet de Identidad</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                        {!! Form::label('last_name', 'Apellido Paterno', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::text('last_name', $eco_com_applicant->last_name, ['class'=> 'form-control', 'required', 'onkeyup' => 'this.value=this.value.toUpperCase()', 'data-bind' => 'value: soli_last_name']) !!}
                                        <span class="help-block">Escriba Apellido Paterno</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                        {!! Form::label('mothers_last_name', 'Apellido Materno', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::text('mothers_last_name', $eco_com_applicant->mothers_last_name, ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()', 'data-bind' => 'value: soli_mothers_last_name']) !!}
                                        <span class="help-block">Escriba Apellido Materno</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                        {!! Form::label('first_name', 'Nombre(s)', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::text('first_name', $eco_com_applicant->first_name, ['class'=> 'form-control', 'required', 'onkeyup' => 'this.value=this.value.toUpperCase()', 'data-bind' => 'value: soli_first_name']) !!}
                                        <span class="help-block">Escriba los Nombre(s)</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                        {!! Form::label('home_address', 'Domicilio  Actual', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::text('home_address', $eco_com_applicant->home_address, ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()', 'data-bind' => 'value: soli_home_address']) !!}
                                        <span class="help-block">Escriba Domicilio Actual</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                        {!! Form::label('home_phone_number', 'Teléfono fijo', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::text('home_phone_number', $eco_com_applicant->home_phone_number, ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()', 'data-bind' => 'value: soli_home_phone_number']) !!}
                                        <span class="help-block">Escriba Número Teléfono fijo</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                        {!! Form::label('home_cell_phone_number', 'Teléfono Celular', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::text('home_cell_phone_number', $eco_com_applicant->home_cell_phone_number, ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()', 'data-bind' => 'value: soli_home_cell_phone_number']) !!}
                                        <span class="help-block">Escriba NúmeroTeléfono Celular</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                        {!! Form::label('home_address', 'Domicilio Trabajo', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::text('home_address', $eco_com_applicant->home_address, ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                                        <span class="help-block">Escriba Domicilio de Trabajo</span>
                                    </div>
                                </div>


                            </div>

                        </div>

                        <div class="row text-center">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-raised btn-success" data-toggle="tooltip" data-placement="bottom" data-original-title="Siguiente">&nbsp;<i class="fa fa-arrow-right"></i>&nbsp;</button>
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

        $(document).ready(function(){
            $('.combobox').combobox();
            $('[data-toggle="tooltip"]').tooltip();
        });

    </script>
@endpush
