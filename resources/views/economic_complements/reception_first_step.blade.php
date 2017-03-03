@extends('app')

@section('contentheader_title')

    <div class="row">
        <div class="col-md-10">
			{!! Breadcrumbs::render('create_economic_complement') !!}
        </div>
        <div class="col-md-2 text-right">
            <a href="{!! url('affiliate/' . $affiliate->id) !!}" class="btn btn-raised btn-warning" data-toggle="tooltip" data-placement="top" data-original-title="Cancelar">
                &nbsp;<span class="glyphicon glyphicon-remove"></span>&nbsp;
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
            @include('economic_complements.additional.general_info')
        </div>
    </div>

    <div class="row text-center">
        <div class="col-md-12">
            <div class="form-group">
                <ul class="nav nav-pills" style="display:flex;justify-content:center;">
                    <li class="active"><a href="#"><span class="badge">1</span> Tipo de Proceso</a></li>
                    <li><a href="#"><span class="badge">2</span> Beneficiario</a></li>
                    <li><a href="#"><span class="badge">3</span> Requisitos</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box box-warning box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Selecciones el Tipo de Proceso</h3>
                </div>
                <div class="box-body">
                    {!! Form::model($economic_complement, ['method' => 'POST', 'route' => ['economic_complement.store'], 'class' => 'form-horizontal']) !!}
                        <br>
                        <input type="hidden" name="step" value="first"/>
                        <input type="hidden" name="affiliate_id" value="{{ $affiliate->id }}"/>
                        <div class="row">
                            <div class="col-md-3 col-md-offset-1">
                                <div class="form-group">
                                    <div class="radio radio-primary">
                                        <label style="font-size: 18px">
                                            {!! Form::radio('eco_com_type', '1', ($eco_com_type == '1'), ['required' => 'required']) !!} Vejez
                                        </label>
                                    </div><br>
                                    <div class="radio radio-primary">
                                        <label style="font-size: 18px">
                                            {!! Form::radio('eco_com_type', '2', ($eco_com_type == '2')) !!} Viudedad
                                        </label>
                                    </div><br>
                                    <div class="radio radio-primary">
                                        <label style="font-size: 18px">
                                            {!! Form::radio('eco_com_type', '3', ($eco_com_type == '3')) !!} Orfandad
                                        </label>
                                    </div><br>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('pension_entity', 'Ente Gestor', ['class' => 'col-md-4 control-label']) !!}
                                    <div class="col-md-8">
                                        {!! Form::select('pension_entity', $pension_entities_list, $affiliate->pension_entity_id, ['class' => 'combobox form-control', 'required' ]) !!}
                                        <span class="help-block">Seleccione el departamento</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('city', 'Ciudad', ['class' => 'col-md-4 control-label']) !!}
                                    <div class="col-md-8">
                                        {!! Form::select('city', $cities_list, $economic_complement->city_id, ['class' => 'combobox form-control', 'required' ]) !!}
                                        <span class="help-block">Seleccione el departamento</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="col-md-8 col-md-offset-3">
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('legal_guardian', true, $economic_complement->has_legal_guardian) !!} &nbsp;&nbsp; Apoderado
                                            </label>
                                        </div>
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
