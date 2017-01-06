@extends('app')
@section('contentheader_title')
        <div class="row">
            <div class="col-md-6">
                {{-- {!! Breadcrumbs::render('show_affiliate', $affiliate) !!} --}}
            </div>
            <div class="col-md-4">

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
                                    <a href="{!! url('importexport') !!}" class="btn btn-raised btn-warning" data-toggle="tooltip" data-placement="bottom" data-original-title="Cancelar">&nbsp;<i class="glyphicon glyphicon-remove"></i>&nbsp;</a>
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
                                    <a href="{!! url('importexport') !!}" class="btn btn-raised btn-warning" data-toggle="tooltip" data-placement="bottom" data-original-title="Cancelar">&nbsp;<i class="glyphicon glyphicon-remove"></i>&nbsp;</a>
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
                                  <a href="{!! url('importexport') !!}" class="btn btn-raised btn-warning" data-toggle="tooltip" data-placement="bottom" data-original-title="Cancelar">&nbsp;<i class="glyphicon glyphicon-remove"></i>&nbsp;</a>
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
                                  <a href="{!! url('importexport') !!}" class="btn btn-raised btn-warning" data-toggle="tooltip" data-placement="bottom" data-original-title="Cancelar">&nbsp;<i class="glyphicon glyphicon-remove"></i>&nbsp;</a>
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

{{-- IMPORT FROM BANCO --}}
<div id="myModal-importbanco" class="modal fade bs-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="box-header with-border">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title">Importar Afiliados de Complemento Económico de BANCO</h4>
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
                                  <a href="{!! url('importexport') !!}" class="btn btn-raised btn-warning" data-toggle="tooltip" data-placement="bottom" data-original-title="Cancelar">&nbsp;<i class="glyphicon glyphicon-remove"></i>&nbsp;</a>
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

@endpush
