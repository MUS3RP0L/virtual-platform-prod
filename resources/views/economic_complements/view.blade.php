@extends('app')

@section('contentheader_title')

	<div class="row">
		<div class="col-md-6">
			{!! Breadcrumbs::render('show_economic_complement', $economic_complement) !!}
		</div>
		<div class="col-md-2">
	        <div class="btn-group" data-toggle="tooltip" data-placement="top" data-original-title="Imprimir Declaración Jurada" style="margin:0px;">
	            <a href="" class="btn btn-raised btn-success dropdown-toggle enabled" data-toggle="modal" value="Print" onclick="printTrigger('iFramePdf');" >
	                &nbsp;<span class="glyphicon glyphicon-print"></span>&nbsp;
	            </a>
	        </div>
		</div>
        <div class="col-md-2">
            <div class="btn-group" data-toggle="tooltip" data-placement="top" data-original-title="Imprimir Reporte Recepción" style="margin:0px;">
                <a href="" class="btn btn-raised btn-success dropdown-toggle enabled" data-toggle="modal" value="Print" onclick="printTrigger('iFramePdfReport');" >
                    &nbsp;<span class="glyphicon glyphicon-list-alt"></span>&nbsp;
                </a>
            </div>
        </div>
		@can('eco_com_review')
			@if($economic_complement->eco_com_state_id < 2)
				<div class="col-md-2 text-right">
			        <div class="btn-group" data-toggle="tooltip" data-placement="top" data-original-title="Confirmar" style="margin:0px;">
		                <a href="" data-target="#myModal-confirm" class="btn btn-raised btn-warning dropdown-toggle enabled" data-toggle="modal">
		                    &nbsp;<span class="glyphicon glyphicon-ok"></span>&nbsp;
		                </a>
		            </div>
				</div>
			@endif
		@endcan
	</div>

@endsection

