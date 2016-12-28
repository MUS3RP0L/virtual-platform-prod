@extends('layout')

@section('content')
<div class="container-fluid">
    {!! Breadcrumbs::render('register_contribution', $affiliate) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4 col-md-offset-6">
                    <div class="btn-group" style="margin:-6px 1px 12px;" data-toggle="tooltip" data-placement="top" data-original-title="Actualizar">
                        <a href="" data-target="#myModal-update" class="btn btn-raised btn-success dropdown-toggle enabled" data-toggle="modal">
                            &nbsp;<span class="glyphicon glyphicon-refresh"></span>&nbsp;
                        </a>
                    </div>
                </div>
                <div class="col-md-2 text-right">
                    <a href="{!! url('select_contribution/' . $affiliate->id) !!}" style="margin:-6px 1px 12px;" class="btn btn-raised btn-warning" data-toggle="tooltip" data-placement="top" data-original-title="Atrás">&nbsp;<span class="glyphicon glyphicon-share-alt"></span>&nbsp;</a>
                </div>
            </div>

            <div class="row">

                @include('affiliates.simple_info')

                <div class="col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="panel-title"><span class="glyphicon glyphicon-list-alt"></span> Información de Aporte</h3>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body" style="font-size: 14px">
                            <div class="row">
                                <div class="col-md-6">

                                    <table class="table table-responsive" style="width:100%;">
                                        <tr>
                                            <td style="border-top:1px solid #d4e4cd;">
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
                                            <td style="border-top:1px solid #d4e4cd;border-bottom:1px solid #d4e4cd;">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        Tipo Aporte
                                                    </div>
                                                    <div class="col-md-6">
                                                        {!! $type !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table" style="width:100%;">
                                        <tr>
                                            <td style="border-top:1px solid #d4e4cd;border-bottom:1px solid #d4e4cd;">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        Total
                                                    </div>
                                                    <div class="col-md-6">

                                                        @if($direct_contribution)
                                                            {!! $direct_contribution->total !!}
                                                        @else
                                                            <span data-bind="text: sum_total()">
                                                        @endif

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

            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="panel-title"><span class="glyphicon glyphicon-list-alt"></span> Cálculo de Aportes</h3>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    {!! Form::open(['method' => 'POST', 'route' => ['direct_contribution.store'], 'class' => 'form-horizontal']) !!}
                        <input type="hidden" name="affiliate_id" value="{{ $affiliate->id }}"/>
                        <input type="hidden" name="year" value="{{ $year }}"/>
                        <input type="hidden" name="type" value="{{ $type }}"/>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-hover">
                                    <thead>
                                        <tr class="success">
                                            <th style="text-align: center" width="6%"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Mes">Mes</div></th>
                                            <th style="text-align: center" width="6%"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Haber Básico">H. Básico</div></th>
                                            <th style="text-align: center" width="6%"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Categoría">Categoría</div></th>
                                            <th style="text-align: center" width="5%"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Antigüedad">Antigüed</div></th>
                                            <th style="text-align: center" width="6%"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Bono Estudio">B Estud</div></th>
                                            <th style="text-align: center" width="6%"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Bono al Cargo">B Cargo</div></th>
                                            <th style="text-align: center" width="6%"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Bono Frontera">B Front</div></th>
                                            <th style="text-align: center" width="6%"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Bono Oriente">B Orien</div></th>
                                            <th style="text-align: right" width="9%"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Cotizable">Cotizable</div></th>
                                            <th style="text-align: right" width="7%"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="% Fondo de Retiro">F.R.</div></th>
                                            <th style="text-align: right" width="7%"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="% Seguro de Vida">S.V.</div></th>
                                            <th style="text-align: right" width="7%"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Subtotal Aporte Muserpol">Aporte</div></th>
                                            <th style="text-align: right" width="7%"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Ajuste IPC">IPC</div></th>
                                            <th style="text-align: right" width="7%"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Total Aporte Muserpol">Total</div></th>
                                            <th width="1%"></th>
                                        </tr>
                                    </thead>
                                    <tbody data-bind="foreach: contributions">
                                        <tr>
                                            <td style="text-align: center"><span data-bind="text: name_month"/></td>
                                            <td style="text-align: center"><input data-bind="value: base_wage, valueUpdate: 'afterkeydown'" style="text-align: right;width: 70px;"/></td>
                                            <td style="text-align: center"><select data-bind="options: $root.categories, value: category, optionsText: 'name'"></select></td>
                                            <td style="text-align: right"><span data-bind="text: seniority_bonus"/></td>
                                            <td style="text-align: center"><input data-bind="value: study_bonus, valueUpdate: 'afterkeydown'" style="text-align: right;width: 70px;"/></td>
                                            <td style="text-align: center"><input data-bind="value: position_bonus, valueUpdate: 'afterkeydown'" style="text-align: right;width: 70px;"/></td>
                                            <td style="text-align: center"><input data-bind="value: border_bonus, valueUpdate: 'afterkeydown'" style="text-align: right;width: 70px;"/></td>
                                            <td style="text-align: center"><input data-bind="value: east_bonus, valueUpdate: 'afterkeydown'" style="text-align: right;width: 70px;"/></td>
                                            <td style="text-align: right"><span data-bind="text: quotable"/></td>
                                            <td style="text-align: right"><span data-bind="text: subtotal_retirement_fund"/></td>
                                            <td style="text-align: right"><span data-bind="text: subtotal_mortuary_quota"/></td>
                                            <td style="text-align: right"><span data-bind="text: subtotal"/></td>
                                            <td style="text-align: right"><span data-bind="text: subtotal_ipc_rate"/></td>
                                            <td style="text-align: right"><span data-bind="text: total"/></td>
                                            <td style="text-align: center"><a href="#" data-bind="click: $root.removeContribution, visible: $parent.contributions().length > 1"><span class="glyphicon glyphicon-remove"></span></a></td>
                                        </tr>
                                    </tbody>
                                    <tr class="active">
                                        <th style="text-align: center"><span data-bind="text: contributions().length"></span></th>
                                        <th colspan="8" style="text-align: right;"><span data-bind="text: sum_quotable()"></span></th>
                                        <th style="text-align: right;"><span data-bind="text: sum_subtotal_retirement_fund()"></span></th>
                                        <th style="text-align: right;"><span data-bind="text: sum_subtotal_mortuary_quota()"></span></th>
                                        <th style="text-align: right;"><span data-bind="text: sum_subtotal()"></span></th>
                                        <th style="text-align: right;"><span data-bind="text: sum_subtotal_ipc_rate()"></span></th>
                                        <th style="text-align: right;"><span data-bind="text: sum_total()"></span></th>
                                        <th></th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        {!! Form::hidden('data', null, ['data-bind'=> 'value: ko.toJSON(model)']) !!}
                            <div class="row text-center">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <a href="{!! url('affiliate/' . $affiliate->id) !!}" data-target="#" class="btn btn-raised btn-warning">&nbsp;<span class="glyphicon glyphicon-remove"></span>&nbsp;</a>
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <div class="btn-group" data-toggle="tooltip" data-placement="bottom" data-original-title="Confirmar">
                                            <a href="" data-target="#myModal-confirm" class="btn btn-raised btn-success dropdown-toggle enabled" data-toggle="modal">
                                                &nbsp;<span class="glyphicon glyphicon-ok"></span>&nbsp;
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="myModal-confirm" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="alert alert-dismissible alert-info">
                                        <div class="modal-body text-center">
                                            <p><br>
                                                <div><h4>¿ Está seguro de guardar el Aporte de Bs. <b><span data-bind="text: sum_total()"></span></b> al afiliado {!! $affiliate->getTittleName () !!}?</h4></div>
                                            </p>
                                        </div>
                                        <div class="row text-center">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <button type="button" class="btn btn-raised btn-default" data-dismiss="modal">&nbsp;<span class="glyphicon glyphicon-remove"></span>&nbsp;</button>
                                                    &nbsp;&nbsp;&nbsp;
                                                    <button type="submit" class="btn btn-raised btn-default" data-toggle="tooltip" data-placement="bottom" data-original-title="Guardar">&nbsp;<span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

<div id="myModal-update" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Actualizar</h4>
            </div>
            <div class="modal-body">

                {!! Form::open(['url' => 'calculation_contribution', 'role' => 'form', 'class' => 'form-horizontal']) !!}
                    <input type="hidden" name="affiliate_id" value="{{ $affiliate->id }}"/>
                    <input type="hidden" name="year" value="{{ $year }}"/>
                    <input type="hidden" name="type" value="{{ $type }}"/>
                    <input type="hidden" name="last_contribution_date" value="{{ $last_contribution->date }}"/>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('base_wage', 'Haber Básico', ['class' => 'col-md-5 control-label']) !!}
                                <div class="col-md-4">
                                    {!! Form::text('base_wage', $last_contribution->base_wage, ['class'=> 'form-control', 'required']) !!}
                                    <span class="help-block">Escriba el Haber Básico</span>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('study_bonus', 'Bono Estudio', ['class' => 'col-md-5 control-label']) !!}
                                <div class="col-md-4">
                                    {!! Form::text('study_bonus', $last_contribution->study_bonus, ['class'=> 'form-control', 'required']) !!}
                                    <span class="help-block">Escriba el Bono Estudio</span>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('border_bonus', 'Bono Frontera', ['class' => 'col-md-5 control-label']) !!}
                                <div class="col-md-4">
                                    {!! Form::text('border_bonus', $last_contribution->border_bonus, ['class'=> 'form-control']) !!}
                                    <span class="help-block">Escriba el Bono Frontera</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('category_id', 'Categoría', ['class' => 'col-md-5 control-label']) !!}
                                <div class="col-md-5">
                                    {!! Form::select('category_id', $list_categories, $affiliate->category_id, ['class' => 'combobox form-control', 'required']) !!}
                                    <span class="help-block">Seleccione Departamento</span>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('position_bonus', 'Bono al Cargo', ['class' => 'col-md-5 control-label']) !!}
                                <div class="col-md-4">
                                    {!! Form::text('position_bonus', $last_contribution->position_bonus, ['class'=> 'form-control', 'required']) !!}
                                    <span class="help-block">Escriba el Bono al Cargo</span>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('east_bonus', 'Bono Oriente', ['class' => 'col-md-5 control-label']) !!}
                                <div class="col-md-4">
                                    {!! Form::text('east_bonus', $last_contribution->east_bonus, ['class'=> 'form-control', 'required']) !!}
                                    <span class="help-block">Escriba el Bono Oriente</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row text-center">
                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-raised btn-success" data-toggle="tooltip" data-placement="bottom" data-original-title="Guardar">&nbsp;<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>&nbsp;</button>
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

    $(document).ready(function(){
        $('.combobox').combobox();
        $('[data-toggle="tooltip"]').tooltip();
    });

    var affiliate = {!! $affiliate !!};
    var months = {!! $months !!};
    var categories = {!! $categories !!};
    var ipc_actual = {!! $ipc_actual !!};

    function CalculationContribution(id_month, name_month, base_wage, categories, study_bonus, position_bonus,  border_bonus, east_bonus, retirement_fund, mortuary_quota, ipc_rate) {
        var self = this;
        self.id_month = id_month;
        self.name_month = name_month;
        self.base_wage = ko.observable(base_wage);
        self.category = ko.observable(categories);
        self.seniority_bonus = ko.computed(function() {
            var seniority_bonus = roundToTwo(parseFloat(self.category().percentage) * parseFloat(self.base_wage()));
            return seniority_bonus ? seniority_bonus : 0;
        });
        self.study_bonus = ko.observable(study_bonus);
        self.position_bonus = ko.observable(position_bonus);
        self.border_bonus = ko.observable(border_bonus);
        self.east_bonus = ko.observable(east_bonus);

        self.quotable = ko.computed(function() {
            var quotable = roundToTwo(parseFloat(self.base_wage()) + parseFloat(self.seniority_bonus()) +
                        parseFloat(self.study_bonus()) + parseFloat(self.position_bonus()) +
                        parseFloat(self.border_bonus()) + parseFloat(self.east_bonus()));
            return quotable ? quotable : 0;
        });

        self.subtotal_retirement_fund = ko.computed(function() {
            var subtotal_retirement_fund = roundToTwo(parseFloat(self.quotable()) * parseFloat(retirement_fund) / 100);
            return subtotal_retirement_fund ? subtotal_retirement_fund : 0;
        });

        self.subtotal_mortuary_quota = ko.computed(function() {
            var subtotal_mortuary_quota = roundToTwo(parseFloat(self.quotable()) * parseFloat(mortuary_quota) / 100);
            return subtotal_mortuary_quota ? subtotal_mortuary_quota : 0;
        });

        self.subtotal = ko.computed(function() {
            var subtotal = roundToTwo(parseFloat(self.subtotal_retirement_fund()) + parseFloat(self.subtotal_mortuary_quota()));
            return subtotal ? subtotal : 0;
        });

        self.subtotal_ipc_rate = ko.computed(function() {
            var subtotal_ipc_rate = roundToTwo(parseFloat(self.subtotal()) * ((parseFloat(ipc_actual.index))/(parseFloat(ipc_rate))-1));
            if (subtotal_ipc_rate < 0) { subtotal_ipc_rate = 0; };
            return subtotal_ipc_rate ? subtotal_ipc_rate : 0;
        });

        self.total = ko.computed(function() {
            var total = roundToTwo(parseFloat(self.subtotal()) + parseFloat(self.subtotal_ipc_rate()));
            return total ? total : 0;
        });
    }

    function CalculationContributionModel(months, last_contribution) {

        var self = this;
        self.categories = categories;
        self.contributions = ko.observableArray(ko.utils.arrayMap(months, function(month) {
            return new CalculationContribution(month.id, month.name, last_contribution.base_wage ? last_contribution.base_wage : "",
            categories[affiliate.category_id-1], last_contribution.study_bonus ? last_contribution.study_bonus : 0,
                last_contribution.position_bonus ? last_contribution.position_bonus : 0, last_contribution.border_bonus ? last_contribution.border_bonus : 0,
                last_contribution.east_bonus ? last_contribution.east_bonus : 0, month.retirement_fund, month.mortuary_quota, month.ipc_rate);
        }));

        self.sum_quotable = ko.pureComputed(function() {
            var sum = 0;
            $.each(self.contributions(), function() { sum += parseFloat(this.quotable()) })
            return roundToTwo(sum);
        });

        self.sum_subtotal_retirement_fund = ko.pureComputed(function() {
            var sum = 0;
            $.each(self.contributions(), function() { sum += parseFloat(this.subtotal_retirement_fund()) })
            return roundToTwo(sum);
        });

        self.sum_subtotal_mortuary_quota = ko.pureComputed(function() {
            var sum = 0;
            $.each(self.contributions(), function() { sum += parseFloat(this.subtotal_mortuary_quota()) })
            return roundToTwo(sum);
        });

        self.sum_subtotal = ko.pureComputed(function() {
            var sum = 0;
            $.each(self.contributions(), function() { sum += parseFloat(this.subtotal()) })
            return roundToTwo(sum);
        });

        self.sum_subtotal_ipc_rate = ko.pureComputed(function() {
            var sum = 0;
            $.each(self.contributions(), function() { sum += parseFloat(this.subtotal_ipc_rate()) })
            return roundToTwo(sum);
        });

        self.sum_total = ko.pureComputed(function() {
            var sum = 0;
            $.each(self.contributions(), function() { sum += parseFloat(this.total()) })
            return roundToTwo(sum);
        });

        self.removeContribution = function(contribution) { self.contributions.remove(contribution) }
    }

    window.model = new CalculationContributionModel({!! $months !!}, {!! $last_contribution !!});
    ko.applyBindings(model);

    function roundToTwo(num) {
        var val = +(Math.round(num + "e+2")  + "e-2");
        return num ? parseFloat(Math.round(parseFloat(val) * 100) / 100).toFixed(2) : 0;
    }

</script>
@endpush
