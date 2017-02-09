<div class="col-md-6">
    <div class="box box-warning">
        <div class="box-header with-border">
            <h3 class="box-title">Editar Apoderado</h3>
        </div>
        <div class="box-body">
            <br>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="col-md-12">
                                {!! Form::label('identity_card_lg', 'Carnet de Identidad', ['class' => 'col-md-5 control-label']) !!}
                            <div class="col-md-5">
                                {!! Form::text('identity_card_lg', $eco_com_legal_guardian->identity_card, ['class'=> 'form-control', 'required']) !!}
                                <span class="help-block">Número de CI</span>
                            </div>
                                {!! Form::select('city_identity_card_id_lg', $cities_list_short, $eco_com_legal_guardian->city_identity_card_id, ['class' => 'col-md-2 combobox form-control', 'required']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                            {!! Form::label('last_name_lg', 'Apellido Paterno', ['class' => 'col-md-5 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::text('last_name_lg', $eco_com_legal_guardian->last_name, ['class'=> 'form-control', 'required', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                            <span class="help-block">Escriba el Apellido Paterno</span>
                        </div>
                    </div>
                    <div class="form-group">
                            {!! Form::label('mothers_last_name_lg', 'Apellido Materno', ['class' => 'col-md-5 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::text('mothers_last_name_lg', $eco_com_legal_guardian->mothers_last_name, ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                            <span class="help-block">Escriba el Apellido Materno</span>
                        </div>
                    </div>
                    <div class="form-group">
                            {!! Form::label('first_name_lg', 'Primer Nombre', ['class' => 'col-md-5 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::text('first_name_lg', $eco_com_legal_guardian->first_name, ['class'=> 'form-control','required', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                            <span class="help-block">Escriba el  Primer Nombre</span>
                        </div>
                    </div>
                    <div class="form-group">
                            {!! Form::label('second_name_lg', 'Segundo Nombre', ['class' => 'col-md-5 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::text('second_name_lg', $eco_com_legal_guardian->second_name, ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                            <span class="help-block">Escriba el Segundo Nombre</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                            {!! Form::label('phone_number_lg', 'Teléfono fijo', ['class' => 'col-md-5 control-label']) !!}
                        <div class="col-md-6">
                            <input type="text" id="phone_number_lg" class="form-control" name="phone_number_lg" value="{!! $eco_com_legal_guardian->phone_number !!}" data-inputmask="'mask': '(9) 999 999'" data-mask>
                            <span class="help-block">Escriba el Teléfono fijo</span>
                        </div>
                    </div>
                    <div class="form-group">
                            {!! Form::label('cell_phone_number_lg', 'Teléfono Celular', ['class' => 'col-md-5 control-label']) !!}
                        <div class="col-md-6">
                            <input type="text" id="cell_phone_number_lg" class="form-control" name="cell_phone_number_lg" value="{!! $eco_com_legal_guardian->cell_phone_number !!}" data-inputmask="'mask': '(999) 99999'" data-mask>
                            <span class="help-block">Escriba el Teléfono Celular</span>
                        </div>
                    </div>
                    <div class="form-group">
                            {!! Form::label('surname_husband_lg', 'Apellido de Esposo', ['class' => 'col-md-5 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::text('surname_husband_lg', $eco_com_legal_guardian->surname_husband, ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                            <span class="help-block">Escriba el Apellido de Esposo (Opcional)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