@section('main-content')

    <div class="row">
        <div class="col-md-6">
            @include('affiliates.simple_info')
        </div>
        <div class="col-md-6">
            <div class="box box-success box-solid">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="box-title"><span class="glyphicon glyphicon-info-sign"></span> Información Adicional</h3>
                        </div>
                        <div class="col-md-2 text-right">
                            <div data-toggle="tooltip" data-placement="top" data-original-title="Editar">
                                <a href="" class="btn btn-sm bg-olive" data-toggle="modal" data-target="#myModal-edit">&nbsp;&nbsp;
                                    <span class="fa fa-lg fa-pencil" aria-hidden="true"></span>&nbsp;&nbsp;
                                </a>
                            </div>
                        </div>
                        <div class="col-md-2 text-right">
                            <div data-toggle="tooltip" data-placement="top" data-original-title="Editar">
                                <a href="" class="btn btn-sm bg-olive" data-toggle="modal" data-target="#myModal-block">&nbsp;&nbsp;
                                    <span class="fa fa-lg fa-exclamation-triangle" aria-hidden="true"></span>&nbsp;&nbsp;
                                </a>
                            </div>
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
                                                <strong>Semestre</strong>
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
                                                <strong>Gestión</strong>
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
                                                <strong>Tipo</strong>
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
                                                <strong>Ciudad</strong>
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
                                                <strong>Estado</strong>
                                            </div>
                                            <div class="col-md-6">
                                                {{-- {!! $economic_complement->economic_complement_state->economic_complement_state_type->name !!} --}}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Por</strong>
                                            </div>
                                            <div class="col-md-6">
                                                {{-- {!! $economic_complement->economic_complement_state->name !!} --}}
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
            <div class="box box-success box-solid">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-10">
                            <h3 class="box-title"><span class="fa fa-user-plus"></span> Información de Beneficiario</h3>
                        </div>
                        <div class="col-md-2 text-right">
                            <div data-toggle="tooltip" data-placement="left" data-original-title="Editar">
                                <a href="" class="btn btn-sm bg-olive" data-toggle="modal" data-target="#myModal-applicant">&nbsp;&nbsp;
                                    <span class="fa fa-lg fa-pencil" aria-hidden="true"></span>&nbsp;&nbsp;
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table" style="width:100%;">
                                <tr>
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Carnet Identidad</strong>
                                            </div>
                                            <div class="col-md-6">
                                                {!! $eco_com_applicant->identity_card !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Apellido Paterno</strong>
                                            </div>
                                            <div class="col-md-6">
                                                {!! $eco_com_applicant->last_name !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Apellido Materno</strong>
                                            </div>
                                            <div class="col-md-6">
                                                {!! $eco_com_applicant->mothers_last_name !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @if ($eco_com_applicant->surname_husband)
                                    <tr>
                                        <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>Apellido de Esposo</strong>
                                                </div>
                                                <div class="col-md-6">
                                                    {!! $eco_com_applicant->surname_husband !!}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Primer Nombre</strong>
                                            </div>
                                            <div class="col-md-6">
                                                {!! $eco_com_applicant->first_name !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Segundo Nombre</strong>
                                            </div>
                                            <div class="col-md-6">
                                                {!! $eco_com_applicant->second_name !!}
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
                                                <strong>Fecha Nacimiento</strong>
                                            </div>
                                            <div class="col-md-6">
                                                 {!! $eco_com_applicant->getShortBirthDate() !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Edad</strong>
                                            </div>
                                            <div class="col-md-6">
                                                {!! $eco_com_applicant->getHowOld() !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                {{-- <tr>
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>NUA/CUA</strong>
                                            </div>
                                            <div class="col-md-6">
                                                {!! $eco_com_applicant->nua !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr> --}}
                                <tr>
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Estado Civil</strong>
                                            </div>
                                            <div class="col-md-6">
                                                {!! $eco_com_applicant->getCivilStatus() !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Teléfono(s)</strong>
                                            </div>
                                            {{--<div class="col-md-6">
                                                {!! $eco_com_applicant->getPhone() !!}
                                            </div>
                                            --}}

                                            <div class="col-md-6">
                                                @foreach(explode(',',$eco_com_applicant->phone_number) as $phone)
                                                    {!! $phone !!}
                                                    <br/>
                                                @endforeach
                                            </div>

                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Celular:</strong>
                                            </div>
                                            <div class="col-md-6">
                                                @foreach(explode(',',$eco_com_applicant->cell_phone_number) as $phone)
                                                    {!! $phone !!}
                                                    <br/>
                                                @endforeach
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box box-success box-solid">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-10">
                            <h3 class="box-title"><span class="glyphicon glyphicon-inbox"></span> Requisitos Presentados</h3>
                        </div>
                        <div class="col-md-2 text-right">
                            <div data-toggle="tooltip" data-placement="left" data-original-title="Editar">
                                <a href="" class="btn btn-sm bg-olive" data-toggle="modal" data-target="#myModal-requirements">&nbsp;&nbsp;
                                    <span class="fa fa-lg fa-pencil" aria-hidden="true"></span>&nbsp;&nbsp;
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            @if($status_documents)
                                <table class="table table-bordered table-hover" style="width:100%;font-size: 14px">
                                    <thead>
                                        <tr>
                                            <th>Nombre de Requisito</th>
                                            <th class="text-center">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($eco_com_submitted_documents as $item)
                                            <tr>
                                                <td>{!! $item->economic_complement_requirement->shortened !!}</td>
                                                <td>
                                                    <div class="text-center">
                                                        @if($item->status)
                                                        <span class="fa fa-check-square-o fa-lg"></span>
                                                        @else
                                                        <span class="fa fa-square-o fa-lg"></span>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                No hay registros
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-success box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"><span class="fa fa-money"></span> Cálculo de Total</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            {{-- @if($economic_complement->base_wage_id) --}}
                                <table class="table table-bordered table-hover table-striped" style="width:100%;font-size: 14px">
                                    <thead>
                                        <tr>
                                            <th>Concepto</th>
                                            <th style="text-align: right">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="width: 70%">Renta Total Boleta</td>
                                            <td style="text-align: right">{!! $sub_total_rent !!}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 70%">Reintegro</td>
                                            <td style="text-align: right">{!! $reimbursement !!}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 70%">Renta Dignidad</td>
                                            <td style="text-align: right">{!! $dignity_pension !!}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 70%">Renta total Neta</td>
                                            <td style="text-align: right">{!! $total_rent !!}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 70%">Neto</td>
                                            <td style="text-align: right">{!! $total_rent_calc !!}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 70%">Referente Salarial</td>
                                            <td style="text-align: right">{!! $salary_reference !!}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 70%">Antigüedad</td>
                                            <td style="text-align: right">{!! $seniority !!}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 70%">Salario Cotizable</td>
                                            <td style="text-align: right">{!! $salary_quotable !!}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 70%">Diferencia</td>
                                            <td style="text-align: right">{!! $difference !!}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 70%">Total Semestre</td>
                                            <td style="text-align: right">{!! $total_amount_semester !!}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 70%">Factor de Complementación</td>
                                            <td style="text-align: right">{!! $complementary_factor !!}</td>
                                        </tr>

                                    </tbody>
                                </table>
                                <table class="table table-bordered table-hover" style="width:100%;font-size: 14px">
                                    <tbody>
                                        <tr>
                                            <td style="width: 70%">Total</td>
                                            <td  style="text-align: right">{!! $total !!}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            {{-- @else
                                <div class="row text-center">
                                    <i class="fa  fa-list-alt fa-3x  fa-border" aria-hidden="true"></i>
                                    <h4 class="box-title">No hay registros</h4>
                                </div>
                            @endif --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" tabindex="-1" >

        @if($economic_complement->economic_complement_modality->economic_complement_type->id>1)
            <iframe src="{!! url('print_sworn_declaration2/' . $economic_complement->id) !!}" id="iFramePdf"></iframe>
        @else
            <iframe src="{!! url('print_sworn_declaration1/' . $economic_complement->id) !!}" id="iFramePdf"></iframe>
        @endif

        <iframe src="{!! url('print_reception_report/' . $economic_complement->id) !!}" id="iFramePdfReport"></iframe>
    </div>


@endsection

@push('scripts')
<script>

	function printTrigger(elementId) {
        var getMyFrame = document.getElementById(elementId);
        getMyFrame.focus();
        getMyFrame.contentWindow.print();
    }

	$(document).ready(function(){
		$('.combobox').combobox();
	    $('[data-toggle="tooltip"]').tooltip();
		$("#birth_date_mask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/aaaa"});
		$("#phone_number").inputmask();
		$("#cell_phone_number").inputmask();

        $('#state').on('change', function() {
            var stateID = $(this).val();
            if(stateID) {
                $.ajax({
                    url: '{!! url('get_causes_by_state') !!}',
                    type: "GET",
                    dataType: "json",
                    data:{
                        "state_id" : stateID
                    },
                    success: function(data) {
                        $('select[name="cause"]').empty();
                        $('#check').empty();
                        $.each(data.causes, function(key, value) {
                            $('#causes').append('<option value="'+key+'">"+value+"</option>');
                        });
                    }, error:function(err){

                        console.log("Aqui va mi error.-.--------------------------");
                        console.log(err);
                    }
                });
            }
            else{
                $('select[name="cause"]').empty();
            }
        });


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

	//for phone numbers
	$('#addPhoneNumber').on('click', function(event) {
		$('#phonesNumbers').append('<div class="col-md-offset-5"><div class="col-md-7"><input type="text" class="form-control" name="phone_number[]" data-inputmask="\'mask\': \'(9) 999-999\'" data-mask></div><div class="col-md-1"><button class="btn btn-warning deletePhone" type="button" ><i class="fa fa-minus"></i></button></div></div>')
		event.preventDefault();
		$("input[name='phone_number[]']").each(function() {
			$(this).inputmask();
		});
		$("input[name='phone_number[]']").last().focus();
	});
	$(document).on('click', '.deletePhone', function(event) {
		$(this).parent().parent().remove();
		event.preventDefault();
	});
	//for cell phone numbers
	$('#addCellPhoneNumber').on('click', function(event) {
		$('#cellPhonesNumbers').append('<div class="col-md-offset-5"><div class="col-md-8"><input type="text" class="form-control" name="cell_phone_number[]" data-inputmask="\'mask\': \'(999)-99999\'" data-mask></div><div class="col-md-1"><button class="btn btn-warning deleteCellPhone" type="button" ><i class="fa fa-minus"></i></button></div></div>')
		event.preventDefault();
		$("input[name='cell_phone_number[]']").each(function() {
			$(this).inputmask();
		});
		$("input[name='cell_phone_number[]']").last().focus();
	});
	$(document).on('click', '.deleteCellPhone', function(event) {
		$(this).parent().parent().remove();
		event.preventDefault();
	});



</script>
@endpush
