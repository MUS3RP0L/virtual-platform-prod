@extends('app')

@section('contentheader_title')

	<div class="row">
		<div class="col-md-10">
			{!! Breadcrumbs::render('show_economic_complement', $economic_complement) !!}
		</div>
		<div class="col-md-2 text-right">
			<a href="{!! url('economic_complement') !!}" class="btn btn-raised btn-warning" data-toggle="tooltip" data-placement="top" data-original-title="Atrás">
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
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>

    <div class="row">
        <div class="col-md-6">
			<div class="box box-warning">
                <div class="box-header with-border">
					<h3 class="box-title"> </h3>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="col-md-12">

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
	    $('[data-toggle="tooltip"]').tooltip();
	});

</script>
@endpush
