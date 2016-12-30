@extends('app')

@section('contentheader_title')

	<div class="row">
		<div class="col-md-6">
			{!! Breadcrumbs::render('show_contribution', $affiliate) !!}
		</div>
        <div class="col-md-4">
            @if($voucher->payment_date)
                <div class="btn-group" data-toggle="tooltip" data-placement="bottom" data-original-title="Imprimir" style="margin:0px;">
                    <a href="" class="btn btn-raised btn-success dropdown-toggle enabled" data-toggle="modal" value="Print" onclick="printTrigger('iFramePdf');" >
                        &nbsp;<span class="glyphicon glyphicon-print"></span>&nbsp;
                    </a>
                </div>
            @endif
        </div>
		<div class="col-md-2 text-right">

			<a href="{!! url('voucher') !!}" class="btn btn-raised btn-warning" data-toggle="tooltip" data-placement="top" data-original-title="Atrás">
				&nbsp;<span class="glyphicon glyphicon-share-alt"></span>&nbsp;
			</a>
		</div>
	</div>

@endsection

@section('main-content')

    <div class="row">
        <div class="col-md-6">
            @include('affiliates.simple_info')
            <div class="box box-info">
				<div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="box-title"><span class="glyphicon glyphicon-list-alt"></span> Información de Cobro</h3>
                        </div>
                    </div>
                </div>
                <div class="box-body" style="font-size: 14px">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-responsive" style="width:100%;">
                                <tr>
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-5">
                                                Concepto
                                            </div>
                                            <div class="col-md-7">
                                                {!! $voucher->voucher_type->name !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-5">
                                                Total Bs
                                            </div>
                                            <div class="col-md-7">
                                                {!! $voucher->total !!}
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
                                                Fecha Emisión
                                            </div>
                                            <div class="col-md-6">
                                                {!! $voucher->getCreationDate() !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                            Fecha de Pago
                                            </div>
                                            <div class="col-md-6">
                                                @if($voucher->payment_date)
                                                    {!! $voucher->payment_date !!}
                                                @else
                                                    -
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

        <div class="col-md-6">

            <div class="box box-info">
				<div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="box-title"><span class="glyphicon glyphicon-list-alt"></span> Información de Cobro</h3>
                        </div>
                    </div>
                </div>
                <div class="box-body" style="font-size: 14px">

                    @if($voucher->payment_date)
                        <div class="row">
                            <div class="col-md-12">
                                <iframe src="{!! url('print_voucher/' . $voucher->id) !!}" width="100%" height="700" id="iFramePdf"></iframe>
                            </div>
                        </div>
                    @else
                        {!! Form::model($voucher, ['method' => 'PATCH', 'route' => ['voucher.update', $voucher->id], 'class' => 'form-horizontal']) !!}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('Total', 'Total', ['class' => 'col-md-5 control-label']) !!}
                                        <div class="col-md-6">
                                            <h3>{!! $voucher->total_show !!}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('received', 'Recibido', ['class' => 'col-md-5 control-label']) !!}
                                        <div class="col-md-3">
                                            <input data-bind="value: received, valueUpdate: 'afterkeydown'" class="form-control" style="font-size:24px;" required=""/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('Cambio', 'Cambio', ['class' => 'col-md-5 control-label']) !!}
                                        <div class="col-md-6">
                                            <h3><span data-bind="text: change()"></span></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {!! Form::hidden('data', null, ['data-bind'=> 'value: ko.toJSON(model)']) !!}
                            <div class="row text-center">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <button type="submit" data-bind='enable: hasClickedTooManyTimes' class="btn btn-raised btn-success" data-toggle="tooltip" data-placement="bottom" data-original-title="Guardar">&nbsp;<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>&nbsp;</button>
                                    </div>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>

        function printTrigger(elementId) {
            var getMyFrame = document.getElementById(elementId);
            getMyFrame.focus();
            getMyFrame.contentWindow.print();
        }

        function CalculationChange(voucher) {

            var self = this;

            self.received = ko.observable();
            self.change = ko.computed(function() {
                var rest = -1;
                if (self.received()) {
                    rest = roundToTwo(parseFloat(self.received()) - parseFloat(voucher.total));
                }
                if (rest < 0) {
                    rest = '-';
                }
                return rest;
            });

            this.hasClickedTooManyTimes = ko.pureComputed(function() {

                if (self.change() == '-') {
                    return false;
                }
                return true;
            }, this);

        }
        window.model = new CalculationChange({!! $voucher !!});
        ko.applyBindings(model);

        function roundToTwo(num) {
            var val = +(Math.round(num + "e+2")  + "e-2");
            return num ? parseFloat(Math.round(parseFloat(val) * 100) / 100).toFixed(2) : 0;
        }

    </script>
@endpush
