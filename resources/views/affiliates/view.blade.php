@extends('app')

@section('contentheader_title')

    <div class="row">
        <div class="col-md-6">
            {!! Breadcrumbs::render('show_affiliate', $affiliate) !!}
        </div>
        <div class="col-md-6">
       @can('manage')
            <div class="btn-group" data-toggle="tooltip" data-placement="top" data-original-title="Aportes" style="margin: 0;">
                <a href="" class="btn btn-success btn-raised bg-orange" data-toggle="dropdown"><i class="fa fa-arrow-circle-down fa-lg"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="{!! url('show_contributions/' . $affiliate->id) !!}" class="text-center"><i class="glyphicon glyphicon-eye-open"></i>Ver</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="{!! url('select_contribution/' . $affiliate->id) !!}" class="text-center"><i class="glyphicon glyphicon-plus"></i>Crear</a></li>
                </ul>
            </div>
        @endcan
        @can('loan')
            <div class="btn-group" data-toggle="tooltip" data-placement="top" data-original-title="Préstamos" style="margin: 0;">
                <a href="" class="btn btn-success btn-raised bg-orange" data-toggle="dropdown"><i class="fa fa-money fa-lg"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="#"  class="text-center"><i class="glyphicon glyphicon-plus"></i>Crear</a></li>
                </ul>
            </div>
        @endcan
        @can('retirement_fund')
            <div class="btn-group" data-toggle="tooltip" data-placement="top" data-original-title="Fondo Retiro" style="margin: 0;">
                <a href="" class="btn btn-success btn-raised bg-orange" data-toggle="dropdown"><i class="glyphicon glyphicon-piggy-bank"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="#"  class="text-center"><i class="glyphicon glyphicon-plus"></i>Crear</a></li>
                </ul>
            </div>
        @endcan
        @can('eco_com_reception')
            @if($has_current_eco_com=="edit")
                <div class="btn-group" data-toggle="tooltip" data-placement="top" data-original-title="Complemento  Económico" style="margin: 0;">
                    <a href="" class="btn btn-success btn-raised bg-orange" data-toggle="dropdown"><i class="fa fa-puzzle-piece fa-lg"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="{!! url('economic_complement/'.$affiliate->id) !!}" class="text-center"><i class="fa fa-eye"></i>Ver</a></li> 
                    </ul>
                </div>
            @endif
            @if($has_current_eco_com=="create")
                <div class="btn-group" data-toggle="tooltip" data-placement="top" data-original-title="Complemento  Económico" style="margin: 0;">
                    <a href="" class="btn btn-success btn-raised bg-orange" data-toggle="dropdown"><i class="fa fa-puzzle-piece fa-lg"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="{!! url('economic_complement_reception_first_step/' . $affiliate->id) !!}"  class="text-center"><i class="glyphicon glyphicon-plus"></i>Crear</a></li>
                    </ul>
                </div>
            @endif
        @endcan
        @can('manage')
            <div class="btn-group" data-toggle="tooltip" data-placement="top" data-original-title="Cuota Auxilio" style="margin: 0;">
                <a href="" class="btn btn-success btn-raised bg-orange" data-toggle="dropdown"><i class="fa fa-heartbeat fa-lg"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="#"  class="text-center"><i class="glyphicon glyphicon-plus"></i>Crear</a></li>
                </ul>
            </div>
        @endcan
            <!-- button of Observations -->
            <div class="btn-group" data-toggle="tooltip" data-placement="top" data-original-title="Observaciones" style="margin: 0;">
                <a href="" class="btn btn-success btn-raised bg-red" data-toggle="modal" data-target="#observationModal"><i class="fa fa-eye fa-lg"></i></a>
            </div>
            <!-- /button of  Observations -->
            {{--<div class="btn-group" data-toggle="tooltip" data-placement="top" data-original-title="Imprimir" style="margin:0px;">--}}
                {{--<a href="" class="btn btn-raised btn-success dropdown-toggle enabled" data-toggle="modal" value="Print" onclick="printTrigger('iFramePdf');" >--}}
                    {{--&nbsp;<span class="glyphicon glyphicon-print"></span>&nbsp;--}}
                {{--</a>--}}
            {{--</div>--}}
            {{-- <div class="btn-group" data-toggle="tooltip" data-placement="top" data-original-title="Caratula Imprimir" style="margin:0px;">
                <a href="" class="btn btn-raised btn-success dropdown-toggle enabled" data-toggle="modal" value="Print" onclick="printTrigger('iFramePdf');" >
                    &nbsp;<span class="glyphicon glyphicon-file"></span>&nbsp;
                </a>
            </div> --}}

        </div>
    </div>

