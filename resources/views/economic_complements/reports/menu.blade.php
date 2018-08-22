@extends('app')
@section('contentheader_title')
    {!! Breadcrumbs::render('report_generator') !!}
@endsection
@section('main-content')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-book"></i> Reportes de Complemento Económico</h3>
            </div>
            {!! Form::open(['url' => 'reports','id'=>'form-table']) !!}
            <div class="panel-body">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('type', 'Reporte', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-10">
                            {!! Form::select('type', $reports_list, null, ['class' => 'combobox form-control','data-bind'=>'value: optionSelected', 'required' ]) !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-3" data-bind="visible: optionSelected()<25?true:false">
                    <div class="form-group">
                        {!! Form::label('year', 'Gestión', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-8">
                            {!! Form::select('year', $years, $current_year, ['class' => 'combobox form-control ', 'required' ]) !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-3" data-bind="visible: optionSelected()<25?true:false">
                    <div class="form-group">
                        {!! Form::label('semester', 'Semestre', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-8">
                            {!! Form::select('semester', $semesters, $current_semester, ['class' => 'combobox form-control ', 'required' ]) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <div class="row text-center">
                    <div class="form-group">
                        <div class="col-md-12">

                            <button type="reset" class="btn btn-raised btn-warning" data-toggle="tooltip" data-placement="bottom" data-original-title="Limpiar">&nbsp;<span class="glyphicon glyphicon-erase"></span>&nbsp;</button>
                            &nbsp;&nbsp;<button type="submit" class="btn btn-raised btn-success" data-toggle="tooltip" data-placement="bottom" data-original-title="Generar">&nbsp;<span class="glyphicon glyphicon-search"></span>&nbsp;</button>
                            <br><br>
                                <div class="togglebutton" data-bind="visible: optionSelected()<17?true:false">
                                    <label>

                                        <input type="checkbox" name="type_doc" data-bind='checked: typeDoc'> <span data-bind="text: typeDoc()?'Pdf':'Excel'"></span>
                                    </label>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<div class="row" id="table-vue">
    <div class="col-md-12">
        <table class="table table-bordered table-hover" id="table-result"></table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.combobox').combobox();
    });
    function SelectorViewModel()
    {
        this.optionSelected = ko.observable();
        this.typeDoc = ko.observable();
    }
    ko.applyBindings(new SelectorViewModel());
</script>
@endpush
