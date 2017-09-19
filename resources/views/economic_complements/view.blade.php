@extends('app')
@section('contentheader_title')
<div class="row">
	<div class="col-md-6">
		{!! Breadcrumbs::render('show_economic_complement', $economic_complement) !!}
	</div>
	<div class="col-md-6">
    
            
       @can('eco_com_reception')
         @if( $economic_complement->reception_type == 'Inclusion' )

            <div class="btn-group" data-toggle="tooltip" data-placement="top" data-original-title="Imprimir Declaración Jurada" style="margin:0px;">
                <a href="" class="btn btn-sm btn-raised btn-success dropdown-toggle enabled" data-toggle="modal" value="Print" onclick="printTrigger('iFramePdf');" >
                    &nbsp;<span class="glyphicon glyphicon-print"></span>&nbsp;
                </a>
            </div>
        @endif
            @if($economic_complement->reception_type == "Inclusion")
                <div class="btn-group" data-toggle="tooltip" data-placement="top" data-original-title="Imprimir Reporte Recepción Inclusiones" style="margin:0px;">
                    <a href="" class="btn btn-sm btn-raised btn-info dropdown-toggle enabled" data-toggle="modal" value="Print" onclick="printTrigger('iFramePdfReportInclusion');" >
                        &nbsp;<span class="glyphicon glyphicon-print"></span>&nbsp;
                    </a>
                </div>
            @endif
            @if($economic_complement->reception_type == "Habitual")
                <div class="btn-group" data-toggle="tooltip" data-placement="top" data-original-title="Imprimir Reporte Recepción Habituales" style="margin:0px;">
                    <a href="" class="btn btn-sm btn-raised btn-info dropdown-toggle enabled" data-toggle="modal" value="Print" onclick="printTrigger('iFramePdfReportHabitual');" >
                        &nbsp;<span class="glyphicon glyphicon-print"></span>&nbsp;
                    </a>
                </div>
            @endif
        @endcan
        
      
        @if($has_amortization)
       
                <div class="btn-group" data-toggle="tooltip" data-placement="top" data-original-title="Amortización" style="margin:0px;">
                    <a href="#" class="btn btn-sm btn-raised btn-success dropdown-toggle enabled"  data-toggle="modal" data-target="#amortization-modal" >
                        &nbsp;<span class="fa fa-money"></span>&nbsp;
                    </a>
                </div>
        @endif
        @can("eco_com_review_and_reception")
        <div class="btn-group">
            <a href="{!! url('economic_complement_reception_first_step/'.$affiliate->id) !!}" class="btn btn-sm btn-raised btn-lg bg-orange"  data-toggle="tooltip"  data-placement="top" data-original-title="Editar Tramite"><i aria-hidden="true" class="fa fa-refresh"></i></a>
        </div>
        @endcan
       
        <div class="btn-group">
            <span data-toggle="modal" data-target="#recordEcoModal">
                <a href="#" class="btn btn-sm btn-raised btn-lg bg-blue"  data-toggle="tooltip"  data-placement="top" data-original-title="Historial"><i class="fa fa-lg fa-clock-o"></i></a>
            </span>
        </div>
        <div class="pull-right">

            @if($buttons_enabled)
            
                    @if($wf_state_before)
                    <div class="btn-group">
                        <span data-toggle="tooltip" data-placement="top" data-original-title="Devolución de Tramite" style="margin:0px;">
                            <a href="" data-target="#back-modal" class="btn btn-sm btn-raised btn-warning dropdown-toggle enabled" data-toggle="modal"> <i class="fa  fa-arrow-left"></i></strong></a>
                        </span>
                    </div>
                    @endif
            <!-- <div class="btn-group">
                <span data-toggle="tooltip" data-placement="top" data-original-title="ver" style="margin:0px;">
                    <a href="" data-target="#myModal-review-user" class="btn btn-sm btn-raised btn-{{ $economic_complement->stateOf() ? 'info' : 'warning'}} dropdown-toggle enabled" data-toggle="modal"> <strong>{{ $economic_complement->stateOf() ? "Revisado":"No revisado"}}</strong></a>
                </span>
            </div> -->
            
           
                
                    @if($economic_complement->state == "Edited")

                    <div class="btn-group">
                        <span data-toggle="tooltip" data-placement="top" data-original-title="Cancelar" style="margin:0px;">
                            <a href="" data-target="#myModal-revert" class="btn btn-sm btn-raised btn-danger dropdown-toggle enabled" data-toggle="modal">&nbsp;<span class="glyphicon glyphicon-remove"></span>&nbsp;</a>
                        </span>
                    </div>
                    @else
                    <div class="btn-group">
                        <span data-toggle="tooltip" data-placement="top" data-original-title="Confirmar" style="margin:0px;">
                            <a href="" data-target="#myModal-confirm" class="btn btn-sm btn-raised btn-success dropdown-toggle enabled" data-toggle="modal">&nbsp;<span class="glyphicon glyphicon-ok"></span>&nbsp;</a>
                        </span>
                    </div>
                    @endif
            @endif
          

        </div>
    </div>
