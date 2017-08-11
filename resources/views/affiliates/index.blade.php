@extends('app')

@section('contentheader_title')

    <div class="row">
        <div class="col-md-10">
            {!! Breadcrumbs::render('affiliates') !!}
        </div>
        <div class="col-md-2 text-right">
            <div >
                <a data-toggle="tooltip" data-placement="top" data-original-title="Nuevo" href="" class="btn btn bg-olive" data-toggle="modal" data-target="#myModal-personal">
                    <span class="fa fa-lg fa-plus" aria-hidden="true"></span>
                </a>
                <a data-toggle="tooltip" data-placement="top" data-original-title="Observados" href="{{url('observations')}}" class="btn btn bg-olive" >
                    <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                </a>
            </div>
         
        </div>
    </div>

@endsection

@section('main-content')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title"><span class="glyphicon glyphicon-search"></span> Búsqueda</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <form method="POST" id="search-form" role="form" class="form-horizontal">
                            <div class="col-md-11">
                                <div class="row"><br>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {!! Form::label('first_name', 'Primer Nombre', ['class' => 'col-md-5 control-label']) !!}
                                            <div class="col-md-7">
                                                {!! Form::text('first_name', '', ['class'=> 'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {!! Form::label('second_name', 'Segundo Nombre', ['class' => 'col-md-5 control-label']) !!}
                                            <div class="col-md-7">
                                                {!! Form::text('second_name', '', ['class'=> 'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {!! Form::label('identity_card', 'Número Carnet', ['class' => 'col-md-5 control-label']) !!}
                                            <div class="col-md-7">
                                                {!! Form::text('num_identity_card', '', ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row"><br>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {!! Form::label('last_name', 'Apellido Paterno', ['class' => 'col-md-5 control-label']) !!}
                                            <div class="col-md-7">
                                                {!! Form::text('last_name', '', ['class'=> 'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {!! Form::label('mothers_last_name', 'Apellido Materno', ['class' => 'col-md-5 control-label']) !!}
                                            <div class="col-md-7">
                                                {!! Form::text('mothers_last_name', '', ['class'=> 'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {!! Form::label('registration', 'Número Matrícula', ['class' => 'col-md-5 control-label']) !!}
                                            <div class="col-md-7">
                                                {!! Form::text('registration', '', ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            </div>
                            <div class="col-md-12">
                                <div class="row text-center">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <button type="reset" class="btn btn-raised btn-warning" data-toggle="tooltip" data-placement="bottom" data-original-title="Limpiar">&nbsp;<span class="glyphicon glyphicon-erase"></span>&nbsp;</button>
                                            &nbsp;&nbsp;<button type="submit" class="btn btn-raised btn-success" data-toggle="tooltip" data-placement="bottom" data-original-title="Buscar">&nbsp;<span class="glyphicon glyphicon-search"></span>&nbsp;</button>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            </div>
                        </form>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered table-hover" id="affiliates-table">
                                <thead>
                                    <tr class="success">
                                        <th>Núm. Carnet</th>
                                        <th>Matrícula</th>
                                        <th>Grado</th>
                                        <th>Nombres</th>
                                        <th>Apellido Paterno</th>
                                        <th>Apellido Materno</th>
                                        <th>Estado</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
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
                    <h4 class="modal-title">Crear nuevo Afiliado</h4>
                </div>
                <div class="modal-body">

                    {!! Form::open(['method' => 'POST', 'route' => ['affiliate.store'], 'class' => 'form-horizontal']) !!}
                        <input type="hidden" name="type" value="personal_new"/>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                        {!! Form::label('identity_card', 'Carnet de Identidad', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-5">
                                        {!! Form::text('identity_card', '', ['class'=> 'form-control', 'required']) !!}
                                        <span class="help-block">Número de CI</span>
                                    </div>
                                        {!! Form::select('city_identity_card_id', $cities_list_short,'', ['class' => 'col-md-2 combobox form-control', 'required']) !!}
                                </div>
                                <div class="form-group">
                                        {!! Form::label('last_name', 'Apellido Paterno', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::text('last_name', '', ['class'=> 'form-control',  'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                                        <span class="help-block">Escriba el Apellido Paterno</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                        {!! Form::label('mothers_last_name', 'Apellido Materno', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::text('mothers_last_name', '', ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                                        <span class="help-block">Escriba el Apellido Materno</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                        {!! Form::label('first_name', 'Primer Nombre', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::text('first_name', '', ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()', 'required']) !!}
                                        <span class="help-block">Escriba el  Primer Nombre</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                        {!! Form::label('second_name', 'Segundo Nombre', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::text('second_name', '', ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                                        <span class="help-block">Escriba el Segundo Nombre</span>
                                    </div>
                                </div>
                                {{-- @if ($affiliate->gender == 'F') --}}
                                    <div class="form-group">
                                            {!! Form::label('surname_husband', 'Apellido de Esposo', ['class' => 'col-md-5 control-label']) !!}
                                        <div class="col-md-7">
                                            {!! Form::text('surname_husband', '', ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                                            <span class="help-block">Escriba el Apellido de Esposo (Opcional)</span>
                                        </div>
                                    </div>
                                {{-- @endif --}}
                                <div class="form-group">
                                        {!! Form::label('nua', 'CUA/NUA', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-6">
                                        {!! Form::number('nua', '', ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()','required']) !!}
                                        <span class="help-block">Escriba el CUA/NUA</span>
                                    </div>
                                </div>
                                <div class="form-group" id="phonesNumbers" style="padding-bottom:5px;">

                                    {!! Form::label('phone_number', 'Teléfono fijo', ['class' => 'col-md-5 control-label']) !!}
                                    @foreach(explode(',',null) as $key=>$phone)
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
                                        @foreach(explode(',',null) as $key=>$phone)
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

                            <div class="col-md-6">
                                <div class="form-group">
                                        {!! Form::label('gender', 'Género', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::select('gender', [''=>'','M'=>'Masculino','F'=>'Femenino'] , '', ['class' => 'combobox form-control','required']) !!}
                                        <span class="help-block">Seleccione Género</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                        {!! Form::label('birth_date', 'Fecha de Nacimiento', ['class' => 'col-md-5 control-label','required']) !!}
                                    <div class="col-md-7">
                                        <div class="input-group">
                                            <input type="text" id="birth_date_mask" required class="form-control" name="birth_date" value="" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                            {!! Form::label('civil_status', 'Estado Civil', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::select('civil_status', $gender_list, '', ['class' => 'combobox form-control', 'required']) !!}
                                        <span class="help-block">Seleccione el Estado Civil</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                            {!! Form::label('city_birth_id', 'Lugar de Nacimiento', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::select('city_birth_id', $cities_list, '', ['class' => 'combobox form-control', 'required']) !!}
                                        <span class="help-block">Seleccione Departamento</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('type_affiliate', 'Tipo Afiliado', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        <select name="type_affiliate" class="combobox form-control" required="required">
                                          <option>Comando</option>
                                          <option>Batallón</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('category', 'Categoría', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::select('category',$categories_list, '', ['class'=> 'combobox form-control', 'required']) !!}
                                        <span class="help-block">Seleccione Categoría</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('pension', 'Ente Gestor', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::select('pension',$pension_entities_list, '', ['class'=> 'combobox form-control', 'required']) !!}
                                        <span class="help-block">Seleccione un ente gestor</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                        {!! Form::label('degree', 'Grado', ['class' => 'col-md-5 control-label']) !!}
                                    <div class="col-md-7">
                                        {!! Form::select('degree',$degrees_list, '', ['class'=> 'combobox form-control', 'required']) !!}
                                        <span class="help-block">Seleccione un grado del policía</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row text-center">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <a href="{!! url('affiliate') !!}" class="btn btn-raised btn-warning" data-toggle="tooltip" data-placement="bottom" data-original-title="Cancelar">&nbsp;<i class="glyphicon glyphicon-remove"></i>&nbsp;</a>
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

@endsection

@push('scripts')
    <script>

        $(document).ready(function(){
            $("#birth_date_mask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/aaaa"});
            $('.combobox').combobox();
            $('[data-toggle="tooltip"]').tooltip();
            $("#phone_number").inputmask();
            $("#cell_phone_number").inputmask();
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
        });

        var oTable = $('#affiliates-table').DataTable({
            "dom": '<"top">t<"bottom"p>',
            processing: true,
            serverSide: true,
            pageLength: 8,
            autoWidth: false,
            ajax: {
                url: '{!! route('get_affiliate') !!}',
                data: function (d) {
                    d.last_name = $('input[name=last_name]').val();
                    d.mothers_last_name = $('input[name=mothers_last_name]').val();
                    d.first_name = $('input[name=first_name]').val();
                    d.second_name = $('input[name=second_name]').val();
                    d.registration = $('input[name=registration]').val();
                    d.identity_card = $('input[name=num_identity_card]').val();
                    d.post = $('input[name=post]').val();
                }
            },
            columns: [
                { data: 'identity_card'},
                { data: 'registration', bSortable: false },
                { data: 'degree', bSortable: false },
                { data: 'names', bSortable: false },
                { data: 'last_name', bSortable: false },
                { data: 'mothers_last_name', bSortable: false },
                { data: 'state', bSortable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false, bSortable: false, sClass: 'text-center' }
            ]
        });

        $('#search-form').on('submit', function(e) {
            oTable.draw();
            e.preventDefault();
        });

    </script>
@endpush
