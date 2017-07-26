@extends('app')

@section('contentheader_title')

    <div class="row">
        <div class="col-md-12">
            {!! Breadcrumbs::render('create_economic_complement', $affiliate) !!}
        </div>
    </div>

@endsection

@section('main-content')

    <div class="row">
        <div class="col-md-6">
            @include('affiliates.simple_info')
        </div>
        <div class="col-md-6">
            @include('economic_complements.additional.general_info')
        </div>
    </div>

    <div class="row text-center">
        <div class="col-md-12">
            <div class="form-group">
                <ul class="nav nav-pills" style="display:flex;justify-content:center;">
                    <li><a href="{!! url('economic_complement_reception_first_step/' . $economic_complement->affiliate_id) !!}"><span class="badge">1</span> Tipo de Proceso</a></li>
                    <li class="active"><a href="#"><span class="badge">2</span> Beneficiario</a></li>
                    <li><a href="#"><span class="badge">3</span> Requisitos</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            {!! Form::model($economic_complement, ['method' => 'PATCH', 'route' => ['economic_complement.update', $economic_complement->id], 'class' => 'form-horizontal']) !!}
                <input type="hidden" name="step" value="second"/>
                <input type="hidden" name="type" value="create"/>

                @if($economic_complement->economic_complement_modality->economic_complement_type->id > 1)
                    @include('economic_complements.additional.edit_affiliate_info')
                @endif

                <div class="box box-warning box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Editar
                            @if($economic_complement->economic_complement_modality->economic_complement_type->id == 2)
                                Derechohabiente
                            @else
                                Beneficiario
                            @endif
                        </h3>
                    </div>
                    <div class="box-body">
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="col-md-12">
                                            {!! Form::label('identity_card', 'Carnet de Identidad', ['class' => 'col-md-5 control-label']) !!}
                                        <div class="col-md-5">
                                            {!! Form::text('identity_card', $eco_com_applicant->identity_card, ['class'=> 'form-control','required']) !!}
                                            <span class="help-block">Número de CI</span>
                                        </div>
                                            {!! Form::select('city_identity_card_id', $cities_list_short, $eco_com_applicant->city_identity_card_id, ['class' => 'col-md-2 combobox form-control','required']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                        {!! Form::label('last_name', 'Apellido Paterno', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-6">
                                        {!! Form::text('last_name', $eco_com_applicant->last_name, ['class'=> 'form-control','onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
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
                                @if ($eco_com_applicant->gender == 'F')
                                    <div class="form-group">
                                            {!! Form::label('surname_husband', 'Apellido de Esposo', ['class' => 'col-md-5 control-label']) !!}
                                        <div class="col-md-6">
                                            {!! Form::text('surname_husband', $eco_com_applicant->surname_husband, ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                                            <span class="help-block">Escriba el Apellido de Esposo (Opcional)</span>
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group">
                                        {!! Form::label('first_name', 'Primer Nombre', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-6">
                                        {!! Form::text('first_name', $eco_com_applicant->first_name, ['class'=> 'form-control','required', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
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
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('gender', 'Sexo', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::select('gender', ['M'=>'Masculino','F'=>'Femenino'] ,null, ['class' => 'combobox form-control','required']) !!}
                                        <span class="help-block">Seleccione Sexo</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                        {!! Form::label('birth_date', 'Fecha de Nacimiento', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-6">
                            			<div class="input-group">
                                            <input type="text" id="birth_date_appli_mask" class="form-control" name="birth_date" value="{!! $eco_com_applicant->getEditBirthDate() !!}" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask required="required">
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if($economic_complement->eco_com_modality_id == 1)
                                <div class="form-group">
                                            {!! Form::label('city_birth_id', 'Lugar de Nacimiento', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::select('city_birth_id', $cities_list, $affiliate->city_birth_id, ['class' => 'combobox form-control']) !!}
                                        <span class="help-block">Seleccione Departamento</span>
                                    </div>
                                </div>
                                @endif
                                <div class="form-group">
                                        {!! Form::label('nua', 'CUA/NUA', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-6">
                                        {!! Form::text('nua', $eco_com_applicant->nua, ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                                        <span class="help-block">Escriba el CUA/NUA</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                            {!! Form::label('civil_status', 'Estado Civil', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-6">
                                        {!! Form::select('civil_status', $gender_list, $eco_com_applicant->civil_status, ['class' => 'combobox form-control', 'required']) !!}
                                        <span class="help-block">Seleccione el Estado Civil</span>
                                    </div>
                                </div>
                                <div class="form-group" id="phonesNumbers" style="padding-bottom:5px;">

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
                                        @foreach(explode(',',$eco_com_applicant->cell_phone_number) as $key=>$phone)
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
                            </div>
                        </div>
                    </div>
                </div>

                @if($economic_complement->has_legal_guardian)
                    @include('economic_complements.additional.legal_guardian_info')
                @endif

            <div class="row text-center">
                <div class="form-group">
                    <div class="col-md-12">
                        <a href="{!! url('economic_complement_reception_first_step/' . $economic_complement->affiliate_id) !!}" class="btn btn-raised btn-warning" data-toggle="tooltip" data-placement="bottom" data-original-title="Volver">&nbsp;<span class="fa fa-undo"></span>&nbsp;</a>
                        &nbsp;&nbsp;&nbsp;
                        <button type="submit" class="btn btn-raised btn-success" data-toggle="tooltip" data-placement="bottom" data-original-title="Siguiente">&nbsp;<i class="fa fa-arrow-right"></i>&nbsp;</button>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

@endsection

@push('scripts')
    <script type="text/javascript">

        $(document).ready(function(){
            $('.combobox').combobox();
            $('[data-toggle="tooltip"]').tooltip();
            $("#birth_date_affi_mask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/aaaa"});
            $("#birth_date_appli_mask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/aaaa"});
            $("#phone_number_guardian").inputmask();
            $("#cell_phone_number_guardian").inputmask();
            $("input[name='phone_number[]']").inputmask();
            $("input[name='cell_phone_number[]']").inputmask();
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
            $(document).on('click', '.deleteCellPhone', function(event) {
                $(this).parent().parent().remove();
                event.preventDefault();
            });

    </script>
@endpush