</div>
@endsection
@section('main-content')
    <div class="row">
        <div class="col-md-6">
          <!--  @include('affiliates.simple_info') -->

            <!-- applicant -->
            @if($eco_com_applicant->economic_complement->economic_complement_modality->economic_complement_type->id > 1)
                <div class="box box-success box-solid">
                    <div class="box-header with-border">
                        <div class="row">
                            <div class="col-md-10">
                                <a href="/affiliate/{{ $economic_complement->affiliate_id  }}" data-toggle="tooltip" data-placement="top" title="Volver al afiliado">
                                    <h3 class="box-title"><i class="fa fa-{{$affiliate->gender=='M'?'male':'female'  }}"></i> Información Personal
                                    @if($eco_com_applicant->economic_complement->economic_complement_modality->economic_complement_type->id > 1)
                                        - Causahabiente
                                    @endif
                                    </h3>
                                </a>
                            </div>

                            @can("eco_com_review_and_reception")
                            <div class="col-md-2 text-right">
                                <div data-toggle="tooltip" data-placement="left" data-original-title="Editar">
                                    <a href="" class="btn btn-sm bg-olive" data-toggle="modal" data-target="#myModal-personal">
                                        <span class="fa fa-lg fa-pencil" aria-hidden="true"></span>
                                    </a>
                                </div>
                            </div>
                            @endcan
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
                                                    <strong>Carnet Identidad:</strong>
                                                </div>
                                                <div class="col-md-6">
                                                    {!! $affiliate->identity_card !!} {!! $affiliate->city_identity_card->first_shortened ?? '' !!}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>Apellido Paterno:</strong>
                                                </div>
                                                <div class="col-md-6">
                                                    {!! $affiliate->last_name !!}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>Apellido Materno:</strong>
                                                </div>
                                                <div class="col-md-6">
                                                    {!! $affiliate->mothers_last_name !!}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @if ($affiliate->surname_husband)
                                        <tr>
                                            <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <strong>Apellido de Esposo:</strong>
                                                    </div>
                                                    <div class="col-md-6">
                                                        {!! $affiliate->surname_husband !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>Primer Nombre:</strong>
                                                </div>
                                                <div class="col-md-6">
                                                    {!! $affiliate->first_name !!}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>Segundo Nombre:</strong>
                                                </div>
                                                <div class="col-md-6">
                                                    {!! $affiliate->second_name !!}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>NUA/CUA:</strong>
                                                </div>
                                                <div class="col-md-6">
                                                    {!! $affiliate->nua !!}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @if($affiliate->date_death)
                                        <tr>
                                            <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <strong>Fecha de Deceso:</strong>
                                                    </div>
                                                    <div class="col-md-6">
                                                        {!! $affiliate->getShortDateDeath() !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table" style="width:100%;">
                                    <tr>
                                        <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>Género:</strong>
                                                </div>
                                                <div class="col-md-6">
                                                    {!! $affiliate->getGender() !!}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>Estado Civil:</strong>
                                                </div>
                                                <div class="col-md-6">
                                                    {!! $affiliate->getCivilStatus() !!}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>Fecha Nacimiento:</strong>
                                                </div>
                                                <div class="col-md-6">
                                                     {!! $affiliate->getShortBirthDate() !!}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>Edad:</strong>
                                                </div>
                                                <div class="col-md-6">
                                                    {!! $affiliate->getHowOld() !!}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>Lugar Nacimiento:</strong>
                                                </div>
                                                <div class="col-md-6">
                                                     {!! $affiliate->city_birth->name ?? '' !!}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>Teléfono:</strong>
                                                </div>
                                                <div class="col-md-6">
                                                    @foreach(explode(',',$affiliate->phone_number) as $phone)
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
                                                    @foreach(explode(',',$affiliate->cell_phone_number) as $phone)
                                                        {!! $phone !!}
                                                        <br/>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @if($affiliate->reason_death)
                                        <tr>
                                            <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <strong>Motivo de Deceso</strong>
                                                    </div>
                                                    <div class="col-md-6">
                                                        {!! $affiliate->reason_death !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="box box-success box-solid">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-8">
                            <a href="/affiliate/{{ $economic_complement->affiliate_id  }}" data-toggle="tooltip" data-placement="top" title="Volver al afiliado">
                            <h3 class="box-title"><span class="fa fa-user-plus"></span> Información de Beneficiario
                            @if($eco_com_applicant->economic_complement->economic_complement_modality->economic_complement_type->id > 1)
                            - Derechohabiente
                            @endif
                            </h3>
                            </a>
                            <div class="box-tools pull-right">
                            </div>
                        </div>
                        @can('eco_com_review_and_reception')
                        {{--@can('showEdit', $economic_complement)--}}
                        <div class="col-md-4 text-right">
                            <span data-toggle="tooltip" data-placement="left" data-original-title="Editar">
                                <a href="" class="btn btn-sm bg-olive" data-toggle="modal" data-target="#myModal-applicant">&nbsp;&nbsp;
                                    <span class="fa fa-lg fa-pencil" aria-hidden="true"></span>&nbsp;&nbsp;
                                </a>
                            </span>
                        </div>
                        @endcan
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table" style="width:100%;">
                                <tr>
                                    <td style="border-top:0px;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Carnet Identidad</strong>
                                            </div>
                                            <div class="col-md-6">
                                                {!! $eco_com_applicant->identity_card !!} {{$eco_com_applicant->city_identity_card->first_shortened ?? ''}}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-top:0px;;">
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
                                    <td style="border-top:0px;;">
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
                                        <td style="border-top:0px;;">
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
                                    <td style="border-top:0px;;">
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
                                    <td style="border-top:0px;;">
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
                                <tr>
                                    <td style="border-top:0px;;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>CUA/NUA</strong>
                                            </div>
                                            <div class="col-md-6">
                                                {!! $eco_com_applicant->nua !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
									@if($eco_com_applicant->date_death)
									<tr>
										<td style="border-top:0px;;">
											<div class="row">
													<div class="col-md-6">
															<strong>Fecha de Deceso:</strong>
													</div>
													<div class="col-md-6">
															{!! $eco_com_applicant->getShortDateDeath() !!}
													</div>
											</div>
										</td>
									</tr>
									@endif

                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table" style="width:100%;">
                                <tr>
                                    <td style="border-top:0px;;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Género</strong>
                                            </div>
                                            <div class="col-md-6">
                                                 {!! $eco_com_applicant->getGender() !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-top:0px;;">
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
                                    <td style="border-top:0px;;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Fecha de Nac.</strong>
                                            </div>
                                            <div class="col-md-6">
                                                 {!! $eco_com_applicant->getShortBirthDate() !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @if($eco_com_applicant->economic_complement->economic_complement_modality->economic_complement_type->id == 1)
                                <tr>
                                    <td style="border-top:0px;;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Lugar de Nac.</strong>
                                            </div>
                                            <div class="col-md-6">
                                                {!! $eco_com_applicant->economic_complement->affiliate->city_birth->name ?? '' !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @else
                                <tr>
                                    <td style="border-top:0px;;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Lugar de Nac.</strong>
                                            </div>
                                            <div class="col-md-6">
                                                 {!! $eco_com_applicant->city_birth->name ?? null !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td style="border-top:0px;;">
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
                                    <td style="border-top:0px;;">
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
                                    <td style="border-top:0px;;">
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
                                    <td style="border-top:0px;">
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
									@if($eco_com_applicant->reason_death)
											<tr>
													<td style="border-top:0px;">
															<div class="row">
																	<div class="col-md-6">
																			<strong>Motivo de Deceso</strong>
																	</div>
																	<div class="col-md-6">
																			{!! $eco_com_applicant->reason_death !!}
																	</div>
															</div>
													</td>
											</tr>
									@endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /applicant -->

            <!-- legal guardian -->
            @if($economic_complement->has_legal_guardian)
            <div class="box box-success box-solid">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-10">
                            <h3 class="box-title"><span class="fa fa-shield"></span> Informacion del Apoderado</h3>
                        </div>
                        @can("eco_com_review_and_reception")
                        <div class="col-md-2 text-right">
                            <div data-toggle="tooltip" data-placement="left" data-original-title="Editar">
                                <a href="" class="btn btn-sm bg-olive" data-toggle="modal" data-target="#myModal-guardian">&nbsp;&nbsp;
                                    <span class="fa fa-lg fa-pencil" aria-hidden="true"></span>&nbsp;&nbsp;
                                </a>
                            </div>
                        </div>
                        @endcan


                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table" style="width:100%;">
                                <tr>
                                    <td style="border-top:0px;;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Carnet Identidad</strong>
                                            </div>
                                            <div class="col-md-6">
                                                {!! $economic_complement_legal_guardian->identity_card !!} {!! $economic_complement_legal_guardian->city_identity_card->first_shortened ?? '' !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-top:0px;;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Apellido Paterno</strong>
                                            </div>
                                            <div class="col-md-6">
                                                {!! $economic_complement_legal_guardian->last_name !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-top:0px;;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Apellido Materno</strong>
                                            </div>
                                            <div class="col-md-6">
                                                {!! $economic_complement_legal_guardian->mothers_last_name !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @if ($economic_complement_legal_guardian->surname_husband)
                                    <tr>
                                        <td style="border-top:0px;;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>Apellido de Esposo</strong>
                                                </div>
                                                <div class="col-md-6">
                                                    {!! $economic_complement_legal_guardian->surname_husband !!}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table" style="width:100%;">
                                <tr>
                                    <td style="border-top:0px;;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Primer Nombre</strong>
                                            </div>
                                            <div class="col-md-6">
                                                {!! $economic_complement_legal_guardian->first_name !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-top:0px;;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Segundo Nombre</strong>
                                            </div>
                                            <div class="col-md-6">
                                                {!! $economic_complement_legal_guardian->second_name !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-top:0px;;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Teléfono(s)</strong>
                                            </div>
                                            <div class="col-md-6">
                                                @foreach(explode(',',$economic_complement_legal_guardian->phone_number) as $phone)
                                                    {!! $phone !!}
                                                    <br/>
                                                @endforeach
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-top:0px;;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Celular:</strong>
                                            </div>
                                            <div class="col-md-6">
                                                @foreach(explode(',',$economic_complement_legal_guardian->cell_phone_number) as $phone)
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
            @endif
            <!-- /legal guardian -->

            <!-- Requisitos Presentados -->
            <div class="box box-success box-solid">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-10">
                            <h3 class="box-title"><span class="glyphicon glyphicon-inbox"></span> Requisitos Presentados</h3>
                        </div>
                        @can("eco_com_review_and_reception")
                        {{--@can('showEdit', $economic_complement)--}}
                            <div class="col-md-2 text-right">
                                <div data-toggle="tooltip" data-placement="left" data-original-title="Editar">
                                    <a href="" class="btn btn-sm bg-olive" data-toggle="modal" data-target="#myModal-requirements">&nbsp;&nbsp;
                                        <span class="fa fa-lg fa-pencil" aria-hidden="true"></span>&nbsp;&nbsp;
                                    </a>
                                </div>
                            </div>
                        @endcan
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
                                            <th>Fecha</th>
                                            <th class="text-center">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($eco_com_submitted_documents as $item)
                                            <tr>
                                                <td>{!! $item->economic_complement_requirement->shortened !!}</td>
                                                <td>{!! Util::getDateShort($item->reception_date) !!}</td>
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
            <!-- /Requisitos Presentados-->

            <!-- observations-->
            @include('observations.show')
            <!-- /observations-->
        </div>
        <div class="col-md-6">
            <!-- información del Trámite -->
            <div class="box box-success box-solid">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="box-title"><span class="glyphicon glyphicon-info-sign"></span> Información del Trámite</h3>
                        </div>
                        @can("eco_com_review_reception_calification")
                        {{--@can('showEdit', $economic_complement)--}}
                        <div class="col-md-4 text-right">
                            <span data-toggle="modal" data-target="#policeModal">
                                <a href="#" class="btn btn-sm bg-olive"  data-toggle="tooltip"  data-placement="top" data-original-title="Editar"><i class="fa fa-lg fa fa-pencil"></i></a>
                            </span>
                        </div>
                        @endcan
                        @can("accounting")
                        <div class="col-md-4 text-right">
                            <span data-toggle="modal" data-target="#addMoreInfo">
                                <a href="#" class="btn btn-sm bg-olive"  data-toggle="tooltip"  data-placement="top" data-original-title="Adicionar Información"><i class="fa fa-lg fa fa-plus"></i></a>
                            </span>
                        </div>
                        @endcan
            
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-responsive" style="width:100%;">
								<tr>
									<td style="border-top:0px;">
										<div class="row">
											<div class="col-md-6">
												<strong>Grado</strong>
											</div>
											<div class="col-md-6" data-toggle="tooltip" data-placement="bottom" data-original-title="{!! $economic_complement->degree->name ?? '' !!}">
												{!! $economic_complement->degree->shortened ?? '' !!}
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td style="border-top:0px;">
										<div class="row">
											<div class="col-md-6">
												<strong>Categoría</strong>
											</div>
											<div class="col-md-6">
												{!! $economic_complement->category->getPercentage() !!}
											</div>
										</div>
									</td>
								</tr>
                                <tr>
                                    <td style="border-top:0px;;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Gestión</strong>
                                            </div>
                                            <div class="col-md-6">
                                                {!! $economic_complement->getYear() !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                 <tr>
                                     <td style="border-top:0px;;">
                                         <div class="row">
                                             <div class="col-md-6">
                                                 <strong>Semestre</strong>
                                             </div>
                                             <div class="col-md-6">
                                                 {!! $economic_complement->semester !!}
                                             </div>
                                         </div>
                                     </td>
                                 </tr>
                                 <tr>
                                    <td style="border-top:0px;;">
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
                                {{-- <tr>
                                    <td style="border-top:0px;;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Estado</strong>
                                            </div>
                                            <div class="col-md-6">
                                                {!! $state->name ?? '' !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr> --}}
                                <tr>
                                    <td style="border-top:0px;;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Tipo de Recepción</strong>
                                            </div>
                                            <div class="col-md-6">
                                                {!! $economic_complement->reception_type ?? '' !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                @can("accounting")
                                <tr>
                                    <td style="border-top:0px;;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Numero de comprobante</strong>
                                            </div>
                                            <div class="col-md-6">
                                                {!! $economic_complement->number_accounting ?? '' !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endcan

                                @can("loan")
                                <tr>
                                    <td style="border-top:0px;;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Numero de comprobante</strong>
                                            </div>
                                            <div class="col-md-6">
                                                {!! $economic_complement->number_budget ?? '' !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endcan

                                @can("treasury")
                                <tr>
                                    <td style="border-top:0px;;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Numero de comprobante</strong>
                                            </div>
                                            <div class="col-md-6">
                                                {!! $economic_complement->number_check ?? '' !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endcan

                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-responsive" style="width:100%;">
                                <tr>
						          <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
						              <div class="row">
						                  <div class="col-md-6">
						                      <strong>Matrícula</strong>
						                  </div>
						                  <div class="col-md-6">
						                      {!! $affiliate->registration !!}
						                  </div>
						              </div>
						          </td>
						        </tr>
                                <tr>
                                    <td style="border-top:0px;;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Ciudad</strong>
                                            </div>
                                            <div class="col-md-6">
                                                {!! $economic_complement->city->name ?? '' !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-top:0px;;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Ente Gestor</strong>
                                            </div>
                                            <div class="col-md-6">
                                                {!! $affiliate->pension_entity->name ?? '' !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-top:0px;;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Fecha de Recepción</strong>
                                            </div>
                                            <div class="col-md-6">
                                                {!! $economic_complement->getReceptionDate() !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-top:0px;;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Ubicación</strong>
                                            </div>
                                            <div class="col-md-6">
                                                {!! $economic_complement->wf_state->name !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-top:0px;;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Flujo</strong>
                                            </div>
                                            <div class="col-md-6">
                                                {!! $economic_complement->workflow->name ?? ''!!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /información del Trámite -->

            <!-- calculo total -->
            <div class="box box-success box-solid">
                <div class="box-header with-border">
                    <div class="col-md-{{ $economic_complement->old_eco_com ? '6':($economic_complement->total_rent > 0 ? '8':'10') }}">
                        <h3 class="box-title"><span class="fa fa-money"></span> Cálculo de Total</h3>
                    </div>
                        @can('eco_com_qualification')
                            @if($economic_complement->total_rent > 0 )
                                @if($economic_complement->old_eco_com)
                                <div class="col-md-2">
                                    <div data-toggle="tooltip" data-placement="left" data-original-title="Imprimir Tramite Anterior">
                                        <a href="" class="btn btn-sm bg-olive" data-toggle="modal" data-target="#myModal-totals-print-old">&nbsp;&nbsp;
                                            <span class="fa fa-lg fa-print" aria-hidden="true"></span>&nbsp;&nbsp;
                                        </a>
                                   </div>
                                </div>
                                @endif
                                <div class="col-md-2">
                                    <div data-toggle="tooltip" data-placement="left" data-original-title="Imprimir {{ $economic_complement->old_eco_com ? 'Recalifiación' : 'Califiación' }}">
                                        <a href="" class="btn btn-sm bg-olive" data-toggle="modal" data-target="#myModal-totals-print">&nbsp;&nbsp;
                                            <span class="fa fa-lg fa-print" aria-hidden="true"></span>&nbsp;&nbsp;
                                        </a>
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-2">
                                <div data-toggle="tooltip" data-placement="left" data-original-title="Editar">
                                    <a href="" class="btn btn-sm bg-olive" data-toggle="modal" data-target="#myModal-totals">&nbsp;&nbsp;
                                        <span class="fa fa-lg fa-calculator" aria-hidden="true"></span>&nbsp;&nbsp;
                                    </a>
                                </div>
                            </div>
                        @endcan
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            @if($economic_complement->affiliate->pension_entity->type == 'APS')
                                <table class="table table-bordered table-responsive table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>Detalle</th>
                                            <th>Total Fracion</th>
                                        </tr>
                                    </thead>
                                <tbody>
                                    <tr>
                                        <td style="width: 70%">Fracion de saldo acumulada</td>
                                        <td style="text-align: right">{{ $economic_complement->aps_total_fsa}} </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 70%">Fracion complementaria</td>
                                        <td style="text-align: right">{{ $economic_complement->aps_total_cc}} </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 70%">Fracion solidaria</td>
                                        <td style="text-align: right">{{ $economic_complement->aps_total_fs}} </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-bordered table-hover" style="width:100%;font-size: 14px">
                                <tbody>
                                    <tr>
                                        <td style="width: 70%">Total</td>
                                        <td  style="text-align: right" > {{ $economic_complement->getTotalFractions() }} </td>
                                    </tr>
                                </tbody>
                            </table>
                            @endif
                            @if($economic_complement->aps_disability > 0)
                            <hr>
                                <table class="table table-bordered table-hover table-striped" style="width:100%;font-size: 14px">
                                    <thead>
                                        <tr style="background: #f45642">
                                            <th>Concepto</th>
                                            <th style="text-align: right">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="danger">
                                           <td style="width: 70%">Concurrencia - Renta Invalidez</td>
                                            <td style="text-align: right">{!! $economic_complement->aps_disability !!}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endif
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
                                            <td style="width: 70%">Renta Boleta</td>
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
                                @if( $economic_complement->amount_loan > 0 || $economic_complement->amount_accounting > 0 || $economic_complement->amount_replacement > 0  )
                                <table class="table table-bordered table-hover" style="width:100%;font-size: 14px">
                                    <tbody>
                                        <tr>
                                            <td style="width: 70%">Total</td>
                                            <td  style="text-align: right" id="tempTotal"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <hr>
                                <table class="table table-bordered table-hover table-striped" style="width:100%;font-size: 14px">
                                    <tbody>
                                        <tr>
                                            <td style="width: 70%">Cuentas por cobrar </td>
                                            <td  style="text-align: right">{!! $economic_complement->amount_accounting !!}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 70%">Mora por prestamos</td>
                                            <td  style="text-align: right">{!! $economic_complement->amount_loan !!}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 70%">Reposición de fondos</td>
                                            <td  style="text-align: right">{!! $economic_complement->amount_replacement !!}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                @endif
                                <table class="table table-bordered table-hover " style="width:100%;font-size: 14px">
                                    <tbody>
                                        <tr class="success">
                                            <td style="width: 70%">Total</td>
                                            <td  style="text-align: right">{!! $total !!}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                @if($total_repay)
                                <table class="table table-bordered table-hover " style="width:100%;font-size: 14px">
                                    <tbody>
                                        <tr class="warning">
                                            <td style="width: 70%">Total Reintegro</td>
                                            <td  style="text-align: right">{!! $total_repay !!}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                @endif
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
            <!-- /calculo total -->

            <!-- documentos presentados -->
            <div class="box box-warning box-solid">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-10">
                            <h3 class="box-title"><span class="glyphicon glyphicon-inbox"></span> Documentos Presentados</h3>
                        </div>
                        @can("eco_com_review_and_reception")

                        <div class="col-md-2 text-right">
                            <div data-toggle="tooltip" data-placement="left" data-original-title="Editar">
                                <a href="" class="btn btn-sm bg-yellow-active" data-toggle="modal" data-target="#myModal-requirements-ar">&nbsp;&nbsp;
                                    <span class="fa fa-lg fa-pencil" aria-hidden="true"></span>&nbsp;&nbsp;
                                </a>
                            </div>
                        </div>
                        @endcan
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            @if($status_documents_ar)
                                <table class="table table-bordered table-hover" style="width:100%;font-size: 14px">
                                    <thead>
                                        <tr>
                                            <th>Nombre de Requisito</th>
                                            <th>Fecha</th>
                                            <th class="text-center">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($eco_com_submitted_documents_ar as $item)
                                            <tr>
                                                <td>{!! $item->economic_complement_requirement->shortened !!}</td>
                                                <td>{!! Util::getDateShort($item->reception_date) !!}</td>
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
            <!-- /documentos presentados -->
        </div>
    </div>
<!-- modals -->
    <div class="modal fade" tabindex="-1" >

        @if($economic_complement->economic_complement_modality->economic_complement_type->id>1)
            <iframe src="{!! url('print_sworn_declaration/' . $economic_complement->id . '/viudedad') !!}" id="iFramePdf"></iframe>
        @else
            <iframe src="{!! url('print_sworn_declaration/' . $economic_complement->id . '/vejez') !!}" id="iFramePdf"></iframe>
        @endif

        <iframe src="{!! url('print_eco_com_reports/' . $economic_complement->id . '/inclusion') !!}" id="iFramePdfReportInclusion" ></iframe>
        <iframe src="{!! url('print_eco_com_reports/' . $economic_complement->id . '/habitual') !!}" id="iFramePdfReportHabitual" ></iframe>
    </div>
    <div id="myModal-personal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="box-header with-border">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Editar Información Personal</h4>
                </div>
                <div class="modal-body">

                    {!! Form::model($affiliate, ['method' => 'PATCH', 'route' => ['affiliate.update', $affiliate], 'class' => 'form-horizontal']) !!}
                        <input type="hidden" name="type" value="personal"/>
                        <input type="hidden" name="typeEco" value="economic_complement"/>
                        <input type="hidden" name="economic_complement_id" value="{{$economic_complement->id}}"/>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                        {!! Form::label('identity_card', 'Carnet de Identidad', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-5">
                                        {!! Form::text('identity_card', $affiliate->identity_card, ['class'=> 'form-control', 'required']) !!}
                                        <span class="help-block">Número de CI</span>
                                    </div>
                                        {!! Form::select('city_identity_card_id', $cities_list_short, $affiliate->city_identity_card_id, ['class' => 'col-md-2 combobox form-control','required' => 'required']) !!}
                                </div>
                                <div class="form-group">
                                        {!! Form::label('last_name', 'Apellido Paterno', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::text('last_name', $affiliate->last_name, ['class'=> 'form-control',  'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                                        <span class="help-block">Escriba el Apellido Paterno</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                        {!! Form::label('mothers_last_name', 'Apellido Materno', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::text('mothers_last_name', $affiliate->mothers_last_name, ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                                        <span class="help-block">Escriba el Apellido Materno</span>
                                    </div>
                                </div>
                                {{-- @if ($affiliate->gender == 'F') --}}
                                    <div class="form-group">
                                            {!! Form::label('surname_husband', 'Apellido de Esposo', ['class' => 'col-md-5 control-label']) !!}
                                        <div class="col-md-7">
                                            {!! Form::text('surname_husband', $affiliate->surname_husband, ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                                            <span class="help-block">Escriba el Apellido de Esposo (Opcional)</span>
                                        </div>
                                    </div>
                                {{-- @endif --}}
                                <div class="form-group">
                                        {!! Form::label('first_name', 'Primer Nombre', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::text('first_name', $affiliate->first_name, ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                                        <span class="help-block">Escriba el  Primer Nombre</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                        {!! Form::label('second_name', 'Segundo Nombre', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::text('second_name', $affiliate->second_name, ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                                        <span class="help-block">Escriba el Segundo Nombre</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                        {!! Form::label('nua', 'CUA/NUA', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-6">
                                        {!! Form::number('nua', $affiliate->nua, ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                                        <span class="help-block">Escriba el CUA/NUA</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                            {!! Form::label('gender', 'Género', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::select('gender', ['M'=>'Masculino','F'=>'Femenino'] ,$affiliate->gender, ['class' => 'combobox form-control','required']) !!}
                                        <span class="help-block">Seleccione Género</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                            {!! Form::label('civil_status', 'Estado Civil', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::select('civil_status', $gender_list, $affiliate->civil_status, ['class' => 'combobox form-control', 'required']) !!}
                                        <span class="help-block">Seleccione el Estado Civil</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                        {!! Form::label('birth_date', 'Fecha de Nacimiento', ['class' => 'col-md-5 control-label','required']) !!}
                                    <div class="col-md-7">
                                        <div class="input-group">
                                            <input type="text" id="birth_date_mask" required class="form-control" name="birth_date" value="{!! $affiliate->getEditBirthDate() !!}" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                            {!! Form::label('city_birth_id', 'Lugar de Nacimiento', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::select('city_birth_id', $cities_list, $affiliate->city_birth_id, ['class' => 'combobox form-control']) !!}
                                        <span class="help-block">Seleccione Departamento</span>
                                    </div>
                                </div>
                                <div class="form-group" id="phonesNumbers" style="padding-bottom:5px;">

                                    {!! Form::label('phone_number', 'Teléfono fijo', ['class' => 'col-md-5 control-label']) !!}
                                    @foreach(explode(',',$affiliate->phone_number) as $key=>$phone)
                                    @if($key>=1)
                                    <div class="col-md-offset-5">
                                    @endif
                                    @if($key>=1)
                                    <div class="col-md-7">
                                    @else
                                    <div class="col-md-6">
                                    @endif
                                        <input type="text" id="phone_number" class="form-control" name="phone_number[]" value="{!! $phone !!}" data-inputmask="'mask': '(9) 999-999'" data-mask>
                                    </div>
                                    @if($key>=1)
                                    <div class="col-md-1"><button class="btn btn-warning deletePhone" type="button" ><i class="fa fa-minus"></i></button></div>
                                    @endif

                                    @if($key>=1)
                                    </div>
                                    @endif

                                    @endforeach
                                </div>
                                <div class="form-group">
                                    <div class="col-md-offset-6">
                                    <button class="btn btn-success" id="addPhoneNumber" type="button" ><span class="fa fa-plus"></span></button>
                                    </div>
                                </div>
                                <div class="form-group" id="cellPhonesNumbers" style="padding-bottom:5px;">
                                        {!! Form::label('cell_phone_number', 'Teléfono Celular', ['class' => 'col-md-5 control-label']) !!}
                                        @foreach(explode(',',$affiliate->cell_phone_number) as $key=>$phone)
                                        @if($key>=1)
                                        <div class="col-md-offset-5">
                                        @endif
                                        @if($key>=1)
                                        <div class="col-md-7">
                                        @else
                                        <div class="col-md-6">
                                        @endif
                                        <input type="text" id="cell_phone_number" class="form-control" name="cell_phone_number[]" value="{!! $phone !!}" data-inputmask="'mask': '(999)-99999'" data-mask>
                                         </div>
                                    @if($key>=1)
                                    <div class="col-md-1"><button class="btn btn-warning deletePhone" type="button" ><i class="fa fa-minus"></i></button></div>
                                    @endif

                                    @if($key>=1)
                                    </div>
                                    @endif

                                        @endforeach
                                </div>
                                <div class="form-group">
                                    <div class="col-md-offset-6">
                                    <button class="btn btn-success" id="addCellPhoneNumber"><span class="fa fa-plus"></span></button>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-offset-5 col-md-4">
                                        <div class="form-group">
                                            <div class="togglebutton">
                                              <label>
                                                <input type="checkbox" data-bind="checked: DateDeathAffiliateValue" name="DateDeathAffiliateCheck" > Fallecido
                                              </label>
                                          </div>
                                        </div>
                                    </div>
                                </div>

                                <div data-bind='visible: DateDeathAffiliateValue '>

                                    <div class="form-group">
                                            {!! Form::label('date_death', 'Fecha Deceso', ['class' => 'col-md-5 control-label']) !!}
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" id="date_death_mask" class="form-control" name="date_death" value="{!! $affiliate->getEditDateDeath() !!}" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
                                                <div class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                            {!! Form::label('reason_death', 'Causa Deceso', ['class' => 'col-md-5 control-label']) !!}
                                        <div class="col-md-6">
                                            {!! Form::textarea('reason_death', $affiliate->reason_death, ['class'=> 'form-control', 'rows' => '2']) !!}
                                            <span class="help-block">Escriba el Motivo de fallecimiento</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('death_certificate_number', 'Nro de certificado de defunción', ['class' => 'col-md-5 control-label']) !!}
                                        <div class="col-md-6">
                                            {!! Form::textarea('death_certificate_number', $affiliate->death_certificate_number, ['class'=> 'form-control', 'rows' => '2']) !!}
                                            <span class="help-block">Escriba Número de certificado de defunción</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row text-center">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <a href="#" class="btn btn-raised btn-warning" data-dismiss="modal" data-toggle="tooltip" data-placement="bottom" data-original-title="Cancelar">&nbsp;<i class="glyphicon glyphicon-remove"></i>&nbsp;</a>
                                    &nbsp;&nbsp;
                                    <button type="submit" class="btn btn-raised btn-success" data-toggle="tooltip" data-placement="bottom" data-original-title="Guardar">&nbsp;<i class="glyphicon glyphicon-floppy-disk"></i>&nbsp;</button>
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <div id="myModal-applicant" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="box-header with-border">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="box-title">Editar Beneficiario</h4>
                </div>

                <div class="modal-body">
                    {!! Form::model($economic_complement, ['method' => 'PATCH', 'route' => ['economic_complement.update', $economic_complement->id], 'class' => 'form-horizontal']) !!}
                        <input type="hidden" name="step" value="second"/>
                        <input type="hidden" name="type" value="update"/>
                        <input type="hidden" name="type1" value="update"/>
						<input type="hidden" name="applicant" value="update"/>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="col-md-12">
                                            {!! Form::label('identity_card', 'Carnet de Identidad', ['class' => 'col-md-5 control-label']) !!}
                                        <div class="col-md-5">
                                            {!! Form::text('identity_card', $eco_com_applicant->identity_card, ['class'=> 'form-control', 'required']) !!}
                                            <span class="help-block">Número de CI</span>
                                        </div>
                                            {!! Form::select('city_identity_card_id', $cities_list_short, $eco_com_applicant->city_identity_card_id, ['class' => 'col-md-2 combobox form-control', 'required']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                        {!! Form::label('last_name', 'Apellido Paterno', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-6">
                                        {!! Form::text('last_name', $eco_com_applicant->last_name, ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                                        <span class="help-block">Escriba el Apellido Paterno</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                        {!! Form::label('mothers_last_name', 'Apellido Materno', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-6">
                                        {!! Form::text('mothers_last_name', $eco_com_applicant->mothers_last_name, ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                                        <span class="help-block">Escriba el Apellido Materno</span>
                                    </div>
                                </div>
                                 
                                <div class="form-group">
                                        {!! Form::label('surname_husband', 'Apellido de Esposo', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-6">
                                        {!! Form::text('surname_husband', $eco_com_applicant->surname_husband, ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                                        <span class="help-block">Escriba el Apellido de Esposo (Opcional)</span>
                                    </div>
                                </div>
                                 
                                <div class="form-group">
                                        {!! Form::label('first_name', 'Primer Nombre', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-6">
                                        {!! Form::text('first_name', $eco_com_applicant->first_name, ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                                        <span class="help-block">Escriba el  Primer Nombre</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                        {!! Form::label('second_name', 'Segundo Nombre', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-6">
                                        {!! Form::text('second_name', $eco_com_applicant->second_name, ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                                        <span class="help-block">Escriba el Segundo Nombre</span>
                                    </div>
                                </div>
                                 <div class="form-group">
                                        {!! Form::label('nua', 'CUA/NUA', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-6">
                                        {!! Form::number('nua', $affiliate->nua, ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                                        <span class="help-block">Escriba el CUA/NUA</span>
                                    </div>
                                </div>
								<!-- aqui colocar nuevos -->
								<div class="form-group">
										<div class="col-md-6">
												<div class="togglebutton">
													<label>
														<input type="checkbox"  data-bind='checked: selected'> Fallecido
													</label>
												</div>
										</div>
								</div>
								<div data-bind='visible: selected'>
									<div class="form-group">
										{!! Form::label('date_death', 'Fecha Deceso', ['class' => 'col-md-5 control-label']) !!}
										<div class="col-md-6">
                                            <div class="input-group">
												<input type="text" id="date_death_spouse_mask" class="form-control" name="date_death" value={{$eco_com_applicant->date_death}} data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
												<div class="input-group-addon">
												    <span class="glyphicon glyphicon-calendar"></span>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group">
									   {!! Form::label('reason_death', 'Causa Deceso', ['class' => 'col-md-5 control-label']) !!}
										<div class="col-md-6">
                                            {!! Form::textarea('reason_death', $eco_com_applicant->reason_death, ['class'=> 'form-control', 'rows' => '2']) !!}
                                                <span class="help-block">Escriba el Motivo de fallecimiento</span>
                                        </div>
									</div>
                                    <div class="form-group">
                                        {!! Form::label('death_certificate_number', 'Nro de certificado de defunción', ['class' => 'col-md-5 control-label']) !!}
                                        <div class="col-md-6">
                                            {!! Form::textarea('death_certificate_number', $eco_com_applicant->death_certificate_number, ['class'=> 'form-control', 'rows' => '2']) !!}
                                            <span class="help-block">Escriba Número de certificado de defunción</span>
                                        </div>
                                    </div>
								</div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                        {!! Form::label('gender', 'Género', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::select('gender', ['M'=>'Masculino','F'=>'Femenino'] ,$eco_com_applicant->gender, ['class' => 'combobox form-control','required']) !!}
                                        <span class="help-block">Seleccione Género</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                            {!! Form::label('civil_status', 'Estado Civil', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-6">
                                        {!! Form::select('civil_status', $gender_list, $eco_com_applicant->civil_status, ['class' => 'combobox form-control', 'required']) !!}
                                        <span class="help-block">Seleccione el Estado Civil</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                        {!! Form::label('birth_date', 'Fecha de Nacimiento', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input type="text" id="birth_date_mask" class="form-control" name="birth_date" value="{!! $eco_com_applicant->getEditBirthDate() !!}" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if($eco_com_applicant->economic_complement->economic_complement_modality->economic_complement_type->id == 1)
                                    <div class="form-group">
                                        {!! Form::label('city_birth_id', 'Lugar de Nacimiento', ['class' => 'col-md-5 control-label']) !!}
                                        <div class="col-md-7">
                                            {!! Form::select('city_birth_id', $cities_list, $affiliate->city_birth_id, ['class' => 'combobox form-control']) !!}
                                            <span class="help-block">Seleccione Departamento</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="form-group">
                                        {!! Form::label('city_birth_id', 'Lugar de Nacimiento', ['class' => 'col-md-5 control-label']) !!}
                                        <div class="col-md-7">
                                            {!! Form::select('city_birth_id', $cities_list, $eco_com_applicant->city_birth_id, ['class' => 'combobox form-control']) !!}
                                            <span class="help-block">Seleccione Departamento</span>
                                        </div>
                                    </div>
                                @endif
                                
                                {{-- <div class="form-group">
                                        {!! Form::label('nua', 'CUA/NUA', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-6">
                                        {!! Form::text('nua', $eco_com_applicant->nua, ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                                        <span class="help-block">Escriba el CUA/NUA</span>
                                    </div>
                                </div> --}}
                                {{--
                                <div class="form-group">
                                        {!! Form::label('phone_number', 'Teléfono fijo', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-6">
                                        <input type="text" id="phone_number" class="form-control" name="phone_number" value="{!! $eco_com_applicant->phone_number !!}" data-inputmask="'mask': '(9) 999 999'" data-mask>
                                        <span class="help-block">Escriba el Teléfono fijo</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                        {!! Form::label('cell_phone_number', 'Teléfono Celular', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-6">
                                        <input type="text" id="cell_phone_number" class="form-control" name="cell_phone_number" value="{!! $eco_com_applicant->cell_phone_number !!}" data-inputmask="'mask': '(999) 99999'" data-mask>
                                        <span class="help-block">Escriba el Teléfono Celular</span>
                                    </div>
                                </div>
                            --}}
                                <div class="form-group" id="phonesNumbersApplicant" style="padding-bottom:5px;">
                                            {!! Form::label('phone_number', 'Teléfono fijo', ['class' => 'col-md-5 control-label']) !!}
                                            @foreach(explode(',',$eco_com_applicant->phone_number) as $key=>$phone)
                                            @if($key>=1)
                                            <div class="col-md-offset-5">
                                            @endif
                                            @if($key>=1)
                                            <div class="col-md-7">
                                            @else
                                            <div class="col-md-6">
                                            @endif
                                                <input type="text" id="phone_number_applicant" class="form-control" name="phone_number_applicant[]" value="{!! $phone !!}" data-inputmask="'mask': '(9) 999-999'" data-mask>
                                            </div>
                                            @if($key>=1)
                                            <div class="col-md-1"><button class="btn btn-warning deletePhone" type="button" ><i class="fa fa-minus"></i></button></div>
                                            @endif

                                            @if($key>=1)
                                            </div>
                                            @endif

                                            @endforeach
                                        </div>
                                        <div class="">
                                            <div class="col-md-offset-6">
                                            <button class="btn btn-success" id="addPhoneNumberApplicant" type="button" ><span class="fa fa-plus"></span></button>
                                            </div>
                                        </div>
                                        <div class="form-group" id="cellPhonesNumbersApplicant" style="padding-bottom:5px;">
                                                {!! Form::label('cell_phone_number', 'Teléfono Celular', ['class' => 'col-md-5 control-label']) !!}
                                                @foreach(explode(',',$eco_com_applicant->cell_phone_number) as $key=>$phone)
                                                @if($key>=1)
                                                <div class="col-md-offset-5">
                                                @endif
                                                @if($key>=1)
                                                <div class="col-md-7">
                                                @else
                                                <div class="col-md-6">
                                                @endif
                                                <input type="text" id="cell_phone_number_applicant" class="form-control" name="cell_phone_number_applicant[]" value="{!! $phone !!}" data-inputmask="'mask': '(999)-99999'" data-mask>
                                                 </div>
                                            @if($key>=1)
                                            <div class="col-md-1"><button class="btn btn-warning deletePhone" type="button" ><i class="fa fa-minus"></i></button></div>
                                            @endif

                                            @if($key>=1)
                                            </div>
                                            @endif

                                                @endforeach
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-offset-6">
                                            <button class="btn btn-success" id="addCellPhoneNumberApplicant"><span class="fa fa-plus"></span></button>
                                            </div>
                                        </div>
                                    </div>
                            	</div>

                        </div>

                        <div class="row text-center">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <a href="{!! url('economic_complement/' . $economic_complement->id) !!}" data-target="#" class="btn btn-raised btn-warning">&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;&nbsp;</a>
                                    &nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-raised btn-success">&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;</button>
                                </div>
                            </div>
                        </div>

                    {!! Form::close() !!} <br />

                </div>
            </div>
        </div>
    </div>
    @if($economic_complement->has_legal_guardian)
    <div id="myModal-guardian" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="box-header with-border">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="box-title">Editar Apoderado</h4>
                </div>
                <div class="modal-body">
                    {!! Form::model($economic_complement, ['method' => 'PATCH', 'route' => ['economic_complement.update', $economic_complement->id], 'class' => 'form-horizontal']) !!}
                        <input type="hidden" name="step" value="legal_guardian"/>
                        <input type="hidden" name="type" value="update"/>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="col-md-12">
                                            {!! Form::label('identity_card_lg', 'Carnet de Identidad', ['class' => 'col-md-5 control-label']) !!}
                                        <div class="col-md-5">
                                            {!! Form::text('identity_card_lg', $economic_complement_legal_guardian->identity_card, ['class'=> 'form-control', 'required']) !!}
                                            <span class="help-block">Número de CI</span>
                                        </div>
                                            {!! Form::select('city_identity_card_id_lg', $cities_list_short, $economic_complement_legal_guardian->city_identity_card_id, ['class' => 'col-md-2 combobox form-control', 'required']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                        {!! Form::label('last_name_lg', 'Apellido Paterno', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-6">
                                        {!! Form::text('last_name_lg', $economic_complement_legal_guardian->last_name, ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                                        <span class="help-block">Escriba el Apellido Paterno</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                        {!! Form::label('mothers_last_name_lg', 'Apellido Materno', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-6">
                                        {!! Form::text('mothers_last_name_lg', $economic_complement_legal_guardian->mothers_last_name, ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                                        <span class="help-block">Escriba el Apellido Materno</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                        {!! Form::label('surname_husband_lg', 'Apellido de Esposo', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-6">
                                        {!! Form::text('surname_husband_lg', $economic_complement_legal_guardian->surname_husband, ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                                        <span class="help-block">Escriba el Apellido de Esposo (Opcional)</span>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                        {!! Form::label('first_name_lg', 'Primer Nombre', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-6">
                                        {!! Form::text('first_name_lg', $economic_complement_legal_guardian->first_name, ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                                        <span class="help-block">Escriba el  Primer Nombre</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                        {!! Form::label('second_name_lg', 'Segundo Nombre', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-6">
                                        {!! Form::text('second_name_lg', $economic_complement_legal_guardian->second_name, ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                                        <span class="help-block">Escriba el Segundo Nombre</span>
                                    </div>
                                </div>
                                <div class="form-group" id="phonesNumbersGuardian" style="padding-bottom:5px;">
                                            {!! Form::label('phone_number_lg', 'Teléfono fijo', ['class' => 'col-md-5 control-label']) !!}
                                            @foreach(explode(',',$economic_complement_legal_guardian->phone_number) as $key=>$phone)
                                            @if($key>=1)
                                            <div class="col-md-offset-5">
                                            @endif
                                            @if($key>=1)
                                            <div class="col-md-7">
                                            @else
                                            <div class="col-md-6">
                                            @endif
                                                <input type="text" id="phone_number_guardian" class="form-control" name="phone_number_lg[]" value="{!! $phone !!}" data-inputmask="'mask': '(9) 999-999'" data-mask>
                                            </div>
                                            @if($key>=1)
                                            <div class="col-md-1"><button class="btn btn-warning deletePhone" type="button" ><i class="fa fa-minus"></i></button></div>
                                            @endif

                                            @if($key>=1)
                                            </div>
                                            @endif

                                            @endforeach
                                        </div>
                                        <div class="">
                                            <div class="col-md-offset-6">
                                            <button class="btn btn-success" id="addPhoneNumberGuardian" type="button" ><span class="fa fa-plus"></span></button>
                                            </div>
                                        </div>
                                        <div class="form-group" id="cellPhonesNumbersGuardian" style="padding-bottom:5px;">
                                                {!! Form::label('cell_phone_number_lg', 'Teléfono Celular', ['class' => 'col-md-5 control-label']) !!}
                                                @foreach(explode(',',$economic_complement_legal_guardian->cell_phone_number) as $key=>$phone)
                                                @if($key>=1)
                                                <div class="col-md-offset-5">
                                                @endif
                                                @if($key>=1)
                                                <div class="col-md-7">
                                                @else
                                                <div class="col-md-6">
                                                @endif
                                                <input type="text" id="cell_phone_number_guardian" class="form-control" name="cell_phone_number_lg[]" value="{!! $phone !!}" data-inputmask="'mask': '(999)-99999'" data-mask>
                                                 </div>
                                            @if($key>=1)
                                            <div class="col-md-1"><button class="btn btn-warning deletePhone" type="button" ><i class="fa fa-minus"></i></button></div>
                                            @endif

                                            @if($key>=1)
                                            </div>
                                            @endif

                                                @endforeach
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-offset-6">
                                            <button class="btn btn-success" id="addCellPhoneNumberGuardian"><span class="fa fa-plus"></span></button>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>

                        <div class="row text-center">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <a href="{!! url('economic_complement/' . $economic_complement->id) !!}" data-target="#" class="btn btn-raised btn-warning">&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;&nbsp;</a>
                                    &nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-raised btn-success">&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;</button>
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!} <br />
                </div>
            </div>
        </div>
    </div>
    @endif
    @if($economic_complement->rent_type == 'Automatico')
        <div id="myModal-totals" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="box-header with-border">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Cálculo del Trámite</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <h4 style="text-align: center">El trámite fue calculado automáticamente</h4>
                        </div>
                    </div>
                    <div class="modal-footer" style="text-align: center">
                    <button type="button" class="btn btn-raised btn-success" data-dismiss="modal"><i class="fa fa-check"></i> Listo</button>
                </div>
                </div>
            </div>
        </div>
    @else
        <div id="myModal-totals" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="box-header with-border">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Editar Totales</h4>
                    </div>
                    <div class="modal-body">
                        {!! Form::model($economic_complement, ['method' => 'PATCH', 'route' => ['economic_complement.update', $economic_complement], 'class' => 'form-horizontal']) !!}
                            <input type="hidden" name="step" value="rent"/>
                            <div class="row">
                                <h4 style="text-align: center">{!!$economic_complement->affiliate->pension_entity->name!!}</h4>
                                <div class="col-md-12">
                                    @if($economic_complement->affiliate->pension_entity->name != 'SENASIR')
                                    <div class="col-md-6">     
                                        <div class="form-group">
                                            {!! Form::label('aps_total_fsa', 'Fraccion de Saldo Acumulado', ['class' => 'col-md-5 control-label']) !!}
                                            <div class="col-md-6">
                                            {!! Form::text('aps_total_fsa', null, ['class' => 'form-control aps', "data-inputmask"=>"'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'"]) !!}
                                                <span class="help-block">Escriba la Fraccion de Saldo Acumulado</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('aps_total_cc', 'Fraccion de Cotizaciones', ['class' => 'col-md-5 control-label']) !!}
                                            <div class="col-md-6">
                                            {!! Form::text('aps_total_cc', null, ['class' => 'form-control aps', "data-inputmask"=>"'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'"]) !!}
                                                <span class="help-block">Escriba la Fraccion de Cotizaciones</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('aps_total_fs', 'Fraccion Solidaria', ['class' => 'col-md-5 control-label']) !!}
                                            <div class="col-md-6">
                                            {!! Form::text('aps_total_fs', null, ['class' => 'form-control aps', "data-inputmask"=>"'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'"]) !!}
                                                <span class="help-block">Escriba la Fraccion solidaria</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('total_frac', 'Total Fracciones', ['class' => 'col-md-5 control-label']) !!}
                                            <div class="col-md-6">
                                            {!! Form::text('total_frac', null, ['class' => 'form-control',"data-inputmask"=>"'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'", 'readonly']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('sub_total_rent', 'Renta Total Boleta', ['class' => 'col-md-5 control-label']) !!}
                                            <div class="col-md-6">
                                            {!! Form::text('sub_total_rent', null, ['class' => 'form-control rent', 'required' => 'required',"data-inputmask"=>"'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'"]) !!}
                                                <span class="help-block">Escriba la Renta total boleta</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('reimbursement', 'Reintegro', ['class' => 'col-md-5 control-label']) !!}
                                            <div class="col-md-6">
                                            {!! Form::text('reimbursement', null, ['class'=> 'form-control rent',"data-inputmask"=>"'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'"]) !!}
                                                <span class="help-block">Escriba el reintegro</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('dignity_pension', 'Renta Dignidad', ['class' => 'col-md-5 control-label',"data-inputmask"=>"'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'"]) !!}
                                            <div class="col-md-6">
                                                {!! Form::text('dignity_pension', null, ['class'=> 'form-control rent',"data-inputmask"=>"'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'"]) !!}
                                                <span class="help-block">Escriba la renta dignidad</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('total_rent', 'Total Renta', ['class' => 'col-md-5 control-label']) !!}
                                            <div class="col-md-6">
                                            {!! Form::text('total_rent', null, ['class' => 'form-control',"data-inputmask"=>"'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'", 'readonly']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="togglebutton">
                                                <label class="col-md-5 control-label">
                                                    <input type="checkbox" data-bind="checked: concurrenceCheck" name="concurrenceCheck"> Concurrencia
                                                </label>
                                            </div>
                                        </div>
                                        <div data-bind='visible: concurrenceCheck'>
                                            <div class="form-group">
                                                {!! Form::label('aps_disability', 'Concurrencia - Renta Invalidez', ['class' => 'col-md-5 control-label']) !!}
                                                <div class="col-md-6">
                                                {!! Form::text('aps_disability', null, ['class' => 'form-control aps_disability',"data-inputmask"=>"'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits': 2, 'digitsOptional': false,'placeholder': '0'"]) !!}
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="row text-center">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <a href="{!! url('economic_complement/'.$economic_complement->id) !!}" class="btn btn-raised btn-warning" data-toggle="tooltip" data-placement="bottom" data-original-title="Cancelar">&nbsp;<i class="glyphicon glyphicon-remove"></i>&nbsp;</a>
                                        &nbsp;&nbsp;
                                        <button type="submit" class="btn btn-raised btn-success" data-toggle="tooltip" data-placement="bottom" data-original-title="Guardar">&nbsp;<i class="glyphicon glyphicon-floppy-disk"></i>&nbsp;</button>
                                    </div>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div id="myModal-totals-print" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="box-header with-border">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Imprimiendo Calculo de complemento</h4>
                </div>
                <div class="modal-body">
                    {!! Form::model($economic_complement, ['method' => 'PATCH', 'route' => ['economic_complement.update', $economic_complement], 'class' => 'form-horizontal']) !!}
                        <input type="hidden" name="step" value="print_total"/>
                        <div class="row">
                            <div class="form-group">
                                {!! Form::label('comment', 'Nota: ', ['class' => 'col-md-3 control-label']) !!}
                                <div class="col-md-8">
                                {!! Form::textarea('comment', null, ['class' => 'form-control rent', 'required' => 'required','rows' => '3', 'id'=>'comment']) !!}
                                    <span class="help-block">Escriba una nota {{-- (Caracteres restantes <span id="comment_count"></span>)</span> --}}
                                </div>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <a href="{!! url('economic_complement/'.$economic_complement->id) !!}" class="btn btn-raised btn-warning" data-toggle="tooltip" data-placement="bottom" data-original-title="Cancelar">&nbsp;<i class="glyphicon glyphicon-remove"></i>&nbsp;</a>
                                    &nbsp;&nbsp;
                                    <button type="submit" class="btn btn-raised btn-success" data-toggle="tooltip" data-placement="bottom" data-original-title="Guardar e Imprimir">&nbsp;<i class="glyphicon glyphicon-floppy-disk"></i>&nbsp;</button>
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <div id="myModal-totals-print-old" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="box-header with-border">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Imprimiendo Calculo de complemento (Trámite Anterior)</h4>
                </div>
                <div class="modal-body">
                    {!! Form::model($economic_complement, ['method' => 'PATCH', 'route' => ['economic_complement.update', $economic_complement], 'class' => 'form-horizontal']) !!}
                        <input type="hidden" name="step" value="print_total_old"/>
                        <div class="row">
                            <div class="form-group">
                                {!! Form::label('comment', 'Nota: ', ['class' => 'col-md-3 control-label']) !!}
                                <div class="col-md-8">
                                {!! Form::textarea('comment', null, ['class' => 'form-control rent', 'required' => 'required','rows' => '3']) !!}
                                    <span class="help-block">Escriba una nota</span>
                                </div>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <a href="{!! url('economic_complement/'.$economic_complement->id) !!}" class="btn btn-raised btn-warning" data-toggle="tooltip" data-placement="bottom" data-original-title="Cancelar">&nbsp;<i class="glyphicon glyphicon-remove"></i>&nbsp;</a>
                                    &nbsp;&nbsp;
                                    <button type="submit" class="btn btn-raised btn-success" data-toggle="tooltip" data-placement="bottom" data-original-title="Guardar e Imprimir">&nbsp;<i class="glyphicon glyphicon-floppy-disk"></i>&nbsp;</button>
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>    
    <div id="myModal-requirements" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="box-header with-border">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Editar Documentos</h4>
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
                        <input type="hidden" name="id_complemento" value={{$economic_complement->id}} >
                        <br>
                        <div class="row text-center">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <a href="{!! url('economic_complement/' . $economic_complement->id) !!}" data-target="#" class="btn btn-raised btn-warning">&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;&nbsp;</a>
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
    @if($economic_complement->reception_type == 'Habitual')
    <div id="myModal-requirements-ar" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="box-header with-border">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Editar Documentos Pendientes</h4>
                </div>
                <div class="box-body" data-bind="event: {mouseover: save_ar, mouseout: save_ar}">
                    {!! Form::model($last_ecocom, ['method' => 'PATCH', 'route' => ['economic_complement.update', $last_ecocom->id], 'class' => 'form-horizontal']) !!}
                        <input type="hidden" name="step" value="requirements"/>
                        <input type="hidden" name="ecocom" value="{{$economic_complement->id}}"/>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-hover" style="font-size: 16px">
                                    <thead>
                                        <tr class="success">
                                            <th class="text-center">Requisitos</th>
                                            <th class="text-center">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody data-bind="foreach: requirements_ar">
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
                        <input type="hidden" name="id_complemento" value={{$economic_complement->id}} >
                        {!! Form::hidden('data', null, ['data-bind'=> 'value: lastSavedJson_ar']) !!}
                        <br>
                        <div class="row text-center">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <a href="{!! url('economic_complement/' . $economic_complement->id) !!}" data-target="#" class="btn btn-raised btn-warning">&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;&nbsp;</a>
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
    @endif
    <div id="myModal-block" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="box-header with-border">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Suspender o Excluir</h4>
                </div>
                <div class="modal-body">
                    {!! Form::model($economic_complement, ['method' => 'PATCH', 'route' => ['economic_complement.update', $economic_complement->id], 'class' => 'form-horizontal']) !!}
                        <input type="hidden" name="step" value="block"/>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="form-group">
                                    {!! Form::label('eco_com_state_id', 'Estado', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::select('eco_com_state_id', $eco_com_states_block_list, '', ['class' => 'combobox form-control']) !!}
                                        <span class="help-block">Seleccione Estado</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row text-center">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <a href="{!! url('economic_complement/' . $economic_complement->id) !!}" data-target="#" class="btn btn-raised btn-warning">&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;&nbsp;</a>
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
    <div id="myModal-confirm" class="modal fade">
        <div class="modal-dialog">
            <div class="alert alert-dismissible alert-info">
                <div class="modal-body text-center">
                    {!! Form::model($economic_complement, ['method' => 'PATCH', 'route' => ['economic_complement.update', $economic_complement->id], 'class' => 'form-horizontal']) !!}
                        <input type="hidden" name="step" value="pass"/>
                        <p><br>
                        <div><h4>¿ Está seguro que revisó correctamente?</h4></div>
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
                    {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div id="myModal-revert" class="modal fade">
        <div class="modal-dialog">
            <div class="alert alert-dismissible alert-danger">
                <div class="modal-body text-center">
                    {!! Form::model($economic_complement, ['method' => 'PATCH', 'route' => ['economic_complement.update', $economic_complement->id], 'class' => 'form-horizontal']) !!}
                        <input type="hidden" name="step" value="revert"/>
                        <p><br>
                        <div><h4>¿ Está seguro que revertir el tramite?</h4></div>
                            </p>
                        </div>
                        <div class="row text-center">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-raised btn-default" data-dismiss="modal">&nbsp;<span class="glyphicon glyphicon-remove"></span>&nbsp;</button>
                                    &nbsp;&nbsp;&nbsp;
                                    <button type="submit" class="btn btn-raised btn-default" data-toggle="tooltip" data-placement="bottom" data-original-title="aceptar">&nbsp;<span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;</button>
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div id="myModal-edit" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="box-header with-border">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Editar Información Adicional</h4>
                </div>
                <div class="modal-body">
                    {!! Form::model($economic_complement, ['method' => 'PATCH', 'route' => ['economic_complement.update', $economic_complement->id], 'class' => 'form-horizontal']) !!}
                        <input type="hidden" name="step" value="edit_aditional_info"/>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="form-group">
                                    {!! Form::label('eco_com_state_id', 'Estado', ['class' => 'col-md-5 control-label']) !!}

                                    <div class="col-md-7">
                                        {!! Form::select('eco_com_state_type_id', $eco_com_state_type_lists, '', ['class' => 'combobox form-control', 'id' => 'state']) !!}
                                        <span class="help-block">Seleccione Estado</span>
                                    </div>
                                </div>


                                <div class="form-group">
                                    {!! Form::label('semester', 'Seleccione causa ', ['class' => 'col-md-5 control-label']) !!}

                                    <div class="col-md-7">
                                        {!! Form::select('cause',[],'', ['class' => 'combobox form-control', 'id' => 'causes']) !!}
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row text-center">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <a href="{!! url('economic_complement/' . $economic_complement->id) !!}" data-target="#" class="btn btn-raised btn-warning">&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;&nbsp;</a>
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
    <div id="policeModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="box-header with-border">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Editar Información de Policía</h4>
                        </div>
                        <div class="modal-body">
                            {!! Form::model($affiliate, ['method' => 'PATCH', 'route' => ['affiliate.update', $affiliate], 'class' => 'form-horizontal']) !!}
                            <input type="hidden" name="type" value="institutional_eco_com"/>
                            <input type="hidden" name="economic_complement_id" value="{{ $economic_complement->id }}"/>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                                {!! Form::label('date_entry', 'Fecha de Ingreso', ['class' => 'col-md-5 control-label']) !!}
                                            <div class="col-md-7">
                                                <div class="input-group">
                                                    <input type="text" id="date_entry" class="form-control" name="date_entry" value="{!! $affiliate->getEditDateEntry() !!}" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
                                                    <div class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                                {!! Form::label('item', 'Num de Item', ['class' => 'col-md-5 control-label']) !!}
                                            <div class="col-md-7">
                                            {!! Form::text('item', $affiliate->item, ['class'=> 'form-control',  'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                                           <span class="help-block">Escriba el Numero de item</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                                {!! Form::label('service_years', 'Años de servicio', ['class' => 'col-md-5 control-label']) !!}
                                            <div class="col-md-5">
                                                {!! Form::text('service_years',$affiliate->service_years, ['class'=> 'form-control']) !!}
                                                <span class="help-block">Escriba los años de servicio</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                                {!! Form::label('service_months', 'Meses de servicio', ['class' => 'col-md-5 control-label']) !!}
                                            <div class="col-md-5">
                                                {!! Form::text('service_months',$affiliate->service_months, ['class'=> 'form-control']) !!}
                                                <span class="help-block">Escriba los meses de servicio</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                                {!! Form::label('category', 'Categoria', ['class' => 'col-md-5 control-label']) !!}
                                            <div class="col-md-7">
                                                {!! Form::select('category',$categories, $economic_complement->category_id , ['class'=> 'form-control', 'required','id'=>'category']) !!}
                                                <span class="help-block">Seleccione una Categoria para el policía</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">

                                         <div class="form-group">
                                                {!! Form::label('degree', 'Grado', ['class' => 'col-md-5 control-label']) !!}
                                            <div class="col-md-7">
                                                {!! Form::select('degree',$degrees, $economic_complement->degree->id ?? null , ['class'=> 'combobox form-control', 'required']) !!}
                                                <span class="help-block">Seleccione un grado del policía</span>
                                            </div>
                                        </div>

                                                {{--<div class="form-group">
                                                        {!! Form::label('unit', 'Unidad', ['class' => 'col-md-5 control-label']) !!}
                                                    <div class="col-md-7">
                                                        {!! Form::select('unit',$units, $affiliate->unit_id , ['class'=> 'combobox form-control', 'required']) !!}
                                                        <span class="help-block">Seleccione una unidad del policía</span>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                        {!! Form::label('registration', 'Num de Matrícula', ['class' => 'col-md-5 control-label']) !!}
                                                    <div class="col-md-7">
                                                    {!! Form::text('registration', $affiliate->registration, ['class'=> 'form-control',  'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                                                   <span class="help-block">Escriba el Numero de Matrícula</span>
                                                    </div>
                                                </div> --}}
                                        <div class="form-group">
                                                    {!! Form::label('regional', 'Regional', ['class' => 'col-md-5 control-label']) !!}
                                            <div class="col-md-7">
                                                {!! Form::select('regional', $cities_list, $economic_complement->city_id, ['class' => 'combobox form-control']) !!}
                                                <span class="help-block">Seleccione Regional</span>
                                            </div>
                                        </div>
                                         <div class="form-group">
                                                {!! Form::label('affiliate_entity_pension', 'Ente Gestor', ['class' => 'col-md-5 control-label']) !!}
                                            <div class="col-md-7">
                                                {!! Form::select('affiliate_entity_pension',$entity_pensions, $affiliate->pension_entity->id , ['class'=> 'combobox form-control', 'required']) !!}
                                                <span class="help-block">Seleccione un ente gestor</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row text-center">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <a href="{!! url('economic_complement/' . $economic_complement->id) !!}" data-target="#" class="btn btn-raised btn-warning">&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;&nbsp;</a>
                                            &nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-raised btn-success">&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;</button>
                                        </div>
                                    </div>
                                </div>

                            {!! Form::close() !!}

                        </div>
                    </div>
                </div>
    </div>
    <div id="recordEcoModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="box-header with-border">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Historial del Tramite</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-hover" id="recordEcoTable" width="100%">
                        <thead>
                            <tr class="success">
                                <th>Fecha</th>
                                <th>descripción</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="statusDocumentsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Estado de los Documentos Presentados</h4>
                </div>
                <div class="modal-body">
                    @if($status_documents_ar)
                    <h3>Todos los documentos presentados</h3>
                    <table class="table table-bordered table-hover" style="width:100%;font-size: 14px">
                        <thead>
                            <tr>
                                <th>Nombre de Requisito</th>
                                <th>Fecha</th>
                                <th class="text-center">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($eco_com_submitted_documents_ar as $item)
                            <tr>
                                <td>{!! $item->economic_complement_requirement->shortened !!}</td>
                                <td>{!! Util::getDateShort($item->reception_date) !!}</td>
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
                <div class="modal-footer" style="text-align: center">
                    <button type="button" class="btn btn-success" data-dismiss="modal"><i class="fa fa-check"></i> Listo</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="myModal-review-user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-body">
                @if( $economic_complement->stateOf())
                    <h3>Tramite Revisado por: {{ $economic_complement->getUser() }}</h3>
                    <strong>El {{ $economic_complement->getReviewDate() }}</strong>

                @else
                    <h3>Tramite no revisado.</h3>
                @endif
                </div>
                <div class="modal-footer" style="text-align: center">
                    <button type="button" class="btn btn-success" data-dismiss="modal"><i class="fa fa-check"></i> Listo</button>
                </div>
            </div>
        </div>
    </div>
    <form  action="{{url('save_amortization')}}" method="POST">
            
        
        
        <div id="amortization-modal" class="modal fade" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                 <input type="hidden" name="_token" value="{{ csrf_token() }}">  
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Amortizar</h4>
              </div>
              <div class="modal-body">
                <div class="row">
                    <label>Monto :</label> <input type="number" required  step="any" name="amount_amortization" class="form-control">
                    <input type="hidden" name="id_complemento" value="{{$economic_complement->id}}">
                </div>
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar </button>
              </div>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

    </form>

    <form  action="{{url('moreInfo')}}" method="POST">
        
        <div id="addMoreInfo" class="modal fade" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                 <input type="hidden" name="_token" value="{{ csrf_token() }}">  
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> Adicionar Informacion </h4>
              </div>
              <div class="modal-body">
                <div class="row">

                    <input type="hidden" name="id_complemento" value="{{$economic_complement->id}}">

                    @can("accounting")
                    <label>Nro de Comprobante :</label> <input type="number" required name="number_accounting" class="form-control">
                    @endcan

                    @can("loan")
                    <label>Certificacion Presupuestaria :</label> <input type="text" required   name="number_budget" class="form-control">
                    @endcan

                    @can("treasury")
                    <label>Numero de Checke :</label> <input type="number" required  name="number_check" class="form-control">
                    @endcan

                </div>
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar </button>
              </div>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

    </form>
    @if($wf_state_before)
    <form  action="{{url('retroceso_de_tramite')}}" method="POST">
            
        
        <div id="back-modal" class="modal fade modal-warning" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                 <input type="hidden" name="_token" value="{{ csrf_token() }}">  
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Retroceso de Tramite</h4>
              </div>
              <div class="modal-body">
              
                    Esta seguro de enviar el tramite de <strong> {{$economic_complement->wf_state->name }}</strong>  a  <strong>{{ $wf_state_before->name }} ?</strong>
                <input type="hidden" name="id_complemento" value="{{$economic_complement->id}}">    
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-raised btn-default" data-dismiss="modal">No</button>
                <button type="submit" class="btn btn-raised btn-danger">Si </button>
              </div>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

    </form>
    @endif

@include('observations.create')

@endsection

@push('scripts')
<script>
//for modal of status submitted documents
$(document).ready(function() {
   @if($status_eco_com_submitted_documents_ar)
        $('#statusDocumentsModal').modal('show');
   @endif
});

	function printTrigger(elementId) {
        var getMyFrame = document.getElementById(elementId);
        getMyFrame.focus();
        getMyFrame.contentWindow.print();
    }

	$(document).ready(function(){
		$('.combobox').combobox();
	    $('[data-toggle="tooltip"]').tooltip();
		$("#birth_date_mask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/aaaa"});
		$("#date_death_spouse_mask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/aaaa"});
    $("#date_death_mask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/aaaa"});

		$("#phone_number").inputmask();
        $("#cell_phone_number").inputmask();
        $("#phone_number_guardian").inputmask();
        $('#date_entry').inputmask();
		$("#cell_phone_number_guardian").inputmask();

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
    var affiliate = {!!$affiliate!!};
	function SelectRequeriments(requirements,requirements_ar) {

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

        @if($eco_com_type=='VIUDEDAD')
             self.DateDeathAffiliateValue = ko.observable(true);
        @else
             self.DateDeathAffiliateValue = ko.observable(affiliate.date_death ? true : false);
        @endif
       

        @if ($status_documents_ar)
            self.requirements_ar = ko.observableArray(ko.utils.arrayMap(requirements_ar, function(document) {
            return { id: document.eco_com_requirement_id, name: document.economic_complement_requirement.shortened, status: document.status };
            }));
        @else
            self.requirements_ar = ko.observableArray(ko.utils.arrayMap(requirements_ar, function(document) {
            return { id: document.id, name: document.shortened, status: false };
            }));
        @endif

        self.save_ar = function() {
            var dataToSave_ar = $.map(self.requirements_ar(), function(requirement_ar) {
                return  {
                    id: requirement_ar.id,
                    name: requirement_ar.name,
                    status: requirement_ar.status
                }
            });
            self.lastSavedJson_ar(JSON.stringify(dataToSave_ar));
        };
        self.lastSavedJson_ar = ko.observable("");


	};
    @if($status_documents)
        @if($status_documents_ar)
            window.model = new SelectRequeriments({!! $eco_com_submitted_documents !!}, {!! $eco_com_submitted_documents_ar !!});
        @else
    		window.model = new SelectRequeriments({!! $eco_com_submitted_documents !!}, {!! $eco_com_requirements_ar !!});
        @endif
	@else
        @if($status_documents_ar)
            window.model = new SelectRequeriments({!! $eco_com_requirements !!}, {!! $eco_com_submitted_documents_ar !!});
        @else
            window.model = new SelectRequeriments({!! $eco_com_requirements !!}, {!! $eco_com_requirements_ar !!});
        @endif
	@endif

	

    var selectedlModel = function() {        
        var self = this;
        @if($eco_com_applicant->date_death)
            self.selected = ko.observable(true);
        @else
            self.selected = ko.observable(false);
        @endif
        self.concurrenceCheck = ko.observable({{ ($economic_complement->aps_disability > 0 ) ? true:false }});
    }

    // ko.applyBindings();
    ko.applyBindings(model,selectedlModel());

    // $(document).ready(function() {
    //     $('#comment').on('keyup', function(e) {
    //         var value=$('#comment').val();
    //         var l=value.length;
    //         var remain = parseInt(300 - l);
    //         $('#comment_count').text(remain);
    //         if (remain <= 0 ) {
    //             $('#comment').val((value).substring(0, l - 1));
    //                 return false;
    //         }
    //         e.preventDefault();
    //     });
    // });
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

    //for phone numbers legal guardians
    $('#addPhoneNumberGuardian').on('click', function(event) {
        $('#phonesNumbersGuardian').append('<div class="col-md-offset-5"><div class="col-md-7"><input type="text" class="form-control" name="phone_number_lg[]" data-inputmask="\'mask\': \'(9) 999-999\'" data-mask></div><div class="col-md-1"><button class="btn btn-warning deletePhone" type="button" ><i class="fa fa-minus"></i></button></div></div>')
        event.preventDefault();
        $("input[name='phone_number_lg[]']").each(function() {
            $(this).inputmask();
        });
        $("input[name='phone_number_lg[]']").last().focus();
    });
    $('#addCellPhoneNumberGuardian').on('click', function(event) {
        $('#cellPhonesNumbersGuardian').append('<div class="col-md-offset-5"><div class="col-md-8"><input type="text" class="form-control" name="cell_phone_number_lg[]" data-inputmask="\'mask\': \'(999)-99999\'" data-mask></div><div class="col-md-1"><button class="btn btn-warning deleteCellPhone" type="button" ><i class="fa fa-minus"></i></button></div></div>')
        event.preventDefault();
        $("input[name='cell_phone_number_lg[]']").each(function() {
            $(this).inputmask();
        });
        $("input[name='cell_phone_number_lg[]']").last().focus();
    });

    //for phone numbers Applicant
    $("#phone_number_applicant").inputmask();
    $("#cell_phone_number_applicant").inputmask();
    $('#addPhoneNumberApplicant').on('click', function(event) {
        $('#phonesNumbersApplicant').append('<div class="col-md-offset-5"><div class="col-md-7"><input type="text" class="form-control" name="phone_number_applicant[]" data-inputmask="\'mask\': \'(9) 999-999\'" data-mask></div><div class="col-md-1"><button class="btn btn-warning deletePhone" type="button" ><i class="fa fa-minus"></i></button></div></div>')
        event.preventDefault();
        $("input[name='phone_number_applicant[]']").each(function() {
            $(this).inputmask();
        });
        $("input[name='phone_number_applicant[]']").last().focus();
    });
    $(document).on('click', '.deletePhone', function(event) {
        $(this).parent().parent().remove();
        event.preventDefault();
    });
    //for cell phone numbers Applicant
    $('#addCellPhoneNumberApplicant').on('click', function(event) {
        $('#cellPhonesNumbersApplicant').append('<div class="col-md-offset-5"><div class="col-md-8"><input type="text" class="form-control" name="cell_phone_number_applicant[]" data-inputmask="\'mask\': \'(999)-99999\'" data-mask></div><div class="col-md-1"><button class="btn btn-warning deleteCellPhone" type="button" ><i class="fa fa-minus"></i></button></div></div>')
        event.preventDefault();
        $("input[name='cell_phone_number_applicant[]']").each(function() {
            $(this).inputmask();
        });
        $("input[name='cell_phone_number_applicant[]']").last().focus();
    });
    $(document).on('click', '.deleteCellPhone', function(event) {
        $(this).parent().parent().remove();
        event.preventDefault();
    });
    //for record of econmic complement
    $(document).ready(function() {

        $('#recordEcoTable').DataTable({
            "dom": '<"top">t<"bottom"p>',
            processing: true,
            serverSide: true,
            pageLength: 12,
            bFilter: false,
            ajax: {
                url: '{!! route('get_economic_complement_record') !!}',
                data: function (d) {
                    d.id = {{ $economic_complement->id }};
                }
            },
            columns: [
                { data: 'date' },
                { data: 'message', bSortable: false }
            ]
        });

    });

    //for calculation
    $(document).ready(function() {
        $("#aps_total_fsa").inputmask();
        $("#aps_total_fs").inputmask();
        $("#aps_total_cc").inputmask();
        $("#sub_total_rent").inputmask();
        $("#reimbursement").inputmask();
        $("#dignity_pension").inputmask();
        $("#aps_disability").inputmask();
        $('#total_frac').inputmask();
        $('#myModal-totals').on('show.bs.modal',function () {
            var total=0;
            var aps_total_fs =  document.getElementById('aps_total_fs');
            if (typeof(aps_total_fs) != 'undefined' && aps_total_fs != null)
            {
                aps_total_fs=parseCurrency($("#aps_total_fs").val());
                total+=aps_total_fs;
            }
            var aps_total_fsa =  document.getElementById('aps_total_fsa');
            if (typeof(aps_total_fsa) != 'undefined' && aps_total_fsa != null)
            {
                aps_total_fsa=parseCurrency($("#aps_total_fsa").val());
                total+=aps_total_fsa;
            }
            var aps_total_cc =  document.getElementById('aps_total_cc');
            if (typeof(aps_total_cc) != 'undefined' && aps_total_cc != null)
            {
                aps_total_cc=parseCurrency($("#aps_total_cc").val());
                total+=aps_total_cc;
            }
            $('#total_frac').val(total);
        });
        function parseCurrency(mount) {
            return (isNaN(mount) || mount !='')  ? parseFloat(mount.toString().replace(/,/g,'')):0;
        }

        $('.aps').keyup(function (event) {
            var aps_total_fsa=parseCurrency($("#aps_total_fsa").val());
            var aps_total_fs=parseCurrency($("#aps_total_fs").val());
            var aps_total_cc=parseCurrency($("#aps_total_cc").val());
            // console.log(aps_total_fsa+" "+aps_total_fs+" "+aps_total_cc);
            var total=aps_total_fsa+aps_total_fs+aps_total_cc;
            $('#total_frac').val(total);
            // $('#sub_total_rent').val(total);
        });
        var total_rent =  document.getElementById('total_rent');
        if (typeof(total_rent) != 'undefined' && total_rent != null)
        {
            total_rent=parseCurrency($("#total_rent").val());
        }
        $('.rent').keyup(function (event) {
            var sub_total_rent=parseCurrency($("#sub_total_rent").val());
            var reimbursement=parseCurrency($("#reimbursement").val());
            var dignity_pension=parseCurrency($("#dignity_pension").val());
            var aps_disability=parseCurrency($("#aps_disability").val());
            var total=sub_total_rent - reimbursement - dignity_pension + aps_disability;
            $('#total_rent').val(total.toFixed(2));
            total_rent = parseCurrency($('#total_rent').val());
        });


        $('.aps_disability').keyup(function (event) {
            var aps_disability = parseCurrency($(this).val());
            var sub_total_rent=parseCurrency($("#sub_total_rent").val());
            var reimbursement=parseCurrency($("#reimbursement").val());
            var dignity_pension=parseCurrency($("#dignity_pension").val());
            var aps_disability=parseCurrency($("#aps_disability").val());
            var total=sub_total_rent - reimbursement - dignity_pension + aps_disability;
            $('#total_rent').val(total.toFixed(2));
        });

        //temp calc
        @if($economic_complement->amount_loan > 0 || $economic_complement->amount_accounting > 0 || $economic_complement->amount_replacement > 0)
        var amount_loan = {{ $economic_complement->amount_loan ??  0}} ;
        var amount_accounting = {{ $economic_complement->amount_accounting ??  0}};
        var amount_replacement = {{ $economic_complement->amount_replacement ??  0}};
        var total = {{ $economic_complement->total ?? 0 }};
        var temp_total = total + amount_loan + amount_accounting + amount_replacement;
        $('#tempTotal').text(temp_total.toFixed(2));
        @endif

        //for category
        //
        var year = {{ $affiliate->service_years ??  0}};
        var month = {{ $affiliate->service_months ??  0}};
        $("#service_years").inputmask('numeric',{min:0, max:100});
        $('#service_years').on('keyup',function(event) {
            year = $(this).val();
            $.ajax({
                url: '{{ route('get_category') }}',
                type: 'GET',
                data: {
                    service_years: year,
                    service_months: month
                },
            })
            .done(function(data) {
                if(data!= "error"){
                    $('#category').val(data.id);
                }
            });
        });
        $("#service_months").inputmask('numeric',{min:0, max:12});
        $('#service_months').on('keyup',function(event) {
            month = $(this).val();
            $.ajax({
                url: '{{ route('get_category') }}',
                type: 'GET',
                data: {
                    service_years: year,
                    service_months: month
                },
            })
            .done(function(data) {
                if(data!= "error"){
                    $('#category').val(data.id);
                }
            });
        });
    });
</script>
@endpush
