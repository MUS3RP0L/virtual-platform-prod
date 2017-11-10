@extends('app')

@section('contentheader_title')

    <div class="row">
        <div class="col-md-10">
			{!! Breadcrumbs::render('create_economic_complement', $affiliate) !!}
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
        <div class="col-md-12">
            @include('affiliates.affiliate_and_eco_info')
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
        <div class="col-md-12">
            <div class="box box-warning box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Seleccione el Tipo de Proceso</h3>
                </div>
                <div class="box-body">
                    {!! Form::model($economic_complement, ['method' => 'POST', 'route' => ['economic_complement.store'], 'class' => 'form-horizontal']) !!}
                        <br>
                        <input type="hidden" name="step" value="first"/>
                        <input type="hidden" name="affiliate_id" value="{{ $affiliate->id }}"/>
                        <div class="row">
                            <div class="col-md-3 col-md-offset-1">
                                <div class="form-group">
                                    @if($eco_com_modality_type_id)
                                    <div class="radio radio-primary">
                                        <label style="font-size: 18px">
                                            {!! Form::radio('eco_com_type', '1', ($eco_com_modality_type_id == '1'), ['required' => 'required']) !!} Vejez
                                            {{-- {!! Form::radio('eco_com_type', '1', ($eco_com_modality_type_id == '1'), ['required' => 'required', (($eco_com_modality_type_id == 2 || $eco_com_modality_type_id == 3) ? 'disabled':'' )]) !!} Vejez --}}
                                            
                                        </label>
                                    </div><br>
                                    <div class="radio radio-primary">
                                        <label style="font-size: 18px">
                                            {!! Form::radio('eco_com_type', '2', ($eco_com_modality_type_id == '2'), []) !!} Viudedad
                                            {{-- {!! Form::radio('eco_com_type', '2', ($eco_com_modality_type_id == '2'), [($eco_com_modality_type_id == 3) ? 'disabled':'' ]) !!} Viudedad --}}
                                        </label>
                                    </div><br>
                                    <div class="radio radio-primary">
                                        <label style="font-size: 18px">
                                            {!! Form::radio('eco_com_type', '3', ($eco_com_modality_type_id == '3'))  !!} Orfandad
                                        </label>
                                    </div>
                                    @else
                                        <div class="radio radio-primary">
                                            <label style="font-size: 18px">
                                                {{-- {!! Form::radio('eco_com_type', '1', (($last_complement->economic_complement_modality->economic_complement_type->id ?? 0) == '1'), ['required' => 'required']) !!} Vejez --}}
                                                {!! Form::radio('eco_com_type', '1', (($last_complement->economic_complement_modality->economic_complement_type->id ?? 0) == '1'), ['required' => 'required', ((($last_complement->economic_complement_modality->economic_complement_type->id ?? 0) == 2 || ($last_complement->economic_complement_modality->economic_complement_type->id ?? 0) == 3) ? 'disabled':'' )]) !!} Vejez
                                                
                                            </label>
                                        </div><br>
                                        <div class="radio radio-primary">
                                            <label style="font-size: 18px">
                                                {{-- {!! Form::radio('eco_com_type', '2', (($last_complement->economic_complement_modality->economic_complement_type->id ?? 0) == '2'), []) !!} Viudedad --}}
                                                {!! Form::radio('eco_com_type', '2', (($last_complement->economic_complement_modality->economic_complement_type->id ?? 0) == '2'), [(($last_complement->economic_complement_modality->economic_complement_type->id ?? 0 ) == 3) ? 'disabled':'' ]) !!} Viudedad
                                            </label>
                                        </div><br>
                                        <div class="radio radio-primary">
                                            <label style="font-size: 18px">
                                                {!! Form::radio('eco_com_type', '3', (($last_complement->economic_complement_modality->economic_complement_type->id ?? 0) == '3'))  !!} Orfandad
                                            </label>
                                        </div>
                                    @endif

                                    <br>
                                    <hr>
                                    <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('legal_guardian', true, $economic_complement->has_legal_guardian) !!} &nbsp;&nbsp; Apoderado
                                            </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('reception_type', 'Tipo de Recepción', ['class' => 'col-md-4 control-label']) !!}
                                    <div class="col-md-8">
                                        {!! Form::select('reception_type',  $reception_types, $economic_complement->reception_type ?? $eco_com_reception_type , ['class' => 'form-control', 'required', 'id'=>'reception_type' ]) !!}
                                        <span class="help-block">Seleccione el tipo de recepción</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('semester', 'Semestre:', ['class' => 'col-md-4 control-label']) !!}
                                    <div class="col-md-8">
                                        {!! Form::select('semester',  $semesters, $economic_complement->semester ?? null , ['class' => 'form-control combobox', 'required' ]) !!}
                                        <span class="help-block">Seleccione el semestre</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('pension_entity', 'Ente Gestor', ['class' => 'col-md-4 control-label']) !!}
                                    <div class="col-md-8">

                                        {!! Form::select('pension_entity', $pension_entities_list, $affiliate->pension_entity_id, ['class' => 'combobox form-control', 'required' , 'data-bind' => 'value: enteSelected' ]) !!}
                                        <span class="help-block">Seleccione el ente gestor</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('city', 'Ciudad', ['class' => 'col-md-4 control-label']) !!}
                                    <div class="col-md-8">
                                        {!! Form::select('city', $cities_list, $economic_complement->city_id ?? $last_complement->city_id ?? null, ['class' => 'combobox form-control', 'required' ]) !!}
                                        <span class="help-block">Seleccione el departamento</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                @if(isset($last_complement->aps_disability))
                                    @if($last_complement->aps_disability > 0)
                                    <div class="col-md-12">
                                        <div class="callout callout-danger">
                                            <strong>Concurrencia - Prestación por Invalidéz:</strong> {{ Util::formatMoney($last_complement->aps_disability) }}
                                        </div>
                                    </div>
                                    @endif
                                @endif
                                <div data-bind="visible: isApsVisible">
                                    
                                    <div class="form-group">
                                        <div class="col-md-8">
                                            {!! Form::label('aps_total_fsa_label', 'Fracción de Saldo Acumulado', []) !!}
                                            <input type="number" step="0.01" name="aps_total_fsa" class="form-control" data-bind="value: fsa">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-8">
                                            {!! Form::label('aps_total_cc_label', 'Fracción de Cotización', []) !!}
                                            <input type="number" step="0.01" name="aps_total_cc" class="form-control " data-bind="value: cc ,valueAllowUnset:0 ">
                                        </div>
                                    </div>

                                    <div class="form-group">

                                        <div class="col-md-8">
                                            {!! Form::label('aps_total_fs_label', 'Fracción Solidaria', []) !!}

                                            <input type="number"  step="0.01" name="aps_total_fs" class="form-control" data-bind="value: fs">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                         <div class="col-md-8">
                                         <strong data-bind="text: total"> </strong>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                         <div class="col-md-8">

                                            
                                            
                                             <div class="callout callout-warning">
                                                <strong>Renta Boleta: {{$economic_complement->total_rent}} </strong>
                                             </div>
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
            $('input:radio').change(function () {
            	var modality_id = $(this).val();
            	$.ajax({
            		url: '/get_reception_type',
            		type: 'GET',
            		data: {
            			modality_id: modality_id,
            			affiliate_id: {{ $affiliate->id }}
            		}
            	})
            	.done(function(data) {
            		$('#reception_type').val(data.modality_name);
            	})
            })

            function APS()
            {

                self = this;
                self.cc = ko.observable({{$economic_complement->aps_total_cc}});
                self.fsa = ko.observable({{$economic_complement->aps_total_fsa}});
                self.fs = ko.observable({{$economic_complement->aps_total_fs}});

                self.enteSelected = ko.observable({{$affiliate->pension_entity_id}});
                self.isApsVisible = ko.observable(true);
                self.enteSelected.subscribe(function(id_value){

                    if(id_value == '5')
                    {
                        self.isApsVisible(false);
                    }else{
                        self.isApsVisible(true);
                    }
                    console.log("id "+id_value+" "+self.isApsVisible());
                    

                });
                // console.log('cc= '+self.cc());
                // console.log('fsa= '+self.fsa());
                // console.log('fs= '+self.fs());
                self.total = ko.computed(function(){



                        if(isNaN(self.cc()) || self.cc() =='' )
                        {
                            self.cc(0);
                        }
                        if(isNaN(self.fsa()) || self.fsa() =='' )
                        {
                            self.fsa(0);
                        }
                        if(isNaN(self.fs()) || self.fs() =='' )
                        {
                            self.fs(0);
                        }

                    return "Total: "+(parseFloat(self.cc()) + parseFloat(self.fsa()) + parseFloat(self.fs())).toFixed(2);

                });

                console.log(self.total());
            }

             ko.applyBindings(APS());


        });

    </script>   
@endpush
