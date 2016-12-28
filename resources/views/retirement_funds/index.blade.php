@extends('layout')

@section('content')
<div class="container-fluid">
    {!! Breadcrumbs::render('retirement_funds') !!}
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Despliegue</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form method="POST" id="search-form" role="form">
                                <div class="row"><br>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {!! Form::label('code', 'Número Trámite', ['class' => 'col-md-5 control-label']) !!}
                                            <div class="col-md-7">
                                                {!! Form::text('code', '', ['class'=> 'form-control']) !!}
                                                <span class="help-block">Escriba el Número Trámite</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                                {!! Form::label('creation_date', 'Fecha de Emisión', ['class' => 'col-md-5 control-label']) !!}
                                            <div class="col-md-7">
                                    			<div class="input-group">
                                                    <input type="text" class="form-control datepicker" name="creation_date" value="">
                                                    <div class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                                {!! Form::label('payment_date', 'Fecha de Pago', ['class' => 'col-md-5 control-label']) !!}
                                            <div class="col-md-7">
                                    			<div class="input-group">
                                                    <input type="text" class="form-control datepicker" name="payment_date" value="">
                                                    <div class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row"><br>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                                {!! Form::label('voucher_type', 'Concepto', ['class' => 'col-md-4 control-label']) !!}
                                            <div class="col-md-7">
                                                {!! Form::select('voucher_type', $retirement_fund_modality_list, '', ['class' => 'combobox form-control']) !!}
                                                <span class="help-block">Seleccione el Concepto</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row text-center">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <button type="reset" class="btn btn-raised btn-warning" data-toggle="tooltip" data-placement="bottom" data-original-title="Limpiar">&nbsp;<span class="glyphicon glyphicon-erase"></span>&nbsp;</button>
                                            &nbsp;&nbsp;<button type="submit" class="btn btn-raised btn-success" data-toggle="tooltip" data-placement="bottom" data-original-title="Buscar">&nbsp;<span class="glyphicon glyphicon-search"></span>&nbsp;</button>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped table-hover" id="vouchers-table">
                                <thead>
                                    <tr class="success">
                                        <th class="text-center"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Número de Trámite">Número</div></th>
                                        <th class="text-left"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Nombre de Afiliado">Nombre de Afiliado</div></th>
                                        <th class="text-left"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Total a Pagar">Total a Pagar</div></th>
                                        <th class="text-center">Acción</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
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

    $('.datepicker').datepicker({
        format: "dd/mm/yyyy",
        language: "es",
        orientation: "bottom right",
        daysOfWeekDisabled: "0,6",
        autoclose: true
    });

    var oTable = $('#vouchers-table').DataTable({
        "dom": '<"top">t<"bottom"p>',
        processing: true,
        serverSide: true,
        pageLength: 8,
        order: [0, "desc"],
        ajax: {
            url: '{!! route('get_retirement_fund') !!}',
            data: function (d) {
                d.code = $('input[name=code]').val();
                d.affiliate_name = $('input[name=affiliate_name]').val();
                d.creation_date = $('input[name=creation_date]').val();
                d.voucher_type = $('input[name=voucher_type]').val();
                d.payment_date = $('input[name=payment_date]').val();
                d.post = $('input[name=post]').val();
            }
        },
        columns: [
            { data: 'code', sClass: "text-center" },
            { data: 'affiliate_name', bSortable: false },
            { data: 'total', bSortable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false, bSortable: false, sClass: "text-center" }
        ]
    });

    $('#search-form').on('submit', function(e) {
        oTable.draw();
        e.preventDefault();
    });

</script>
@endpush
