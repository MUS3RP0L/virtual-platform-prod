@extends('app')

@section('contentheader_title')
<style>
    .nav-tabs-custom > .nav-tabs > li.active > a, .nav-tabs-custom > .nav-tabs > li.active:hover > a{
        background: #008F71;
    }
    .nav-tabs {
        background: #1AB394;
    }
    .nav-tabs-custom > .nav-tabs > li.active {
        border:none;
    }
    .my-alert {
      padding: 8px;
      border: 1px solid transparent;
      border-radius: 4px;
      font-size: 14px;
    }
    .my-alert-info {
      background-color: #d9edf7;
      border-color: #bce8f1;
      color: #31708f;
    }
</style>
    <div class="row">
        <div class="col-md-6">
            {!! Breadcrumbs::render('show_affiliate', $affiliate) !!}
        </div>
        <div class="col-md-6">
        {{ Auth::user()->get}}
        @can('retirement_fund')
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
        {{-- @can('retirement_fund')
            @foreach($paid_states as $paid_state)
                <span class="my-alert my-alert-info">
                    El afiliado ya fue pagado por <strong> 
                        @if($paid_state->type == 'F')
                            Fondo de Retiro
                        @elseif($paid_state->type == 'C')
                            Cuota Mortuoria
                        @else
                            Auxilio Mortuorio
                        @endif
                    </strong>
                </span>&nbsp;
            @endforeach
        @endcan --}}
        @can('eco_com_reception')
            @if ($available_create_eco_com)
            <div class="btn-group" data-toggle="tooltip" data-placement="top"  data-original-title="Complemento Económico"  style="margin: 0;" >
                <a href="" class="btn btn-success btn-raised bg-orange"  data-toggle="dropdown" ><i class="fa fa-puzzle-piece fa-lg"></i></a>
                <ul class="dropdown-menu">
                    @if($has_first_eco_com == 'edit')
                    <li  data-toggle="tooltip" data-placement="left" title="1er Semestre"><a href="{!! url('economic_complement/'.$first_economic_complement->id) !!}" class="text-center">&nbsp;&nbsp;<i class="fa fa-eye"></i>Ver 1er Semestre&nbsp;&nbsp;</a></li>
                    @else
                    <li><a href="{!! url('economic_complement_reception_first_step/' . $affiliate->id) !!}"  class="text-center">&nbsp;&nbsp;<i class="glyphicon glyphicon-plus"></i>Crear 1er Semestre&nbsp;&nbsp;</a></li>
                    @endif
                    <li role="separator" class="divider"></li>
                    @if($has_second_eco_com == 'edit')
                    <li  data-toggle="tooltip" data-placement="left" title="2do Semestre"><a href="{!! url('economic_complement/'.$second_economic_complement->id) !!}" class="text-center">&nbsp;&nbsp;<i class="fa fa-eye"></i>Ver 2er Semestre&nbsp;&nbsp;</a></li>
                    @else
                        <li><a href="{!! url('economic_complement_reception_first_step/' . $affiliate->id.'/second') !!}"  class="text-center">&nbsp;&nbsp;<i class="glyphicon glyphicon-plus"></i>Crear 2do Semestre&nbsp;&nbsp;</a></li>
                    @endif
                </ul>
            </div>
            @endif
            {{-- @if($has_first_eco_com=="edit")
                <div class="btn-group" data-toggle="tooltip" data-placement="top" data-original-title="Complemento  Económico" style="margin: 0;">
                    <a href="" class="btn btn-success btn-raised bg-orange" data-toggle="dropdown"><i class="fa fa-puzzle-piece fa-lg"></i></a>
                    <ul class="dropdown-menu">
                        <li  data-toggle="tooltip" data-placement="left" title="1er Semestre"><a href="{!! url('economic_complement/'.$eco_com_current_procedure_first->id) !!}" class="text-center"><i class="fa fa-eye"></i>Ver 1er Semestre</a></li>
                    </ul>
                </div>
            @endif
            @if($has_second_eco_com=="create")
                <div class="btn-group" data-toggle="tooltip" data-placement="top" data-original-title="Complemento  Económico" style="margin: 0;">
                    <a href="" class="btn btn-success btn-raised bg-orange" data-toggle="dropdown"><i class="fa fa-puzzle-piece fa-lg"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="{!! url('economic_complement_reception_first_step/' . $affiliate->id) !!}"  class="text-center"><i class="glyphicon glyphicon-plus"></i>Crear</a></li>
                    </ul>
                </div>
            @endif --}}
        @endcan
        {{-- @can('manage')
            <div class="btn-group" data-toggle="tooltip" data-placement="top" data-original-title="Cuota Auxilio" style="margin: 0;">
                <a href="" class="btn btn-success btn-raised bg-orange" data-toggle="dropdown"><i class="fa fa-heartbeat fa-lg"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="#"  class="text-center"><i class="glyphicon glyphicon-plus"></i>Crear</a></li>
                </ul>
            </div>
        @endcan --}}
            <!-- button of Observations -->
            @can('eco_com_review_and_reception')
                @if($devolution)
                    @if($devolution->total > 0 )
                        {{-- <div class="btn-group" data-toggle="tooltip" data-placement="top" data-original-title="Devoluciones" style="margin: 0;">
                            <a href="" class="btn btn-info btn-raised" data-toggle="modal" data-target="#devolutionModal"><i class="fa fa-circle-o-notch" aria-hidden="true"></i></a>
                        </div> --}}
                        <button class="btn btn-info btn-raised" data-toggle="tooltip" data-placement="top" data-original-title="imprimir compromiso de devolucion" style="margin: 0;" onclick="printJS({printable:'{!! url('temp_devolution_print/' . $devolution->id) !!}', type:'pdf', showModal:true})" >
                            <i class="fa fa-print"></i>
                        </button>
                    @endif
                @endif
            @endcan
        </div>
    </div>