@endsection
@section('main-content')
@include('observations.create')

    <div class="row">
        <div class="col-md-6">
            <div class="box box-success box-solid">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-10">
                            <h3 class="box-title"><i class="fa fa-{{$affiliate->gender=='M'?'male':'female'  }}"></i> Información Personal</h3>
                        </div>
                        <div class="col-md-2 text-right">
                            <div data-toggle="tooltip" data-placement="left" data-original-title="Editar">
                                <a href="" class="btn btn-sm bg-olive" data-toggle="modal" data-target="#myModal-personal">
                                    <span class="fa fa-lg fa-pencil" aria-hidden="true"></span>
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
                                                <strong>Carnet Identidad:</strong>
                                            </div>
                                            <div class="col-md-6">
                                                {!! $affiliate->identity_card !!} {!! $affiliate->city_identity_card !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
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
                               
                                <tr>
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Apellido de Esposo:</strong>
                                            </div>
                                            <div class="col-md-6">
                                                @if ($affiliate->surname_husband)
                                                    {!! $affiliate->surname_husband !!}
                                                @endif
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
                                                <strong>Sexo:</strong>
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
                                                <strong>Lugar Nacimiento:</strong>
                                            </div>
                                            <div class="col-md-6">
                                                 {!! $affiliate->city_birth !!}
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

            <div class="box box-success box-solid">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-10">
                            <h3 class="box-title"><span class="glyphicon glyphicon-home"></span> Información de Domicilio</h3>
                        </div>
                        @if($info_address)
                            <div class="col-md-2 text-right">
                                <div data-toggle="tooltip" data-placement="left" data-original-title="Editar">
                                    <a href="" class="btn btn-sm bg-olive" data-toggle="modal" data-target="#myModal-address">
                                        <span class="fa fa-lg fa-pencil" aria-hidden="true"></span>
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">

                        @if($info_address)

                            <div class="col-md-6">

                                <table class="table" style="width:100%;">
                                    <tr>
                                        <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>Departamento:</strong>
                                                </div>
                                                <div class="col-md-6">
                                                    {!! $AffiliateAddress->city_address !!}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>Zona:</strong>
                                                </div>
                                                <div class="col-md-6">
                                                    {!! $AffiliateAddress->zone !!}
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
                                                    <strong>Calle, Avenida:</strong>
                                                </div>
                                                <div class="col-md-6">
                                                    {!! $AffiliateAddress->street !!}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>Núm Domicilio</strong>
                                                </div>
                                                <div class="col-md-6">
                                                    {!! $AffiliateAddress->number_address !!}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>

                            </div>
                        @else
                            <div class="row text-center">
                                <div data-toggle="modal" data-target="#myModal-address">
                                    <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Adicionar Domicilio">
                                        <img class="circle" src="{!! asset('img/home.png') !!}" width="40px" alt="icon">
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="box box-success box-solid">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-10">
                            <h3 class="box-title">
                                <i class="fa fa-{{$affiliate->gender=='M'?'female':'male'  }}"></i> Información de Conyuge</h3>
                        </div>
                        @if($info_spouse)
                            <div class="col-md-2 text-right">
                                <div data-toggle="tooltip" data-placement="left" data-original-title="Editar">
                                    <a href="" class="btn btn-sm bg-olive" data-toggle="modal" data-target="#myModal-spouse">
                                        <span class="fa fa-lg fa-pencil" aria-hidden="true"></span>
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">

                        @if($info_spouse)

                            <div class="col-md-6">

                                <table class="table" style="width:100%;">
                                    <tr>
                                        <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>Primer Nombre:</strong>
                                                </div>
                                                <div class="col-md-6">
                                                    {!! $spouse->first_name !!}
                                                </div>
                                            </div>
                                        </td>
                                    <tr>
                                    </tr>
                                        <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>Segundo Nombre:</strong>
                                                </div>
                                                <div class="col-md-6">
                                                    {!! $spouse->second_name !!}
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
                                                     {!! $spouse->last_name !!}
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
                                                     {!! $spouse->mothers_last_name !!}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>Apellido de Esposo:</strong>
                                                </div>
                                                <div class="col-md-6">
                                                     {!! $spouse->surname_husband !!}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    {{-- <tr>
                                        <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>Núm. de Matrícula</strong>
                                                </div>
                                                <div class="col-md-6">
                                                     {!! $spouse->registration !!}
                                                </div>
                                            </div>
                                        </td>
                                    </tr> --}}
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table" style="width:100%;">
                                    <tr>
                                        <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>Carnet Identidad:</strong>
                                                </div>
                                                <div class="col-md-6">
                                                     {!! $spouse->identity_card !!} {!! $spouse->city_identity_card !!}
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
                                                     {!! $spouse->getShortBirthDate() !!}
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
                                                    {!! $spouse->getCivilStatus() !!}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @if($spouse->date_death)
                                        <tr>
                                            <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <strong>Fecha Deceso:</strong>
                                                    </div>
                                                    <div class="col-md-6">
                                                         {!! $spouse->getShortDateDeath() !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <strong>Motivo Deceso:</strong>
                                                    </div>
                                                    <div class="col-md-6">
                                                        {!! $spouse->reason_death !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                </table>

                            </div>

                        @else
                            <div class="row text-center">
                                <div data-toggle="modal" data-target="#myModal-spouse">
                                    <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Adicionar Conyuge">
                                        <img class="circle" src="{!! asset('img/people.png') !!}" width="45px" alt="icon">
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- observations -->
            @if($canObservate)
            <div class="box box-success box-solid">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-10">
                            <h3 class="box-title"><span class="glyphicon glyphicon-eye-open"></span> Observaciones</h3>
                        </div>
                        @if(true)
                            <div class="col-md-2 text-right">
                                <div data-toggle="tooltip" data-placement="left" data-original-title="Añadir">
                                    <a href="" class="btn btn-sm bg-olive" data-toggle="modal" data-target="#observationModal">
                                        <span class="fa fa-lg fa-plus" aria-hidden="true"></span>
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        @if(sizeof($observations))
                            <div class="col-md-12">
                                <table class="table table-bordered table-hover table-striped" id="observations-table">
                                    <thead>
                                        <tr class="success">
                                            <th>Fecha</th>
                                            <th>Titulo</th>
                                            <th>Mensaje</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        @else
                            <div class="row text-center">
                                <div data-toggle="modal" data-target="#observationModal">
                                    <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Adicionar Observacion">
                                    <span class="fa fa-eye fa-5x" style="opacity: .4"></span>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
            <!-- /observations -->

        </div>

        <div class="col-md-6">
            <div class="box box-success box-solid">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="box-title"><span class="glyphicon glyphicon-briefcase"></span> Información Policial Actual</h3>
                        </div>
                        <div class="col-md-4 text-right">
                            <span data-toggle="modal" data-target="#policeModal">
                                <a href="#" class="btn btn-sm bg-olive"  data-toggle="tooltip"  data-placement="top" data-original-title="Editar"><i class="fa fa-lg fa-pencil"></i></a>
                            </span>
                            <span data-toggle="modal" data-target="#myModal-record">
                                <a href="#" class="btn btn-sm bg-olive"  data-toggle="tooltip"  data-placement="top" data-original-title="Ver Historial"><i aria-hidden="true" class="fa fa-lg fa-clock-o"></i></a>
                            </span>
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
                                                <strong>Estado:</strong>
                                            </div>
                                            <div class="col-md-6" data-toggle="tooltip" data-placement="bottom" data-original-title="{!! $affiliate->affiliate_state->affiliate_state_type->name !!}">
                                                {!! $affiliate->affiliate_state->name !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Tipo:</strong>
                                            </div>
                                            <div class="col-md-6">{!! $affiliate->type !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Fecha de Ingreso:</strong>
                                            </div>
                                            <div class="col-md-6">
                                                {!! $affiliate->getShortDateEntry() !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Núm. de Ítem:</strong>
                                            </div>
                                            <div class="col-md-6">
                                                {!! $affiliate->item !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                {{--<tr>
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Unidad:</strong>
                                            </div>
                                            <div class="col-md-6" data-toggle="tooltip" data-placement="bottom" data-original-title="{!! $affiliate->unit->code . " " . $affiliate->unit->name !!}">
                                                {!! $affiliate->unit->shortened !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr> --}}



                                @if($affiliate->date_decommissioned)
                                    <tr>
                                        <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>Fecha de Baja:</strong>
                                                </div>
                                                <div class="col-md-6">
                                                    {!! $affiliate->getFullDateDecommissioned() !!}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </table>

                        </div>
                        <div class="col-md-6">

                            <table class="table" style="width:100%;">

                                {{-- <tr>
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Núm. de Matrícula:</strong>
                                            </div>
                                            <div class="col-md-6">
                                                {!! $affiliate->registration !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr> --}}
                                <tr>
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Categoria:</strong>
                                            </div>
                                            <div class="col-md-6">{!! $affiliate->category->name !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Grado:</strong>
                                            </div>
                                            <div class="col-md-6" data-toggle="tooltip" data-placement="bottom" data-original-title="{!! $affiliate->degree->getCodHierarchyName() !!}">
                                                {!! $affiliate->degree->shortened !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @if($affiliate->pension_entity)
                                <tr>
                                   <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Ente Gestor:</strong>
                                            </div>
                                            <div class="col-md-6" data-toggle="tooltip" data-placement="bottom" data-original-title="{!! $affiliate->pension_entity->type!!}">
                                                {!! $affiliate->pension_entity->name !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                @if($affiliate->reason_decommissioned)
                                    <tr>
                                        <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>Motivo Baja:</strong>
                                                </div>
                                                <div class="col-md-6">
                                                    {!! $affiliate->reason_decommissioned !!}
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
            <style>
            .nav-tabs {
                background: #1AB394;
            }
            .nav-tabs-custom > .nav-tabs > li.active {
                /*background: #026b61; */
                background: #008F71;
                border:none;
            }
            </style>
            <div class="box box-success box-solid">

            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li><a href="#tab_1" data-toggle="tab" title="Aportes">&nbsp;<i class='fa fa-fw fa-arrow-circle-down fa-lg' aria-hidden="true"></i>&nbsp;</a></li>
                    <li><a href="#tab_2" data-toggle="tab" title="Prestamos">&nbsp;<i class="fa fa-fw fa-money fa-lg" aria-hidden="true"></i>&nbsp;</a></li>
                    <li><a href="#tab_3" data-toggle="tab" title="Fondo de Retiro">&nbsp;<i class="glyphicon glyphicon-piggy-bank" aria-hidden="true"></i>&nbsp;</a></li>
                    <li  class="active"><a href="#tab_4" data-toggle="tab" title="Complemento Económico">&nbsp;<i class="fa fa-fw fa-puzzle-piece fa-lg" aria-hidden="true"></i>&nbsp;</a></li>
                    <li><a href="#tab_5" data-toggle="tab" title="Cuota o Auxilio Mortuorio">&nbsp;<i class="fa fa-fw fa-heartbeat fa-lg" aria-hidden="true"></i>&nbsp;</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        {{-- <h4 class="box-title">Aportes</h4> --}}

                       {{--  <table class="table table-bordered table-hover table-striped" style="width:100%;font-size: 14px">
                            <thead>
                            <tr>
                                <th>Concepto</th>
                                <th style="text-align: right;">Totales</th>
                            </tr>
                            </thead>
                            <tr>
                                <td style="width: 70%">Ganado</td>
                                <td style="text-align: right">{{ $total_gain }}</td>
                            </tr>
                            <tr>
                                <td style="width: 70%">Bono de Seguridad Ciudadana</td>
                                <td style="text-align: right">{{ $total_public_security_bonus }}</td>
                            </tr>
                            <tr>
                                <td style="width: 70%">Cotizable</td>
                                <td style="text-align: right">{{ $total_quotable }}</td>
                            </tr>
                            <tr>
                                <td style="width: 70%">Aporte Fondo de Retiro</td>
                                <td style="text-align: right">{{ $total_retirement_fund }}</td>
                            </tr>
                            <tr>
                                <td style="width: 70%">Aporte Cuota o Auxilio Mortuorio</td>
                                <td style="text-align: right">{{ $total_mortuary_quota }}</td>
                            </tr>
                            <tr class="active">
                                <td style="width: 70%">Aporte Muserpol</td>
                                <td style="text-align: right">{{ $total }}</td>
                            </tr>
                        </table> --}}
                    </div>
                    <div class="tab-pane" id="tab_2">

                        {{-- @if(!)
                            registros
                        @else --}}
                            <div class="row text-center">
                                <i class="fa  fa-list-alt fa-3x  fa-border" aria-hidden="true"></i>
                                <h4 class="box-title">No hay registros de Préstamos</h4>
                            </div>
                        {{-- @endif --}}

                    </div>
                    <div class="tab-pane" id="tab_3">

                        {{-- @if(!)
                            registros
                        @else --}}
                            <div class="row text-center">
                                <i class="fa  fa-list-alt fa-3x  fa-border" aria-hidden="true"></i>
                                <h4 class="box-title">No hay registros de Fondo de Retiro</h4>
                            </div>
                        {{-- @endif --}}

                    </div>
                    <div class="tab-pane active" id="tab_4">
                          <h4 class="box-title">Complemento Económico</h4>
                          <div class="row">
                              <div class="col-md-12">
                                  <table class="table table-bordered table-hover" id="economic_complements-table">
                                      <thead>
                                          <tr class="success">
                                              <th class="text-center"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Número de Trámite">Número</div></th>
                                              <th class="text-center"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Fecha de Emisión">Fecha Emisión</div></th>
                                              <th class="text-center"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Estado">Estado</div></th>
                                              <th class="text-center"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Modalidad">Modalidad</div></th>
                                              {{-- <th class="text-center"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Opciones">Opciones</div></th> --}}
                                          </tr>
                                      </thead>
                                  </table>
                              </div>
                          </div>
                    </div>
                    <div class="tab-pane" id="tab_5">

                        {{-- @if(!$info_spouse)
                            registros
                        @else --}}
                            <div class="row text-center">
                                <i class="fa  fa-list-alt fa-3x  fa-border" aria-hidden="true"></i>
                                <h4 class="box-title">No hay registros de Cuota, Auxilio Mortuorio</h4>
                            </div>
                        {{-- @endif --}}

                    </div>
                </div>
            </div>
            </div>
        </div>
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
                                        {!! Form::label('nua', 'CUA/NUA', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-6">
                                        {!! Form::number('nua', $affiliate->nua, ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                                        <span class="help-block">Escriba el CUA/NUA</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                            {!! Form::label('gender', 'Sexo', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::select('gender', ['M'=>'Masculino','F'=>'Femenino'] ,$affiliate->gender, ['class' => 'combobox form-control','required']) !!}
                                        <span class="help-block">Seleccione Sexo</span>
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
                                            {!! Form::label('civil_status', 'Estado Civil', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::select('civil_status', $gender_list, $affiliate->civil_status, ['class' => 'combobox form-control', 'required']) !!}
                                        <span class="help-block">Seleccione el Estado Civil</span>
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
                                <div class="">
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
                                                <input type="checkbox" data-bind="checked: DateDeathAffiliateValue" name="DateDeathAffiliateCheck"> Fallecido
                                              </label>
                                          </div>
                                        </div>
                                    </div>
                                </div>

                                <div data-bind='fadeVisible: DateDeathAffiliateValue, valueUpdate: "afterkeydown"'>

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
                                </div>
                            </div>
                        </div>

                        <div class="row text-center">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <a href="{!! url('affiliate/' . $affiliate->id) !!}" class="btn btn-raised btn-warning" data-toggle="tooltip" data-placement="bottom" data-original-title="Cancelar">&nbsp;<i class="glyphicon glyphicon-remove"></i>&nbsp;</a>
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
    <div id="myModal-address" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="box-header with-border">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Editar Información Domicilio</h4>
                </div>
                <div class="modal-body">
                    {!! Form::model($AffiliateAddress, ['method' => 'PATCH', 'route' => ['affiliate_address.update', $affiliate], 'class' => 'form-horizontal']) !!}
                        <input type="hidden" name="type" value="address"/>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                            {!! Form::label('city_address_id', 'Departamento', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::select('city_address_id', $cities_list, $AffiliateAddress->city_address_id, ['class' => 'combobox form-control', 'required' => 'required']) !!}
                                        <span class="help-block">Seleccione Departamento</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                        {!! Form::label('zone', 'Zona', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::text('zone', $AffiliateAddress->zone, ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                                        <span class="help-block">Escriba la Zona</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                        {!! Form::label('number_address', 'Número de Domicilio', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::text('number_address', $AffiliateAddress->number_address, ['class'=> 'form-control']) !!}
                                        <span class="help-block">Escriba el Número de Domicilio</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                        {!! Form::label('street', 'Calle, Avenida', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::text('street', $AffiliateAddress->street, ['class'=> 'form-control', 'required' => 'required','onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                                        <span class="help-block">Escriba la Calle y/o Avenida</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row text-center">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <a href="{!! url('affiliate/' . $affiliate->id) !!}" class="btn btn-raised btn-warning" data-toggle="tooltip" data-placement="bottom" data-original-title="Cancelar">&nbsp;<i class="glyphicon glyphicon-remove"></i>&nbsp;</a>
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
    <div id="myModal-spouse" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="box-header with-border">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Editar Información de Conyuge</h4>
                </div>
                <div class="modal-body">

                    {!! Form::model($spouse, ['method' => 'PATCH', 'route' => ['spouse.update', $affiliate], 'class' => 'form-horizontal']) !!}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                        {!! Form::label('first_name', 'Primer Nombre', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::text('first_name', $spouse->first_name, ['class'=> 'form-control', 'required','onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                                        <span class="help-block">Escriba el Primer Nombre</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                        {!! Form::label('second_name', 'Segundo Nombre', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::text('second_name', $spouse->second_name, ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                                        <span class="help-block">Escriba el Segundo Nombre</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                        {!! Form::label('last_name', 'Apellido Paterno', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::text('last_name', $spouse->last_name, ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                                        <span class="help-block">Escriba el Apellido Paterno</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                        {!! Form::label('mothers_last_name', 'Apellido Materno', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::text('mothers_last_name', $spouse->mothers_last_name, ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                                        <span class="help-block">Escriba el  Apellido Materno</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                        {!! Form::label('surname_husband', 'Apellido de Esposo', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::text('surname_husband', $spouse->surname_husband, ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                                        <span class="help-block">Escriba el Apellido de Esposo (Opcional)</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                        {!! Form::label('identity_card', ' Carnet de Identidad', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-5">
                                        {!! Form::text('identity_card', $spouse->identity_card, ['class'=> 'form-control', 'required']) !!}
                                        <span class="help-block">Escriba el Carnet de Identidad</span>
                                    </div>
                                    {!! Form::select('city_identity_card_id', $cities_list_short, $spouse->city_identity_card_id, ['class' => 'col-md-2 combobox form-control','required' => 'required']) !!}
                                </div>
                                <div class="form-group">
                                        {!! Form::label('birth_date', 'Fecha Nacimiento', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        <div class="input-group">
                                            <input type="text" id="birth_date_spouse_mask" required class="form-control" name="birth_date" value="{!! $spouse->getEditBirthDate() !!}" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                            {!! Form::label('civil_status', 'Estado Civil', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::select('civil_status', $gender_list_s, $spouse->civil_status, ['class' => 'combobox form-control', 'required']) !!}
                                        <span class="help-block">Seleccione el Estado Civil</span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-offset-5 col-md-4">
                                        <div class="form-group">
                                            <div class="togglebutton">
                                              <label>
                                                <input type="checkbox" data-bind="checked: DateDeathSpouseValue" name="DateDeathSpouseCheck"> Fallecido
                                              </label>
                                          </div>
                                        </div>
                                    </div>
                                </div>

                                <div data-bind='fadeVisible: DateDeathSpouseValue, valueUpdate: "afterkeydown"'>

                                    <div class="form-group">
                                            {!! Form::label('date_death', 'Fecha Deceso', ['class' => 'col-md-5 control-label']) !!}
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" id="date_death_spouse_mask" class="form-control" name="date_death" value="{!! $spouse->getEditDateDeath() !!}" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
                                                <div class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                            {!! Form::label('reason_death', 'Causa Deceso', ['class' => 'col-md-5 control-label']) !!}
                                        <div class="col-md-6">
                                            {!! Form::textarea('reason_death', $spouse->reason_death, ['class'=> 'form-control', 'rows' => '2']) !!}
                                            <span class="help-block">Escriba el Motivo de fallecimiento</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="row text-center">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <a href="{!! url('affiliate/' . $affiliate->id) !!}" data-target="#" class="btn btn-raised btn-warning">&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;&nbsp;</a>
                                    &nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-raised btn-success">&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;</button>
                                </div>
                            </div>
                        </div>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>


    <div id="myModal-record" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="box-header with-border">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Historial</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-hover" id="record-table" width="100%">
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
    <!-- Edition of a police officer-->
    <div id="policeModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="box-header with-border">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Editar Información de Policía</h4>
                        </div>
                        <div class="modal-body">
                            {!! Form::model($affiliate, ['method' => 'PATCH', 'route' => ['affiliate.update', $affiliate], 'class' => 'form-horizontal']) !!}
                            <input type="hidden" name="type" value="institutional"/>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                                {!! Form::label('state', 'Estado', ['class' => 'col-md-5 control-label']) !!}
                                            <div class="col-md-7">
                                                {!! Form::select('state',$affiliate_state, $affiliate->affiliate_state->id , ['class'=> 'combobox form-control', 'required']) !!}
                                                <span class="help-block">Seleccione un estado del policía</span>
                                            </div>
                                        </div>
                                        {{-- <div class="form-group">
                                                {!! Form::label('affiliate_type', 'Tipo', ['class' => 'col-md-5 control-label']) !!}
                                            <div class="col-md-7">
                                                {!! Form::select('affiliate_type',$affiliate_types, $affiliate->affiliate_type->id , ['class'=> 'combobox form-control', 'required']) !!}
                                                <span class="help-block">Seleccione un tipo del policía</span>
                                            </div>
                                        </div> --}}
                                        <div class="form-group">
                                                {!! Form::label('date_entry', 'Fecha de Ingreso', ['class' => 'col-md-5 control-label']) !!}
                                            <div class="col-md-7">
                                                <div class="input-group">
                                                    <input type="text" id="date_entry" class="form-control" name="date_entry" value="{!! $affiliate->date_entry !!}" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
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
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                                {!! Form::label('category', 'Categoria', ['class' => 'col-md-5 control-label']) !!}
                                            <div class="col-md-7">
                                                {!! Form::select('category',$categories, $affiliate->category_id , ['class'=> 'combobox form-control', 'required']) !!}
                                                <span class="help-block">Seleccione una Categoria para el policía</span>
                                            </div>
                                        </div>
                                         <div class="form-group">
                                                {!! Form::label('degree', 'Grado', ['class' => 'col-md-5 control-label']) !!}
                                            <div class="col-md-7">
                                                {!! Form::select('degree',$degrees, $affiliate->degree->id , ['class'=> 'combobox form-control', 'required']) !!}
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
                                                {!! Form::label('affiliate_entity_pension', 'Ente Gestor', ['class' => 'col-md-5 control-label']) !!}
                                            <div class="col-md-7">
                                                {!! Form::select('affiliate_entity_pension',$entity_pensions, $affiliate->pension_entity->id ?? null , ['class'=> 'combobox form-control', 'required']) !!}
                                                <span class="help-block">Seleccione un ente gestor</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row text-center">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <a href="{!! url('affiliate/' . $affiliate->id) !!}" data-target="#" class="btn btn-raised btn-warning">&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;&nbsp;</a>
                                            &nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-raised btn-success">&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;</button>
                                        </div>
                                    </div>
                                </div>

                            {!! Form::close() !!}

                        </div>
                    </div>
                </div>
    </div>
    <!-- /Edition of a police officer-->

    <div class="modal fade" tabindex="-1" >
        <iframe src="{!! url('print_affiliate/' . $affiliate->id) !!}" id="iFramePdf"></iframe>
    </div>

@endsection

@push('scripts')

    <script type="text/javascript">

        function printTrigger(elementId) {
            var getMyFrame = document.getElementById(elementId);
            getMyFrame.focus();
            getMyFrame.contentWindow.print();
        }

        $(document).ready(function(){
            $("#birth_date_mask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/aaaa"});
            $("#birth_date_spouse_mask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/aaaa"});
            $("#date_death_mask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/aaaa"});
            $("#date_entry").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/aaaa"});
            $("#date_death_spouse_mask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/aaaa"});
            $("input[name='phone_number[]']").inputmask();
            $("input[name='cell_phone_number[]']").inputmask();
        });

        $(document).ready(function(){
            $('.combobox').combobox();
            $('[data-toggle="tooltip"]').tooltip();
        });

        $('.datepicker').datepicker({
            format: "dd/mm/yyyy",
            language: "es",
            orientation: "bottom right",
            daysOfWeekDisabled: "0,6",
            autoclose: true
        });

        var affiliate = {!! $affiliate !!};
        var spouse = {!! $spouse !!};

        var Model = function() {
            this.DateDeathAffiliateValue = ko.observable(affiliate.date_death ? true : false);
            this.DateDeathSpouseValue = ko.observable(spouse.date_death ? true : false);
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

        ko.applyBindings(new Model());

        $(function() {
            $('#record-table').DataTable({
                "dom": '<"top">t<"bottom"p>',
                "order": [[ 0, "desc" ]],
                processing: true,
                serverSide: true,
                pageLength: 12,
                bFilter: false,
                ajax: {
                    url: '{!! route('get_record') !!}',
                    data: function (d) {
                        d.id = {{ $affiliate->id }};
                    }
                },
                columns: [
                    { data: 'date' },
                    { data: 'message', bSortable: false }
                ]
            });
        });

        //for economic_complement by affiliate

        var eco_comTable = $('#economic_complements-table').DataTable({
            "dom": '<"top">t<"bottom"p>',
            processing: true,
            serverSide: true,
            pageLength: 8,
            autoWidth: false,
            order: [0, "desc"],
            ajax: {
                url: '{!! route('get_economic_complement_by_affiliate') !!}',
                data: function (d) {
                    d.id = {{ $affiliate->id }};
                }
            },
            columns: [
                { data: 'code', sClass: "text-center" },
                { data: 'created_at', bSortable: false },
                // { data: 'eco_com_state', bSortable: false },
                { data: 'eco_com_modality', bSortable: false },
                { data: 'action',name: 'action', orderable: false, searchable: false, bSortable: false, sClass: 'text-center'},
            ]
        });

        //for observations

        var observationsTable = $('#observations-table').DataTable({
            "dom": '<"top">t<"bottom"p>',
            processing: true,
            serverSide: true,
            pageLength: 8,
            autoWidth: false,
            ajax: {
                url: '{!! route('get_observations') !!}',
                data: function (d) {
                    d.id={{$affiliate->id}}
                }
            },
            columns: [

                { data: 'date', bSortable: false },
                { data: 'title', bSortable: false },
                { data: 'message', bSortable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false, bSortable: false, sClass: 'text-center' }
            ]
        });

        //tooltip
        $(document).ready(function() {
            $('[data-toggle="tab"]').tooltip({
                trigger: 'hover',
                placement: 'top',
                animate: true,
                delay: 100
            });
        });

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
