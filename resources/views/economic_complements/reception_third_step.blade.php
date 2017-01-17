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
                    <li><a href="#"><span class="badge">2</span> Beneficiario</a></li>
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
                <div class="box-body">
                    {!! Form::model($economic_complement, ['method' => 'PATCH', 'route' => ['economic_complement.update', $affiliate->id], 'class' => 'form-horizontal']) !!}
                        <br>
                        <input type="hidden" name="step" value="third"/>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-hover" style="font-size: 16px">
                                    <thead>
                                        <tr>
                                            <th>Requisitos</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody data-bind="foreach: requirement">
                                        <tr>
                                            <td data-bind='text: requiname'></td>
                                            <td>
                                                <div class="row text-center">
                                                    <div class="checkbox">
                                                        <label><input type="checkbox" data-bind="checked: booleanValue"></label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <input type="hidden" name="data" data-bind="value: lastSavedJson"/>

                        <div class="row text-center">
                            <div class="form-group">
                                <div class="col-md-12">
                                    &nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-raised btn-primary">&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;&nbsp;&nbsp;</button>
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

        var Model = function(requirement) {

            this.requirement = ko.observableArray(ko.utils.arrayMap(requirement, function(document) {
            return { requirement_id: document.id, requiname: document.name, booleanValue: false };
            }));

            this.enableDetails = function() {
                this.lastSavedJson(JSON.stringify(ko.toJS(this.requirement), null, 2));
            };
            this.disableDetails = function() {
                this.lastSavedJson(JSON.stringify(ko.toJS(this.requirement), null, 2));
            };
            this.lastSavedJson = ko.observable("");

        };

        ko.bindingHandlers.fadeVisible = {
            init: function(element, valueAccessor) {
                var value = valueAccessor();
                $(element).toggle(ko.unwrap(value));
            },
            update: function(element, valueAccessor) {
                var value = valueAccessor();
                ko.unwrap(value) ? $(element).fadeIn() : $(element).fadeOut();
            }
        };

        ko.applyBindings(new Model({!! $eco_com_requirements !!}));

    </script>

@endpush
