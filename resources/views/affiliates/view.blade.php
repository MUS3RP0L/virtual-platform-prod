@extends('app')

@section('contentheader_title')

    <div class="row">
        <div class="col-md-6">
            {!! Breadcrumbs::render('show_affiliate', $affiliate) !!}
        </div>
        <div class="col-md-4">
            <a href="{!! url('retirement_fund/' . $affiliate->id) !!}" class="btn btn-raised btn-success" data-toggle="tooltip" data-placement="top" data-original-title="Fondo Retiro">
                &nbsp;<span class="glyphicon glyphicon-piggy-bank"></span>&nbsp;
            </a>
            <div class="btn-group" class="btn btn-raised btn-success" data-toggle="tooltip" data-placement="top" data-original-title="Aportes" style="margin:0px;">
                <a href="" class="btn btn-success btn-raised dropdown-toggle" data-toggle="dropdown">
                    &nbsp;<span class="glyphicon glyphicon-th-list"></span>&nbsp;
                </a>
                <ul class="dropdown-menu"  role="menu">
                    <li>
                        <a href="{!! url('show_contributions/' . $affiliate->id) !!}" class="text-center">
                            <span class="glyphicon glyphicon-eye-open"></span>
                        </a>
                    </li>
                    <li role="separator" class="divider"></li>
                    <li>
                        <a href="{!! url('select_contribution/' . $affiliate->id) !!}" class="text-center">
                            <span class="glyphicon glyphicon-plus"></span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="btn-group" data-toggle="tooltip" data-placement="bottom" data-original-title="Imprimir" style="margin:0px;">
                <a href="" class="btn btn-raised btn-success dropdown-toggle enabled" data-toggle="modal" value="Print" onclick="printTrigger('iFramePdf');" >
                    &nbsp;<span class="glyphicon glyphicon-print"></span>&nbsp;
                </a>
            </div>

        </div>
        <div class="col-md-2 text-right">
            <a href="{!! url('affiliate') !!}" class="btn btn-raised btn-warning" data-toggle="tooltip" data-placement="top" data-original-title="Atrás">
                &nbsp;<span class="glyphicon glyphicon-share-alt"></span>&nbsp;
            </a>
        </div>
    </div>

@endsection

