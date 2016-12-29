@extends('app')

@section('contentheader_title')

	<div class="row">
		<div class="col-md-10">
			{!! Breadcrumbs::render('show_direct_contribution', $affiliate) !!}
		</div>
		<div class="col-md-2 text-right">
            <a href="{!! url('direct_contribution') !!}" class="btn btn-raised btn-warning" data-toggle="tooltip" data-placement="top" data-original-title="Atrás">
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
                <div class="box-body" style="font-size: 14px">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-responsive" style="width:100%;">
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
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
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

    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Despliegue</h3>
                </div>
                <div class="box-body">
                    <iframe src="{!! url('print_direct_contribution/' . $direct_contribution->id) !!}" width="100%" height="1200"></iframe>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>

</script>
@endpush
