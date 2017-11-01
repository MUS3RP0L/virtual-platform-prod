    <div class="box box-warning box-solid">
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
                            {!! Form::text('last_name_lg', $eco_com_legal_guardian->last_name, ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
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
                            {!! Form::label('surname_husband_lg', 'Apellido de Esposo', ['class' => 'col-md-5 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::text('surname_husband_lg', $eco_com_legal_guardian->surname_husband, ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                            <span class="help-block">Escriba el Apellido de Esposo (Opcional)</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                     <div class="form-group">
                            {!! Form::label('due_date', 'Fecha de Vencimiento del CI', ['class' => 'col-md-5 control-label']) !!}
                            <div class="col-md-7">
                                <div class="input-group">
                                    <input data-bind ="enable: activolg" type="text" id="due_date_lg_mask" class="form-control" value="{{$eco_com_legal_guardian->getEditDueDate()}}" name="due_date_lg" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </div>
                                </div>
                                <div class="togglebutton">
                                    <label>
                                        <input type="checkbox" name="is_duedate_undefinedlg"  data-bind="checked: isDateUndifinedlg, click: inputVisiblelg()"> Indefinida
                                    </label>
                                </div>
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
                    <div class="form-group" id="phonesNumbersGuardian" style="padding-bottom:5px;">
                            {!! Form::label('phone_number_lg', 'Teléfono fijo', ['class' => 'col-md-5 control-label']) !!}
                            @foreach(explode(',',$eco_com_legal_guardian->phone_number) as $key=>$phone)
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
                                @foreach(explode(',',$eco_com_legal_guardian->cell_phone_number) as $key=>$phone)
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
        </div>
    </div>

