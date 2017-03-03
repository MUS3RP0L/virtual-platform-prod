<div class="box box-warning collapsed-box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">Editar Afiliado</h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
          </button>
        </div>
    </div>
    <div class="box-body">
        <br>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <div class="col-md-12">
                            {!! Form::label('identity_card_affi', 'Carnet de Identidad', ['class' => 'col-md-5 control-label']) !!}
                        <div class="col-md-5">
                            {!! Form::text('identity_card_affi', $affiliate->identity_card, ['class'=> 'form-control', 'required']) !!}
                            <span class="help-block">Número de CI</span>
                        </div>
                            {!! Form::select('city_identity_card_id_lg', $cities_list_short, $affiliate->city_identity_card_id, ['class' => 'col-md-2 combobox form-control', 'required']) !!}
                    </div>
                </div>
                <div class="form-group">
                        {!! Form::label('last_name_affi', 'Apellido Paterno', ['class' => 'col-md-5 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::text('last_name_affi', $affiliate->last_name, ['class'=> 'form-control', 'required', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                        <span class="help-block">Escriba el Apellido Paterno</span>
                    </div>
                </div>
                <div class="form-group">
                        {!! Form::label('mothers_last_name_affi', 'Apellido Materno', ['class' => 'col-md-5 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::text('mothers_last_name_affi', $affiliate->mothers_last_name, ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                        <span class="help-block">Escriba el Apellido Materno</span>
                    </div>
                </div>
                @if ($affiliate->gender == 'F')
                    <div class="form-group">
                            {!! Form::label('surname_husband_affi', 'Apellido de Esposo', ['class' => 'col-md-5 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::text('surname_husband_affi', $affiliate->surname_husband, ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                            <span class="help-block">Escriba el Apellido de Esposo (Opcional)</span>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-md-6">
                <div class="form-group">
                        {!! Form::label('first_name_affi', 'Primer Nombre', ['class' => 'col-md-5 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::text('first_name_affi', $affiliate->first_name, ['class'=> 'form-control','required', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                        <span class="help-block">Escriba el  Primer Nombre</span>
                    </div>
                </div>
                <div class="form-group">
                        {!! Form::label('second_name_affi', 'Segundo Nombre', ['class' => 'col-md-5 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::text('second_name_affi', $affiliate->second_name, ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                        <span class="help-block">Escriba el Segundo Nombre</span>
                    </div>
                </div>
                <div class="form-group">
                        {!! Form::label('birth_date_affi', 'Fecha de Nacimiento', ['class' => 'col-md-5 control-label']) !!}
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" id="birth_date_mask" class="form-control" name="birth_date_affi" value="{!! $affiliate->getEditBirthDate() !!}" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