@endsection
@section('main-content')


    <div class="row">
        <div class="col-md-6">
            <div class="box box-success box-solid">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-10">
                            <h3 class="box-title"><i class="fa fa-{{$affiliate->gender=='M'?'male':'female'  }}"></i> Información Personal</h3>
                        </div>
                        <div class="col-md-2 text-right">
                            @if(! $affiliate->economic_complements->count())
                                <div data-toggle="tooltip" data-placement="left" data-original-title="Editar">
                                    <a href="" class="btn btn-sm bg-olive" data-toggle="modal" data-target="#myModal-personal">
                                        <span class="fa fa-lg fa-pencil" aria-hidden="true"></span>
                                    </a>
                                </div>
                            @endif
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
                                                <strong>Cédula de Identidad:</strong>
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
                                                <strong>Fecha de Vencimiento CI:</strong>
                                            </div>
                                            <div class="col-md-6">
                                                @if($affiliate->is_duedate_undefined)
                                                    INDEFINIDO
                                                @else
                                                    {!! $affiliate->getShortDueDate() !!}
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
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
                                                {!! $affiliate->getAge() !!} AÑOS
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
                                                    {!! $affiliate_address->city_address !!}
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
                                                    {!! $affiliate_address->zone !!}
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
                                                    {!! $affiliate_address->street !!}
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
                                                    {!! $affiliate_address->number_address !!}
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
                            @can("eco_com_review_and_reception")
                            <div class="col-md-2 text-right">
                                @if(! $affiliate->economic_complements->count())
                                <div data-toggle="tooltip" data-placement="left" data-original-title="Editar">
                                    <a href="" class="btn btn-sm bg-olive" data-toggle="modal" data-target="#myModal-spouse">
                                        <span class="fa fa-lg fa-pencil" aria-hidden="true"></span>
                                    </a>
                                </div>
                                @endif
                            </div>
                            @endcan
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
                                                    <strong>Cédula de Identidad:</strong>
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
                                    @if($spouse->official)
                                    <tr>
                                        <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>Libro:</strong>
                                                </div>
                                                <div class="col-md-6">                                            
                                                     {!! $spouse->book !!}                                                  
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                     <tr>
                                        <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>Fecha de Matrimonio:</strong>
                                                </div>
                                                <div class="col-md-6">                                            
                                                     {!! $spouse->marriage_date !!}                                                  
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
                                                    <strong>Fecha de Vencimiento CI:</strong>
                                                </div>
                                                <div class="col-md-6">
                                                @if($spouse->is_duedate_undefined)
                                                    INDEFINIDO
                                                @else
                                                    {!! $spouse->getShortDueDate() !!}
                                                @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>Género:</strong>
                                                </div>
                                                <div class="col-md-6">
                                                    {!! $spouse->affiliate->getSpouseGender() !!}
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
                                                    <strong>Lugar Nacimiento:</strong>
                                                </div>
                                                <div class="col-md-6">
                                                  @if($spouse->city_birth)
                                                     {!! $spouse->city_birth->name !!}
                                                  @endif
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
                                    
                                    @if($spouse->official)
                                     <tr>
                                        <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>Oficialia:</strong>
                                                </div>
                                                <div class="col-md-6">                                            
                                                     {!! $spouse->official !!}                                                  
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                     <tr>
                                        <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>Partida:</strong>
                                                </div>
                                                <div class="col-md-6">                                            
                                                     {!! $spouse->departure !!}                                                  
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
        
            @include('observations.show_affiliate')
           

        </div>

        <div class="col-md-6">
            <div class="box box-success box-solid">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="box-title"><span class="glyphicon glyphicon-briefcase"></span> Información Policial Actual</h3>
                        </div>
                        <div class="col-md-4 text-right">
                            @if(! $affiliate->economic_complements->count())
                            <span data-toggle="modal" data-target="#policeModal">
                                <a href="#" class="btn btn-sm bg-olive"  data-toggle="tooltip"  data-placement="top" data-original-title="Editar"><i class="fa fa-lg fa-pencil"></i></a>
                            </span>
                            @endif
                            
                            <a href="#" class="btn btn-sm bg-olive"  data-toggle="tooltip"  data-placement="top" data-original-title="Imprimir Historial" onclick="printJS({printable:'{!! url("history_print/" . $affiliate->id ) !!}', type:'pdf', showModal:true})"><i aria-hidden="true" class="fa fa-lg fa-print"></i></a>
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
                                                <strong>Fecha de Ingreso a la Institución Policial:</strong>
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
                                <tr class="success">
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Código de Afiliado:</strong>
                                            </div>
                                            <div class="col-md-6" data-toggle="tooltip" data-placement="bottom" data-original-title="{!! $affiliate->id !!}">
                                                {!! $affiliate->id !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @if($affiliate->affiliate_registration_number)
                                <tr class="success">
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Matricula del Afiliado:</strong>
                                            </div>
                                            <div class="col-md-6" data-toggle="tooltip" data-placement="bottom" data-original-title="{!! $affiliate->affiliate_registration_number !!}">
                                                {!! $affiliate->affiliate_registration_number !!}
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
                                                  <th class="text-center"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Número de Trámite">Número de Trámite</div></th>
                                                  <th class="text-center"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Gesion ">Gestión</div></th>
                                                  <th class="text-center"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Fecha de Emisión">Fecha de Ingreso del Trámite</div></th>
                                                  <th class="text-center"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Ubicación">Ubicación</div></th>
                                                  <th class="text-center"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Estado">Estado</div></th>
                                                  <th class="text-center"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Total">Total</div></th>
                                                  <th class="text-center"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Opciones">Opciones</div></th>
                                           
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

            {{-- <div class="box box-danger box-solid">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-10">
                            <h3 class="box-title"><span class="glyphicon glyphicon-inbox"></span> Documentos Presentados</h3>
                        </div>
                        <div class="col-md-2 text-right">
                            <div data-toggle="tooltip" data-placement="left" data-original-title="Editar">
                                <a href="" class="btn btn-sm bg-red-active" data-toggle="modal" data-target="#myModal-requirements">&nbsp;&nbsp;
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
            </div> --}}
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
                                    {!! Form::label('due_date', 'Fecha de Vencimiento del CI', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input data-bind ="enable: activo" type="text" id="due_date_mask" class="form-control" name="due_date" value="{!! $affiliate->getEditDueDate() !!}" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </div>
                                        </div>
                                    </div>
                    
                                    <div class="col-md-6">
                                        <div class="togglebutton">
                                            <label>
                                                <input type="checkbox" name="is_duedate_undefined"  data-bind="checked: isDateUndifined, click: inputVisible()"> Indefinida
                                            </label>
                                        </div>
                                    </div>
                                </div>
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
                                                <input type="checkbox" data-bind="checked: selected" name="DateDeathAffiliateCheck"> Fallecido
                                              </label>
                                          </div>
                                        </div>
                                    </div>
                                </div>

                                <div data-bind='visible: selected'>

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
                    {!! Form::model($affiliate_address, ['method' => 'PATCH', 'route' => ['affiliate_address.update', $affiliate], 'class' => 'form-horizontal']) !!}
                        <input type="hidden" name="type" value="address"/>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                            {!! Form::label('city_address_id', 'Departamento', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::select('city_address_id', $cities_list, $affiliate_address->city_address_id, ['class' => 'combobox form-control', 'required' => 'required']) !!}
                                        <span class="help-block">Seleccione Departamento</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                        {!! Form::label('zone', 'Zona', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::text('zone', $affiliate_address->zone, ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                                        <span class="help-block">Escriba la Zona</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                        {!! Form::label('number_address', 'Número de Domicilio', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::text('number_address', $affiliate_address->number_address, ['class'=> 'form-control']) !!}
                                        <span class="help-block">Escriba el Número de Domicilio</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                        {!! Form::label('street', 'Calle, Avenida', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::text('street', $affiliate_address->street, ['class'=> 'form-control', 'required' => 'required','onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
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
                                        {!! Form::label('city_birth', 'Lugar Nacimiento', ['class' => 'col-md-5 control-label']) !!}
                                        <div class="col-md-7">
                                            {!! Form::select('city_birth_id', $cities_list, $spouse->city_birth_id, ['class' => 'combobox form-control']) !!}
                                            <span class="help-block">Seleccione Departamento</span>
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
                                                <input type="checkbox" data-bind="checked: DateDeathSpouseCheck" name="DateDeathSpouseCheck"> Fallecido
                                              </label>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                                <div data-bind='visible: DateDeathSpouseCheck'>
                                    <div class="form-group">
                                        {!! Form::label('date_death', 'Fecha Deceso', ['class' => 'col-md-5 control-label']) !!}
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <input type="text" id="date_death_spouse_mask" class="form-control" name="date_death" value={{$spouse->date_death}} data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
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
                                    <div class="form-group">
                                        {!! Form::label('death_certificate_number', 'Nro de certificado de defunción', ['class' => 'col-md-5 control-label']) !!}
                                        <div class="col-md-6">
                                            {!! Form::textarea('death_certificate_number', $spouse->death_certificate_number, ['class'=> 'form-control', 'rows' => '2']) !!}
                                            <span class="help-block">Escriba Número de certificado de defunción</span>
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
                                        {!! Form::select('state',$affiliate_states_list, $affiliate->affiliate_state->id , ['class'=> 'combobox form-control', 'required']) !!}
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
                                        {!! Form::label('date_entry', 'Fecha de Ingreso a la Institución Policial', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        <div class="input-group">
                                            {{$affiliate->date}}
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
                            </div>
                            <div class="col-md-6">
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
                                        {!! Form::select('category',$categories_list, $affiliate->category_id , ['class'=> 'form-control', 'required']) !!}
                                        <span class="help-block">Seleccione una Categoria para el policía</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                        {!! Form::label('degree', 'Grado', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::select('degree',$degrees_list, $affiliate->degree->id , ['class'=> 'combobox form-control', 'required']) !!}
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
                                        {!! Form::select('affiliate_entity_pension',$pension_entities_list, $affiliate->pension_entity->id ?? null , ['class'=> 'combobox form-control', 'required']) !!}
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
    {{-- <div class="modal fade" tabindex="-1" >
        <iframe src="{!! url('history_print/' . $affiliate->id ) !!}" id="historyPdf"></iframe>
    </div> --}}

    
        <!-- Edition of a police officer-->
    @if($devolution)
    <div id="devolutionModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="box-header with-border">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Datos del compromiso de Devolucion por pagos en demasia</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered" style="width:100%;">
                        <tr class="success" >
                            <td class="text-center" style="width:25%"><strong>GESTIÓN</strong></td><td class="text-center" style="width:25%"><strong>MONTO ADEUDADO</strong></td>
                            {{-- <td class="text-center" style="width:25%"><strong>GESTIÓN</strong></td><td class="text-center" style="width:25%"><strong>MONTO ADEUDADO</strong></td> --}}
                        </tr>
                            @foreach($devolution->dues()->whereIn('eco_com_procedure_id', [1,2])->get() as $index=>$due)
                            {{-- @if($index%2 == 0) --}}
                                <tr>
                            {{-- @endif --}}
                                <td>{{ $due->eco_com_procedure->getShortenedName() }}</td>
                                <td class="text-right"><strong>Bs. </strong>  {!! Util::formatMoney($due->amount) ?? '0.00' !!}</td>
                            {{-- @if($index%2 == 1) --}}
                                </tr>
                            {{-- @endif --}}
                            @endforeach
                        </tr>
                    </table>
                    <hr>
                    {!! Form::model($affiliate, ['method' => 'PATCH', 'route' => ['affiliate.update', $affiliate], 'class' => 'form-horizontal']) !!}
                    <input type="hidden" name="type" value="devolutions"/>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <strong>Total Deuda:</strong> {{ Util::formatMoney($devolution->total ?? null) }}
                                </div>
                                <div class="form-group">
                                    <h4><strong>Total Deuda Pendiente:</strong> {{ Util::formatMoney($devolution->balance ?? null) }}</h4>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label class="col-md-2">
                                        Tipo de Descuento
                                    </label>
                                    <div class="col-md-10">
                                    <div class="radio radio-primary">
                                        <label style="font-size: 18px" data-toggle="tooltip" data-placement="top" title="Nota: Solo si la deuda es menor al complemento económico.">
                                            <input type="radio" value="false"  data-bind='checked:total_percentage, attr: {required: show_total_percentage_radio}' name="total_percentage" >Por el Total de la Deuda Pendiente
                                        </label>
                                    </div>
                                    <div class="radio radio-primary">
                                        <label style="font-size: 18px">
                                            <input type="radio"  value="true" data-bind='checked:total_percentage, attr: {required: show_total_percentage_radio}' name="total_percentage"> Porcentaje para Amortizar
                                        </label>
                                    </div>
                                    </div>
                                </div>
                                <div data-bind="visible: show_total_percentage" class="form-group">
                                        {!! Form::label('percentage', 'Porcentaje:', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::select('percentage',$percentage_list, null , ['class'=> 'form-control', 'data-bind'=>'attr: {required: show_total_percentage}']) !!}
                                        <span class="help-block">Seleccione el porcentaje</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="row" data-bind='visible: !show_total_percentage()'>
                                    <div class="col-md-offset-1 col-md-12">
                                        <div class="form-group">
                                            <div class="togglebutton">
                                              <label>
                                                <input type="checkbox" data-bind="checked: immediate_voluntary_return" name="immediate_voluntary_return"> Devolución Voluntaria inmediata 
                                              </label>
                                          </div>
                                        </div>
                                    </div>
                                </div>

                                <div data-bind='visible: immediate_voluntary_return() && !show_total_percentage()'>
                                    <div class="row text-center"><strong>Datos del Deposito</strong></div>
                                    <div class="form-group">
                                            {!! Form::label('deposit_number', 'Constancia de Deposito', ['class' => 'col-md-5 control-label']) !!}
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                {!! Form::text('deposit_number', null,['class'=>'form-control', 'data-bind' => 'attr: {required: immediate_voluntary_return}']) !!}
                                                <span class="help-block">Escriba la constancia de Deposito</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                            {!! Form::label('amount', 'Monto:', ['class' => 'col-md-5 control-label']) !!}
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                {!! Form::text('amount', null, ['class' => 'form-control','data-bind' => 'attr: {required: immediate_voluntary_return}',"data-inputmask"=>"'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'"]) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('payment_date', 'Fecha de Pago:', ['class' => 'col-md-5 control-label',]) !!}
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" id="payment_date" class="form-control" name="payment_date" data-bind ='attr: {required: immediate_voluntary_return}'>
                                                <div class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6"></div>
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
    @endif

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
            //for modal devolutions
            $("#payment_date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/aaaa"});
            $("#amount").inputmask();
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

        // for switch fallecimiento
        var selectedlModel = function() {        
            var self = this;
            self.selected = ko.observable({{ $affiliate->date_death ? true:false }});   
            self.DateDeathSpouseCheck = ko.observable({{ $spouse->date_death ? true:false }});   
        // for switch devolutions
            self.immediate_voluntary_return = ko.observable(false);
            self.total_percentage = ko.observable(false);
            self.show_total_percentage = ko.observable(false);
            self.show_total_percentage_radio = ko.observable(true);
            self.total_percentage.subscribe(function(){
                console.log(self.total_percentage());
                self.show_total_percentage(self.total_percentage() == 'true');
                self.show_total_percentage_radio(self.total_percentage() == 'true');
            });

            //Affiliate due date 
            self.isDateUndifined = ko.observable({{json_encode($affiliate->is_duedate_undefined)}});
            self.activo = ko.observable(!{{json_encode($affiliate->is_duedate_undefined)}});
            self.inputVisible = function(){
                self.activo(!self.isDateUndifined());  
            };

        }

    ko.applyBindings(selectedlModel());
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
                { data: 'gestion', bSortable:false },
                { data: 'created_at', bSortable: false },
                { data: 'wf_state', bSortable: false },
                { data: 'state', bSortable: false },
                { data: 'total', bSortable: false },
                { data: 'action',name: 'action', orderable: false, searchable: false, bSortable: false, sClass: 'text-center'},
            ],
            "aoColumnDefs": [ {
                  "aTargets": [4,5],
                  "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                    if ( oData.eco_com_state_id == 1 || oData.eco_com_state_id == 2 || oData.eco_com_state_id == 3 ) {
                      $(nTd).css('background', 'rgba(93, 193, 0,.5)')
                    }
                  }
                } ]

        });

        //for observations

        // var observationsTable = $('#observations-table').DataTable({
        //     "dom": '<"top">t<"bottom"p>',
        //     processing: true,
        //     serverSide: true,
        //     pageLength: 8,
        //     autoWidth: false,
        //     ajax: {
        //         url: '{!! route('get_observations') !!}',
        //         data: function (d) {
        //             d.id={{$affiliate->id}}
        //         }
        //     },
        //     columns: [

        //         { data: 'date', bSortable: false },
        //         { data: 'type',name:"type" },
        //         { data: 'message', bSortable: false },
        //         { data: 'action', name: 'action', orderable: false, searchable: false, bSortable: false, sClass: 'text-center' }
        //     ]
        // });

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
            $("#due_date_mask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/aaaa"});
        $(document).ready(function() {
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
