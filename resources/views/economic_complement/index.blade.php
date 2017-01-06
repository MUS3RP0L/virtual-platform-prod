@extends('app')

@section('contentheader_title')
    <div class="row">
        <div class="col-md-10">
            {!! Breadcrumbs::render('economic_complements') !!}
        </div>
        <div class="col-md-2">

            <div class="btn-group" class="btn btn-raised btn-success" data-toggle="tooltip" data-placement="top" data-original-title="Exportar" style="margin:0px;">
                <a href="" class="btn btn-success btn-raised dropdown-toggle" data-toggle="dropdown">
                    &nbsp;<span class="glyphicon glyphicon-export"></span>&nbsp;
                </a>
                <ul class="dropdown-menu"  role="menu">

                    <li role="separator" class="divider"></li>
                    <li>
                      <a href="" class="btn btn-raised btn-xs btn-primary" data-toggle="modal" data-target="#myModal-exportaps">&nbsp;&nbsp;
                          <span class="glyphicon glyphicon-export" aria-hidden="true">&nbsp;APS</span>&nbsp;&nbsp;
                      </a>
                    </li>
                    <li role="separator" class="divider"></li>
                    <li>
                      <a href="" class="btn btn-raised btn-xs btn-primary" data-toggle="modal" data-target="#myModal-exportbanco">&nbsp;&nbsp;
                          <span class="glyphicon glyphicon-export" aria-hidden="true">&nbsp;Banco</span>&nbsp;&nbsp;
                      </a>
                    </li>
                </ul>
            </div>

            <div class="btn-group" class="btn btn-raised btn-success" data-toggle="tooltip" data-placement="top" data-original-title="Importar" style="margin:0px;">
                <a href="" class="btn btn-success btn-raised dropdown-toggle" data-toggle="dropdown">
                    &nbsp;<span class="glyphicon glyphicon-import"></span>&nbsp;
                </a>
                <ul class="dropdown-menu"  role="menu">
                    <li>
                      <a href="" class="btn btn-raised btn-xs btn-primary" data-toggle="modal" data-target="#myModal-importsenasir">&nbsp;&nbsp;
                          <span class="glyphicon glyphicon-import" aria-hidden="true">&nbsp;Senasir</span>&nbsp;&nbsp;
                      </a>
                    </li>
                    <li role="separator" class="divider"></li>
                    <li>
                      <a href="" class="btn btn-raised btn-xs btn-primary" data-toggle="modal" data-target="#myModal-importaps">&nbsp;&nbsp;
                          <span class="glyphicon glyphicon-import" aria-hidden="true">&nbsp;APS</span>&nbsp;&nbsp;
                      </a>
                    </li>
                    <li role="separator" class="divider"></li>
                    <li>
                      <a href="" class="btn btn-raised btn-xs btn-primary" data-toggle="modal" data-target="#myModal-importbanco">&nbsp;&nbsp;
                          <span class="glyphicon glyphicon-import" aria-hidden="true">&nbsp;Banco</span>&nbsp;&nbsp;
                      </a>
                    </li>
                </ul>
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
                                            {!! Form::label('code', 'Número Proceso', ['class' => 'col-md-5 control-label']) !!}
                                            <div class="col-md-7">
                                                {!! Form::text('code', '', ['class'=> 'form-control']) !!}
                                                <span class="help-block">Escriba el Número Trámite</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {!! Form::label('creation_date', 'Fecha de Emisión', ['class' => 'col-md-5 control-label']) !!}
                                            <div class="col-md-7">
                                    			<div class="input-group">
                                                    <input type="text" class="form-control datepicker" name="creation_date" value="">
                                                    <div class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {!! Form::label('eco_com_type', 'Tipo', ['class' => 'col-md-5 control-label']) !!}
        									<div class="col-md-7">
        										{!! Form::select('eco_com_type', $eco_com_types_list, null, ['class' => 'form-control']) !!}
        										<span class="help-block">Selecione el tipo de Proceso</span>
        									</div>
    									</div>
                                    </div>
                                </div>
                                <div class="row"><br>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {!! Form::label('affiliate_identitycard', 'Número Carnet', ['class' => 'col-md-5 control-label']) !!}
                                            <div class="col-md-7">
                                                {!! Form::text('affiliate_identitycard', '', ['class'=> 'form-control', 'onkeyup' => 'this.value=this.value.toUpperCase()']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {!! Form::label('eco_com_state_id', 'Estado', ['class' => 'col-md-5 control-label']) !!}
                                            <div class="col-md-7">
                                                {!! Form::select('eco_com_state_id', $eco_com_states_list, '', ['class' => 'combobox form-control']) !!}
                                                <span class="help-block">Seleccione Estado</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
        									{!! Form::label('eco_com_modality_id', 'Modalidad', ['class' => 'col-md-5 control-label']) !!}
        									<div class="col-md-7">
        										{!! Form::select('eco_com_modality_id', ['clear' => ''], null, ['class' => 'form-control']) !!}

        										<span class="help-block">Selecione la Modalidad</span>
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
                            <table class="table table-bordered table-hover" id="economic_complements-table">
                                <thead>
                                    <tr class="success">
                                        <th class="text-center"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Número de Trámite">Número</div></th>
                                        <th class="text-left"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Concepto de Cobro">Número de Carnet</div></th>
                                        <th class="text-left"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Nombre de Afiliado">Nombre de Afiliado</div></th>
                                        <th class="text-left"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Total a Pagar">Fecha Emisión</div></th>
                                        <th class="text-left"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Estado">Estado</div></th>
                                        <th class="text-left"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Fecha de Pago">Modalidad</div></th>
                                        <th class="text-center">Acción</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

{{-- ############################## EXPORT AFFILIATES OF ECONOMIC COMPLEMENT ############################################ --}}
{{-- EXPORT FOR APS --}}
<div id="myModal-exportaps" class="modal fade bs-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="box-header with-border">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Exportar Afiliados de Complemento Económico de APS</h4>
                    </div>
                    <div class="modal-body">

                        {!! Form::open(['method' => 'POST', 'route' => ['export_aps'], 'class' => 'form-horizontal', 'files' => true ]) !!}

                            <br>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                            {!! Form::label('year', 'Año', ['class' => 'col-md-3 control-label']) !!}
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                  {!! Form::text('year', $year, ['class'=> 'form-control', 'required' => 'required']) !!}
                                                  <span class="help-block">Año</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                            {!! Form::label('semestre', 'Semestre', ['class' => 'col-md-3 control-label']) !!}
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                  {!! Form::select('semester',$list_semester,'',['class' => 'combobox form-control', 'required' => 'required']) !!}
                                                  <span class="help-block">Seleccione Semestre</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row text-center">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <a href="{!! url('economic_complement') !!}" class="btn btn-raised btn-warning" data-toggle="tooltip" data-placement="bottom" data-original-title="Cancelar">&nbsp;<i class="glyphicon glyphicon-remove"></i>&nbsp;</a>
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

{{-- EXPORT FOR BANK --}}
<div id="myModal-exportbanco" class="modal fade bs-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="box-header with-border">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Exportar Afiliados de Complemento Económico - BANCO</h4>
                    </div>
                    <div class="modal-body">

                        {!! Form::open(['method' => 'POST', 'route' => ['export_bank'], 'class' => 'form-horizontal', 'files' => true ]) !!}

                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                            {!! Form::label('year', 'Año', ['class' => 'col-md-3 control-label']) !!}
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                  {!! Form::text('year', $year, ['class'=> 'form-control', 'required' => 'required']) !!}
                                                  <span class="help-block">Año</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                            {!! Form::label('semestre', 'Semestre', ['class' => 'col-md-3 control-label']) !!}
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                  {!! Form::select('semester',$list_semester,'',['class' => 'combobox form-control', 'required' => 'required']) !!}
                                                  <span class="help-block">Seleccione Semestre</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row text-center">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <a href="{!! url('economic_complement') !!}" class="btn btn-raised btn-warning" data-toggle="tooltip" data-placement="bottom" data-original-title="Cancelar">&nbsp;<i class="glyphicon glyphicon-remove"></i>&nbsp;</a>
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

{{-- ##############################IMPORT AFFILIATES OF ECONOMIC COMPLEMENT ############################################ --}}
{{-- IMPORT FROM SENASIR --}}
<div id="myModal-importsenasir" class="modal fade bs-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="box-header with-border">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title">Importar Afiliados de Complemento Económico de SENASIR</h4>
                  </div>
                  <div class="modal-body">

                      {!! Form::open(['method' => 'POST', 'route' => ['import_senasir'], 'class' => 'form-horizontal', 'files' => true ]) !!}

                          <br>
                          <div class="row">
                              <div class="col-md-12">
                                  <div class="form-group">
                                          {!! Form::label('archive', 'Archivo', ['class' => 'col-md-3 control-label']) !!}
                                      <div class="col-md-8">
                                          <input type="file" id="inputFile" name="archive" required>
                                          <input type="text" readonly="" class="form-control " placeholder="Formato Excel">
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-12">
                                  <div class="form-group">
                                          {!! Form::label('year', 'Año', ['class' => 'col-md-3 control-label']) !!}
                                      <div class="col-md-7">
                                          <div class="input-group">
                                                {!! Form::text('year', $year, ['class'=> 'form-control', 'required' => 'required']) !!}
                                                <span class="help-block">Año</span>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>

                          <div class="row">
                              <div class="col-md-12">
                                  <div class="form-group">
                                          {!! Form::label('semestre', 'Semestre', ['class' => 'col-md-3 control-label']) !!}
                                      <div class="col-md-7">
                                          <div class="form-group">
                                                {!! Form::select('semester',$list_semester,'',['class' => 'combobox form-control', 'required' => 'required']) !!}
                                                <span class="help-block">Seleccione Semestre</span>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="row text-center">
                              <div class="form-group">
                                  <div class="col-md-12">
                                      <a href="{!! url('economic_complement') !!}" class="btn btn-raised btn-warning" data-toggle="tooltip" data-placement="bottom" data-original-title="Cancelar">&nbsp;<i class="glyphicon glyphicon-remove"></i>&nbsp;</a>
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

{{-- IMPORT FROM APS --}}
<div id="myModal-importaps" class="modal fade bs-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="box-header with-border">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title">Importar Afiliados de Complemento Económico de APS</h4>
                  </div>
                  <div class="modal-body">

                      {!! Form::open(['method' => 'POST', 'route' => ['import_aps'], 'class' => 'form-horizontal', 'files' => true ]) !!}

                          <br>
                          <div class="row">
                              <div class="col-md-12">
                                  <div class="form-group">
                                          {!! Form::label('archive', 'Archivo', ['class' => 'col-md-3 control-label']) !!}
                                      <div class="col-md-8">
                                          <input type="file" id="inputFile" name="archive" required>
                                          <input type="text" readonly="" class="form-control " placeholder="Formato Excel">
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-12">
                                  <div class="form-group">
                                          {!! Form::label('year', 'Año', ['class' => 'col-md-3 control-label']) !!}
                                      <div class="col-md-7">
                                          <div class="input-group">
                                                {!! Form::text('year', $year, ['class'=> 'form-control', 'required' => 'required']) !!}
                                                <span class="help-block">Año</span>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>

                          <div class="row">
                              <div class="col-md-12">
                                  <div class="form-group">
                                          {!! Form::label('semestre', 'Semestre', ['class' => 'col-md-3 control-label']) !!}
                                      <div class="col-md-7">
                                          <div class="form-group">
                                                {!! Form::select('semester',$list_semester,'',['class' => 'combobox form-control', 'required' => 'required']) !!}
                                                <span class="help-block">Seleccione Semestre</span>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="row text-center">
                              <div class="form-group">
                                  <div class="col-md-12">
                                      <a href="{!! url('economic_complement') !!}" class="btn btn-raised btn-warning" data-toggle="tooltip" data-placement="bottom" data-original-title="Cancelar">&nbsp;<i class="glyphicon glyphicon-remove"></i>&nbsp;</a>
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

{{-- IMPORT FROM BANK--}}
<div id="myModal-importbanco" class="modal fade bs-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="box-header with-border">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title">Importar Afiliados de Complemento Económico - BANCO</h4>
                  </div>
                  <div class="modal-body">

                      {!! Form::open(['method' => 'POST', 'route' => ['import_bank'], 'class' => 'form-horizontal', 'files' => true ]) !!}

                          <br>
                          <div class="row">
                              <div class="col-md-12">
                                  <div class="form-group">
                                          {!! Form::label('archive', 'Archivo', ['class' => 'col-md-3 control-label']) !!}
                                      <div class="col-md-8">
                                          <input type="file" id="inputFile" name="archive" required>
                                          <input type="text" readonly="" class="form-control " placeholder="Formato Excel">
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-12">
                                  <div class="form-group">
                                          {!! Form::label('year', 'Año', ['class' => 'col-md-3 control-label']) !!}
                                      <div class="col-md-7">
                                          <div class="input-group">
                                                {!! Form::text('year', $year, ['class'=> 'form-control', 'required' => 'required']) !!}
                                                <span class="help-block">Año</span>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>

                          <div class="row">
                              <div class="col-md-12">
                                  <div class="form-group">
                                          {!! Form::label('semestre', 'Semestre', ['class' => 'col-md-3 control-label']) !!}
                                      <div class="col-md-7">
                                          <div class="form-group">
                                                {!! Form::select('semester',$list_semester,'',['class' => 'combobox form-control', 'required' => 'required']) !!}
                                                <span class="help-block">Seleccione Semestre</span>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="row text-center">
                              <div class="form-group">
                                  <div class="col-md-12">
                                      <a href="{!! url('economic_complement') !!}" class="btn btn-raised btn-warning" data-toggle="tooltip" data-placement="bottom" data-original-title="Cancelar">&nbsp;<i class="glyphicon glyphicon-remove"></i>&nbsp;</a>
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
            $('select[name="eco_com_type"]').on('change', function() {
                var moduleID = $(this).val();
                if(moduleID) {
                    $.ajax({
                        url: '{!! url('get_economic_complement_type') !!}/'+moduleID,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="eco_com_modality_id"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="eco_com_modality_id"]').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                            });
                        }
                    });
                }
                else{
                    $('select[name="eco_com_modality_id"]').empty();
                }
            });
        });

        $(document).ready(function(){
           $('.combobox').combobox();
        });

        $('.datepicker').datepicker({
            format: "dd/mm/yyyy",
            language: "es",
            orientation: "bottom right",
            daysOfWeekDisabled: "0,6",
            autoclose: true
        });

        var oTable = $('#economic_complements-table').DataTable({
            "dom": '<"top">t<"bottom"p>',
            processing: true,
            serverSide: true,
            pageLength: 8,
            autoWidth: false,
            order: [0, "desc"],
            ajax: {
                url: '{!! route('get_economic_complement') !!}',
                data: function (d) {
                    d.code = $('input[name=code]').val();
                    d.affiliate_identitycard = $('input[name=affiliate_identitycard]').val();
                    d.creation_date = $('input[name=creation_date]').val();
                    d.eco_com_state_id = $('input[name=eco_com_state_id]').val();
                    d.eco_com_modality_id = $('input[name=eco_com_modality_id]').val();
                    d.post = $('input[name=post]').val();
                }
            },
            columns: [
                { data: 'code', sClass: "text-center" },
                { data: 'affiliate_identitycard', bSortable: false },
                { data: 'affiliate_name', bSortable: false },
                { data: 'created_at', bSortable: false },
                { data: 'eco_com_state', bSortable: false },
                { data: 'eco_com_modality', bSortable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false, bSortable: false, sClass: "text-center" }
            ]
        });

        $('#search-form').on('submit', function(e) {
            oTable.draw();
            e.preventDefault();
        });

    </script>
@endpush