@section('main-content')

    <div class="row">
        <div class="col-md-6">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-10">
                            <h3 class="box-title"><span class="glyphicon glyphicon-user"></span> Información Personal</h3>
                        </div>
                        <div class="col-md-2 text-right">
                            <div data-toggle="tooltip" data-placement="left" data-original-title="Editar">
                                <a href="" class="btn btn-raised btn-xs btn-primary" data-toggle="modal" data-target="#myModal-personal">&nbsp;&nbsp;
                                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp;&nbsp;
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
                                                Carnet Identidad
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
                                                Apellido Paterno
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
                                                Apellido Materno
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
                                                Primer Nombre
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
                                                Segundo Nombre
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
                                                Teléfono
                                            </div>
                                            <div class="col-md-6">
                                                {!! $affiliate->phone__number !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @if ($affiliate->surname_husband)
                                <tr>
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                Apellido de Esposo
                                            </div>
                                            <div class="col-md-6">
                                                {!! $affiliate->surname_husband !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                @if($affiliate->date_death)
                                    <tr>
                                        <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    Fecha de Deceso
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
                                                Fecha Nacimiento
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
                                                Edad
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
                                                Sexo
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
                                                Estado Civil
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
                                                Lugar Nacimiento
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
                                                Celular
                                            </div>
                                            <div class="col-md-6">
                                                {!! $affiliate->cell_phone_number !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @if($affiliate->reason_death)
                                    <tr>
                                        <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    Motivo de Deceso
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

            <div class="box box-warning">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-10">
                            <h3 class="box-title"><span class="glyphicon glyphicon-home"></span> Información de Domicilio</h3>
                        </div>
                        @if($info_address)
                            <div class="col-md-2 text-right">
                                <div data-toggle="tooltip" data-placement="left" data-original-title="Editar">
                                    <a href="" class="btn btn-raised btn-xs btn-primary" data-toggle="modal" data-target="#myModal-address">&nbsp;&nbsp;
                                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp;&nbsp;
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
                                                    Departamento
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
                                                    Zona
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
                                                    Calle, Avenida
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
                                                    Núm Domicilio
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

            <div class="box box-warning">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-10">
                            <h3 class="box-title"><span class="glyphicon glyphicon-user"></span> Información de Conyuge</h3>
                        </div>
                        @if($info_spouse)
                            <div class="col-md-2 text-right">
                                <div data-toggle="tooltip" data-placement="left" data-original-title="Editar">
                                    <a href="" class="btn btn-raised btn-xs btn-primary" data-toggle="modal" data-target="#myModal-spouse">&nbsp;&nbsp;
                                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp;&nbsp;
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
                                                    Carnet Identidad
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
                                                    Apellido Paterno
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
                                                    Apellido Materno
                                                </div>
                                                <div class="col-md-6">
                                                     {!! $spouse->mothers_last_name !!}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @if($spouse->date_death)
                                        <tr>
                                            <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        Fecha Deceso
                                                    </div>
                                                    <div class="col-md-6">
                                                         {!! $spouse->getShortDateDeath() !!}
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
                                                    Fecha Nacimiento
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
                                                    Primer Nombre
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
                                                    Segundo Nombre
                                                </div>
                                                <div class="col-md-6">
                                                    {!! $spouse->second_name !!}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @if($spouse->reason_death)
                                        <tr>
                                            <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        Motivo Deceso
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
        </div>

        <div class="col-md-6">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-10">
                            <h3 class="box-title"><span class="glyphicon glyphicon-briefcase"></span> Información Policial Actual</h3>
                        </div>
                        <div class="col-md-2 text-right">
                            <div data-toggle="tooltip" data-placement="left" data-original-title="Ver Historial">
                                <a href="" class="btn btn-raised btn-xs btn-primary" data-toggle="modal" data-target="#myModal-record">&nbsp;&nbsp;
                                    <span class="glyphicon glyphicon-hourglass" aria-hidden="true"></span>&nbsp;&nbsp;
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
                                                Estado
                                            </div>
                                            <div class="col-md-6" data-toggle="tooltip" data-placement="bottom" data-original-title="{!! $affiliate->affiliate_state->state_type->name !!}">
                                                {!! $affiliate->affiliate_state->name !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                Grado
                                            </div>
                                            <div class="col-md-6" data-toggle="tooltip" data-placement="bottom" data-original-title="{!! $affiliate->degree->getCodHierarchyName() !!}">
                                                {!! $affiliate->degree->shortened !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                Tipo
                                            </div>
                                            <div class="col-md-6">{!! $affiliate->affiliate_type->name !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                Unidad
                                            </div>
                                            <div class="col-md-6" data-toggle="tooltip" data-placement="bottom" data-original-title="{!! $affiliate->unit->code . " " . $affiliate->unit->name !!}">
                                                {!! $affiliate->unit->shortened !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @if($affiliate->date_decommissioned)
                                    <tr>
                                        <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    Fecha de Baja
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
                                <tr>
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                Fecha de Ingreso
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
                                                Núm. de Matrícula
                                            </div>
                                            <div class="col-md-6">
                                                {!! $affiliate->registration !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                Núm. de Ítem
                                            </div>
                                            <div class="col-md-6">
                                                {!! $affiliate->item !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @if($affiliate->reason_decommissioned)
                                    <tr>
                                        <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    Motivo Baja
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

            <div class="box box-warning">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="box-title"><span class="glyphicon glyphicon-usd"></span> Aportes</h3>
                        </div>
                        <div class="col-md-6">
                            <h3 class="panel-title" style="text-align: right">Bolivianos</h3>
                        </div>
                    </div>
                </div>
                <div class="box-body">

                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered table-hover" style="width:100%;font-size: 14px">
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
                            </table>
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
                                        {!! Form::text('identity_card', $affiliate->identity_card, ['class'=> 'form-control', 'required', 'required' => 'required']) !!}
                                        <span class="help-block">Número de CI</span>
                                    </div>
                                        {!! Form::select('city_identity_card_id', $cities_list_short, $affiliate->city_identity_card_id, ['class' => 'col-md-2 combobox form-control','required' => 'required']) !!}
                                </div>
                                <div class="form-group">
                                        {!! Form::label('last_name', 'Apellido Paterno', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::text('last_name', $affiliate->last_name, ['class'=> 'form-control', 'required', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
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
                                        {!! Form::text('first_name', $affiliate->first_name, ['class'=> 'form-control','required', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
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
                                @if ($affiliate->gender == 'F')
                                    <div class="form-group">
                                            {!! Form::label('surname_husband', 'Apellido de Esposo', ['class' => 'col-md-5 control-label']) !!}
                                        <div class="col-md-7">
                                            {!! Form::text('surname_husband', $affiliate->surname_husband, ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                                            <span class="help-block">Escriba el Apellido de Esposo (Opcional)</span>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                        {!! Form::label('birth_date', 'Fecha de Nacimiento', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                            			<div class="input-group">
                                            <input type="text" id="birth_date_mask" class="form-control" name="birth_date" value="{!! $affiliate->getEditBirthDate() !!}" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
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
                                <div class="form-group">
                                        {!! Form::label('phone_number', 'Teléfono fijo', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        <input type="text" id="phone_number" class="form-control" name="phone_number" value="{!! $affiliate->phone_number !!}" data-inputmask="'mask': '(9) 999-999'" data-mask>
                                        <span class="help-block">Escriba el Teléfono fijo</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                        {!! Form::label('cell_phone_number', 'Teléfono Celular', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        <input type="text" id="cell_phone_number" class="form-control" name="cell_phone_number" value="{!! $affiliate->cell_phone_number !!}" data-inputmask="'mask': '(999)-99999'" data-mask>
                                        <span class="help-block">Escriba el Teléfono Celular</span>
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
                                        {!! Form::label('identity_card', ' Carnet de Identidad', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-5">
                                        {!! Form::text('identity_card', $spouse->identity_card, ['class'=> 'form-control', 'required']) !!}
                                        <span class="help-block">Escriba el Carnet de Identidad</span>
                                    </div>
                                    {!! Form::select('city_identity_card_id', $cities_list_short, $spouse->city_identity_card_id, ['class' => 'col-md-2 combobox form-control','required' => 'required']) !!}
                                </div>
                                <div class="form-group">
                                        {!! Form::label('last_name', 'Apellido Paterno', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::text('last_name', $spouse->last_name, ['class'=> 'form-control','required', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
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
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                        {!! Form::label('birth_date', 'Fecha Nacimiento', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        <div class="input-group">
                                            <input type="text" id="birth_date_spouse_mask" class="form-control" name="birth_date" value="{!! $spouse->getEditBirthDate() !!}" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </div>
                                        </div>
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
            $("#date_death_spouse_mask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/aaaa"});
            $("#phone__number").inputmask();
            $("#cell_phone_number").inputmask();
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

    </script>

@endpush
