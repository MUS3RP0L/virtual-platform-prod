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
                        <div class="col-md-6">
                            <table class="table table-responsive" style="width:100%;">

                                <tr>
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                Ciudad
                                            </div>
                                            <div class="col-md-6">
                                                {!! $economic_complement->city->name !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
									<td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
										<div class="row">
											<div class="col-md-6">
												Estado
											</div>

                                            <div class="col-md-6">
												{!! $economic_complement->economic_complement_state->economic_complement_state_type->name !!}
											</div>
										</div>
									</td>
								</tr>
                                <tr>
									<td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
										<div class="row">
											<div class="col-md-6">
												Lugar
											</div>
                                            <div class="col-md-6">
												{!! $economic_complement->economic_complement_state->name !!}
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
                    <li><a href="{!! url('economic_complement_reception_first_step/' . $economic_complement->affiliate_id) !!}"><span class="badge">1</span> Tipo de Proceso</a></li>
                    <li><a href="{!! url('economic_complement_reception_second_step/' . $economic_complement->id) !!}"><span class="badge">2</span> Beneficiario</a></li>
                    <li class="active"><a href="#"><span class="badge">3</span> Requisitos</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Seleccionar los Requisitos</h3>
                </div>
                <div class="box-body" data-bind="event: {mouseover: save, mouseout: save}">
                    {!! Form::model($economic_complement, ['method' => 'PATCH', 'route' => ['economic_complement.update', $economic_complement->id], 'class' => 'form-horizontal']) !!}

                        <input type="hidden" name="step" value="third"/>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-hover" style="font-size: 16px">
                                    <thead>
                                        <tr class="success">
                                            <th class="text-center">Requisitos</th>
                                            <th class="text-center">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody data-bind="foreach: requirements">
                                        <tr>
                                            <td data-bind='text: name'></td>
                                            <td>
                                                <div class="row text-center">
                                                    <div class="checkbox">
                                                        <label><input type="checkbox" data-bind='checked: status, valueUpdate: "afterkeydown"'/></label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {!! Form::hidden('data', null, ['data-bind'=> 'value: lastSavedJson']) !!}
                        <br>
                        <div class="row text-center">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <a href="{!! url('economic_complement_reception_second_step/' . $economic_complement->id) !!}" class="btn btn-raised btn-warning" data-toggle="tooltip" data-placement="bottom" data-original-title="Volver">&nbsp;<span class="fa fa-undo"></span>&nbsp;</a>
                                    &nbsp;&nbsp;&nbsp;
                                    <button type="submit" class="btn btn-raised btn-success" data-toggle="tooltip" data-placement="bottom" data-original-title="Guardar">&nbsp;<span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;</button>
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

        function SelectRequeriments(requirements) {

            var self = this;

            @if ($status_documents)
                self.requirements = ko.observableArray(ko.utils.arrayMap(requirements, function(document) {
                return { id: document.eco_com_requirement_id, name: document.economic_complement_requirement.shortened, status: document.status };
                }));
            @else
                self.requirements = ko.observableArray(ko.utils.arrayMap(requirements, function(document) {
                return { id: document.id, name: document.shortened, status: false };
                }));
            @endif

            self.save = function() {
                var dataToSave = $.map(self.requirements(), function(requirement) {
                    return  {
                        id: requirement.id,
                        name: requirement.name,
                        status: requirement.status
                    }
                });
                self.lastSavedJson(JSON.stringify(dataToSave));
            };
            self.lastSavedJson = ko.observable("");

        };

        @if ($status_documents)
            window.model = new SelectRequeriments({!! $eco_com_submitted_documents !!});
        @else
            window.model = new SelectRequeriments({!! $eco_com_requirements !!});
        @endif

        ko.applyBindings(model);

    </script>

@endpush
