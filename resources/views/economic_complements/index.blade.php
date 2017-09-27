@extends('app')

@section('contentheader_title')
    <div class="row">
        <div class="col-md-6">
            {!! Breadcrumbs::render('economic_complements') !!}
        </div>
        <div class="col-md-6 text-right">
            <div class="btn-group" style="margin:-3px 0;" data-toggle="tooltip" data-placement="top" data-original-title="Planilla General">                
                <a href="" class="btn btn-primary btn-raised" data-toggle="dropdown"><i class="fa fa-money"></i></a>
                <a href="" data-target="#" class="btn btn-primary btn-raised dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="" data-toggle="modal" data-target="#myModal-wfgral_banco" data-toggle="modal"><i class="fa  fa-file-excel-o"></i>Planilla Enviada al Banco</a></li>
                    <li role="separator" class="divider"></li>

                    <!-- Pagados en banco -->
                    <li><a href="" data-toggle="modal" data-target="#myModal-wfbanco" data-toggle="modal"><i class="fa  fa-file-excel-o"></i>Pagados en Banco</a> </li>
                    <li><a href="" data-toggle="modal" data-target="#myModal-wfnormal" data-toggle="modal">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa  fa-caret-right"></i>Pago Normal</a> </li>
                    <li><a href="" data-toggle="modal" data-target="#myModal-wfprestamos" data-toggle="modal">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa  fa-caret-right"></i>Pago c/amortizacion (Prestamo)</a> </li>
                    <li><a href="" data-toggle="modal" data-target="#myModal-wfrep_fondos" data-toggle="modal">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa  fa-caret-right"></i>Pago c/amortizacion (Rep. de fondos)</a></li>
                    <li><a href="" data-toggle="modal" data-target="#myModal-wfcontabilidad" data-toggle="modal">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa  fa-caret-right"></i>Pago c/amortizacion (Contabilidad)</a></li>
                    <li role="separator" class="divider"></li>
                    
                    <!-- /Pagados en banco -->

                    <!-- Amortizacion total 100% -->
                    <li><a href="" data-toggle="modal" data-target="#myModal-wfamort_total" data-toggle="modal"><i class="fa  fa-file-excel-o"></i>Amortizacion Total (100%)</a> </li>
                    <li><a href="" data-toggle="modal" data-target="#myModal-wfbanco" data-toggle="modal">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa  fa-caret-right"></i>Amortiz. total Prestamo</a></li>
                    <li><a href="" data-toggle="modal" data-target="#myModal-wfbanco" data-toggle="modal">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa  fa-caret-right"></i>Amortiz. total Rep. de Fondos</a></li>
                    <li><a href="" data-toggle="modal" data-target="#myModal-wfbanco" data-toggle="modal">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa  fa-caret-right"></i>Amortiz. total Contabilidad</a> </li>
                    <li role="separator" class="divider"></li>
                    
                    <!-- /Amortizacion total 100%-->

                    <!-- pagos a domiclio -->
                    <li><a href="" data-toggle="modal" data-target="#myModal-wfdomicilio" data-toggle="modal"><i class="fa  fa-file-excel-o"></i>Pagados a Domicilio</a></li>
                    <li role="separator" class="divider"></li>
                    <!-- /pagos a domicilio -->
                    
                    <!-- rezagados -->
                    <li><a href="" data-toggle="modal" data-target="#myModal-wfrezagados" data-toggle="modal"><i class="fa  fa-file-excel-o"></i>Rezagados</a></li>
                    <li role="separator" class="divider"></li>
                    <!-- /rezagados -->

                    <!-- Excluidos por salario -->
                    <li><a href="" data-toggle="modal" data-target="#myModal-wfrezagados" data-toggle="modal"><i class="fa  fa-file-excel-o"></i>Excluidos por salario</a></li>
                    <li role="separator" class="divider"></li>
                    <!-- /Excluidos por salario -->

                    <!-- Suspendidos-->
                    <li><a href="" data-toggle="modal" data-target="#myModal-wfbanco" data-toggle="modal"><i class="fa  fa-file-excel-o"></i>Suspendidos (Sin amortización)</a> </li>
                    <li><a href="" data-toggle="modal" data-target="#myModal-wfbanco" data-toggle="modal">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa  fa-caret-right"></i>Supendidos por prestamo</a></li>
                    <li><a href="" data-toggle="modal" data-target="#myModal-wfbanco" data-toggle="modal">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa  fa-caret-right"></i>Supendidos por Rep. de Fondos</a></li>
                    <li><a href="" data-toggle="modal" data-target="#myModal-wfbanco" data-toggle="modal">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa  fa-caret-right"></i>Suspendidos por Contabilidad</a></li>
                    <li role="separator" class="divider"></li>
                    <!-- /Suspendidos-->

                    <!-- Pagos con poder -->
                    <li><a href="" data-toggle="modal" data-target="#myModal-wfpoder" data-toggle="modal"><i class="fa  fa-file-excel-o"></i>Pago con Poder</a> </li>
                    <li role="separator" class="divider"></li>
                    <!-- /Pagos con poder -->

                  {{--   <li><a href="" data-toggle="modal" data-target="#myModal-wfmuserpol" data-toggle="modal"><i class="fa  fa-file-excel-o"></i>Pagados por Muserpol</a></li>
                    <li role="separator" class="divider"></li>

                    <li><a href="" data-toggle="modal" data-target="#myModal-wfadicionales" data-toggle="modal"><i class="fa  fa-file-excel-o"></i>Trámites Adicionales</a></li> --}}


                </ul>
            </div>

            <div class="btn-group" style="margin:-3px 0;" data-toggle="tooltip" data-placement="top" data-original-title="Exportar APS">                
                <a href="" class="btn btn-primary btn-raised" data-toggle="dropdown"><i class="fa fa-building"></i></a>
                <a href="" data-target="#" class="btn btn-primary btn-raised dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></a>
                <ul class="dropdown-menu">
                     <li><a href="" data-toggle="modal" data-target="#myModal-exportaps" data-toggle="modal"><i class="fa  fa-shield"></i> APS</a> <li>                   
                    <li role="separator" class="divider"></li>
                    <li><a href="{{url('export_aps_availability')}}"  style="padding:3px 5px;"><i class="fa  fa-file-excel-o"></i>ASP Disponibilidad</a></li>        
                   

                </ul>
            </div>
            <div class="btn-group" style="margin:-3px 0;" data-toggle="tooltip" data-placement="top" data-original-title="Exportar Banco">
                <a href="" class="btn btn-primary btn-raised" data-toggle="dropdown"><i class="fa fa-bank"></i></a>
                <a href="" data-target="#" class="btn btn-primary btn-raised dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="" data-toggle="modal" data-target="#myModal-exportbanco" style="padding:3px 5px;"><i class="fa fa-money"></i>Banco</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="{{url('export_planilla_general_bank')}}"  style="padding:3px 5px;"><i class="fa  fa-file-excel-o"></i>Planilla General Banco</a></li>  
                     <li role="separator" class="divider"></li>
                    <li><a href="" data-toggle="modal" data-target="#myModal-exporbydepartment-bank" style="padding:3px 5px;"><i class="fa  fa-file-excel-o"></i>Planilla por Departamento</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="{{url('export_payroll_legal_guardian_bank')}}"  style="padding:3px 5px;"><i class="fa  fa-shield"></i>Planilla de Apoderados</a></li>
                    {{-- <li role="separator" class="divider"></li> 
                    <li><a href="" data-toggle="modal" data-target="#myModal-exportobservados-bank" style="padding:3px 5px;"><i class="fa fa-money"></i>Observados(Reposición,Prestamos,Cont.)</a></li>      --}}          
                    
                   

                </ul>
            </div>
            <div class="btn-group" style="margin:-3px 0;" data-toggle="tooltip" data-placement="top" data-original-title="Exportar Revizados">
                <a href="" class="btn btn-primary btn-raised" data-toggle="dropdown"><i class="fa fa-check"></i></a>
                <a href="" data-target="#" class="btn btn-primary btn-raised dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="{{url('export_planilla_general')}}"  style="padding:3px 5px;"><i class="fa  fa-file-excel-o"></i>Planilla General Revizados</a></li>  
                     <li role="separator" class="divider"></li>
                    <li><a href="" data-toggle="modal" data-target="#myModal-exporbydepartment" style="padding:3px 5px;"><i class="fa  fa-file-excel-o"></i>Planilla por Departamento</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="{{url('export_payroll_legal_guardian')}}"  style="padding:3px 5px;"><i class="fa  fa-shield"></i>Planilla de Apoderados</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="{{url('export_payroll_home')}}"  style="padding:3px 5px;"><i class="fa  fa-home"></i>Planilla de Pagos a Dom.</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="{{url('export_payroll_replenishment_funds')}}"  style="padding:3px 5px;"><i class="fa  fa-navicon"></i>Reposición De Fondos</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="{{url('export_payroll_loan')}}"  style="padding:3px 5px;"><i class="fa  fa-eye"></i>Situacion de mora por Pres.</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="{{url('export_payroll_accounting')}}"  style="padding:3px 5px;"><i class="fa  fa-eye"></i>Cuentas por Cobrar</a></li>

                </ul>
            </div>
            @can('admin')
            <div class="btn-group" style="margin:-3px 0;" data-toggle="tooltip" data-placement="top" data-original-title="Importar">
                <a href="" class="btn btn-primary btn-raised" data-toggle="dropdown"><i class="glyphicon glyphicon-import fa-flip-horizontal"></i></a>
                <a href="" data-target="#" class="btn btn-primary btn-raised dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="" data-toggle="modal" data-target="#myModal-importsenasir" style="padding:3px 5px;"><i class="fa fa-bank"></i>Senasir</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="" data-toggle="modal" data-target="#myModal-importaps" style="padding:3px 5px;"><i class="fa fa-bank"></i>APS</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="" data-toggle="modal" data-target="#myModal-importbanco" style="padding:3px 5px;"><i class="fa fa-money"></i>Banco</a></li>
                </ul>
            </div>
            @endcan
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
                                            {!! Form::label('eco_com_procedure_id', 'Semestre', ['class' => 'col-md-5 control-label']) !!}
                                            <div class="col-md-7">
                                                {!! Form::select('eco_com_procedure_id', $procedures, '', ['class' => 'combobox form-control']) !!}
                                               
                                                <span class="help-block">Seleccione Semestre</span>
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

                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {!! Form::label('eco_com_type', 'Tipo', ['class' => 'col-md-5 control-label']) !!}
                                            <div class="col-md-7">
                                                {!! Form::select('eco_com_type', $eco_com_types_list, null, ['class' => 'form-control combobox']) !!}
                                                <span class="help-block">Selecione el tipo de Proceso</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">

                                              <label class="col-md-4 control-label"> <input type="checkbox" id="sw_modalidad" name="sw_modalidad"> Modalidad </label>


                                        </div>

                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                         <div id="append_modality">
                                             <!-- {!! Form::label('Leco_com_modality_id', 'Modalidad', ['class' => 'col-md-5 control-label']) !!}

                                            <div class="col-md-7">
                                                 <select class="form-control" name="eco_com_modality_id" id="eco_com_modality_id" >
                                                 </select>


                                                <span class="help-block">Selecione la Modalidad</span>
                                            </div> -->

                                         </div>


                                        </div>
                                    </div>
                                </div> <br>
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
                                        <th class="text-left"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Numero de Carnet">Número de Carnet</div></th>
                                        <th class="text-left"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Nombre de Afiliado">Nombre de Beneficiario</div></th>

                                        <th class="text-left"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Regional"> Regional </div></th>
                                        <th class="text-left"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Semestre"> Semestre </div></th>
                                        <th class="text-left"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Ente Gestor"> Ente Gestor </div></th>
                                        <th class="text-left"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Fecha de Emision">Fecha Emisión</div></th>
                                        <th class="text-left"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Estado">Estado</div></th>
                                        <th class="text-left"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Modalidad">Modalidad</div></th>
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
                                                      {!! Form::select('semester',$semester_list,'',['class' => 'combobox form-control', 'required' => 'required']) !!}
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
                                                      {!! Form::select('semester',$semester_list,'',['class' => 'combobox form-control', 'required' => 'required']) !!}
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
                                                    {!! Form::select('semester',$semester_list,'',['class' => 'combobox form-control', 'required' => 'required']) !!}
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
                                                    {!! Form::select('semester',$semester_list,'',['class' => 'combobox form-control', 'required' => 'required']) !!}
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
                                                    {!! Form::select('semester',$semester_list,'',['class' => 'combobox form-control', 'required' => 'required']) !!}
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

    {{-- EXPORT BY DEPARTMENT --}}   
     <div id="myModal-exporbydepartment-bank" class="modal fade bs-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="box-header with-border">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title">Exportar Planilla por Departamento (Banco) </h4>
                      </div>
                      <div class="modal-body">

                          {!! Form::open(['method' => 'POST', 'route' => ['export_by_department_bank'], 'class' => 'form-horizontal', 'files' => true ]) !!}

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
                                                    {!! Form::select('semester',$semester_list,'',['class' => 'combobox form-control', 'required' => 'required']) !!}
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

    <div id="myModal-exportobservados-bank" class="modal fade bs-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="box-header with-border">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title">Exportar Obaservados por Reposición,Contabilidad y Prestamos(Banco) </h4>
                      </div>
                      <div class="modal-body">

                          {!! Form::open(['method' => 'GET', 'route' => ['export_observation_bank'], 'class' => 'form-horizontal', 'files' => true ]) !!}

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
                                                    {!! Form::select('semester',$semester_list,'',['class' => 'combobox form-control', 'required' => 'required']) !!}
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

 <div id="myModal-exporbydepartment" class="modal fade bs-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="box-header with-border">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title">Exportar Planilla por Departamento</h4>
                      </div>
                      <div class="modal-body">

                          {!! Form::open(['method' => 'POST', 'route' => ['export_by_department'], 'class' => 'form-horizontal', 'files' => true ]) !!}

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
                                                    {!! Form::select('semester',$semester_list,'',['class' => 'combobox form-control', 'required' => 'required']) !!}
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

<div id="myModal-wfbanco" class="modal fade bs-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
             <div class="modal-dialog">
                 <div class="modal-content">
                     <div class="box-header with-border">
                         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                         <h4 class="modal-title">Exportar Pagados por Banco</h4>
                     </div>
                     <div class="modal-body">

                         {!! Form::open(['method' => 'POST', 'route' => ['export_payment_bank'], 'class' => 'form-horizontal', 'files' => true ]) !!}

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
                                                   {!! Form::select('semester',$semester_list,'',['class' => 'combobox form-control', 'required' => 'required']) !!}
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

<div id="myModal-wfrezagados" class="modal fade bs-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="box-header with-border">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Exportar Rezagados</h4>
                    </div>
                    <div class="modal-body">

                        {!! Form::open(['method' => 'POST', 'route' => ['export_rezagados'], 'class' => 'form-horizontal', 'files' => true ]) !!}

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
                                                  {!! Form::select('semester',$semester_list,'',['class' => 'combobox form-control', 'required' => 'required']) !!}
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

<div id="myModal-wfdomicilio" class="modal fade bs-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="box-header with-border">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title">Exportar Pagados a Domicilio</h4>
                  </div>
                  <div class="modal-body">

                      {!! Form::open(['method' => 'POST', 'route' => ['export_payment_home'], 'class' => 'form-horizontal', 'files' => true ]) !!}

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
                                                {!! Form::select('semester',$semester_list,'',['class' => 'combobox form-control', 'required' => 'required']) !!}
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


<div id="myModal-wfgral_banco" class="modal fade bs-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="box-header with-border">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title">Exportar Planilla General Banco</h4>
                  </div>
                  <div class="modal-body">

                      {!! Form::open(['method' => 'POST', 'route' => ['export_wf_gral_banco'], 'class' => 'form-horizontal', 'files' => true ]) !!}

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
                                                {!! Form::select('semester',$semester_list,'',['class' => 'combobox form-control', 'required' => 'required']) !!}
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


<div id="myModal-wfadicionales" class="modal fade bs-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="box-header with-border">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title">Exportar Planilla Adicionales</h4>
                  </div>
                  <div class="modal-body">

                      {!! Form::open(['method' => 'POST', 'route' => ['export_wf_adicionales'], 'class' => 'form-horizontal', 'files' => true ]) !!}

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
                                                {!! Form::select('semester',$semester_list,'',['class' => 'combobox form-control', 'required' => 'required']) !!}
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

<div id="myModal-wfpoder" class="modal fade bs-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="box-header with-border">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title">Exportar Pagados con Poder</h4>
                  </div>
                  <div class="modal-body">

                      {!! Form::open(['method' => 'POST', 'route' => ['export_wfpoder'], 'class' => 'form-horizontal', 'files' => true ]) !!}

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
                                                {!! Form::select('semester',$semester_list,'',['class' => 'combobox form-control', 'required' => 'required']) !!}
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

<div id="myModal-wfprestamos" class="modal fade bs-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="box-header with-border">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title">Exportar Amortizados por mora(Prestamos)</h4>
                  </div>
                  <div class="modal-body">

                      {!! Form::open(['method' => 'POST', 'route' => ['export_wfmora_prestamos'], 'class' => 'form-horizontal', 'files' => true ]) !!}

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
                                                {!! Form::select('semester',$semester_list,'',['class' => 'combobox form-control', 'required' => 'required']) !!}
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

<div id="myModal-wfrep_fondos" class="modal fade bs-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="box-header with-border">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title">Exportar Pagados con Amortización(Rep. Fondos)</h4>
                  </div>
                  <div class="modal-body">

                      {!! Form::open(['method' => 'POST', 'route' => ['export_wfrep_fondos'], 'class' => 'form-horizontal', 'files' => true ]) !!}

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
                                                {!! Form::select('semester',$semester_list,'',['class' => 'combobox form-control', 'required' => 'required']) !!}
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

<div id="myModal-wfcontabilidad" class="modal fade bs-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="box-header with-border">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title">Exportar Pagados con Amortización(Contabilidad)</h4>
                  </div>
                  <div class="modal-body">

                      {!! Form::open(['method' => 'POST', 'route' => ['export_wfcontabilidad'], 'class' => 'form-horizontal', 'files' => true ]) !!}

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
                                                {!! Form::select('semester',$semester_list,'',['class' => 'combobox form-control', 'required' => 'required']) !!}
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


<div id="myModal-wfnormal" class="modal fade bs-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="box-header with-border">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title">Exportar Pagados Normal</h4>
                  </div>
                  <div class="modal-body">

                      {!! Form::open(['method' => 'POST', 'route' => ['export_wfnormal'], 'class' => 'form-horizontal', 'files' => true ]) !!}

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
                                                {!! Form::select('semester',$semester_list,'',['class' => 'combobox form-control', 'required' => 'required']) !!}
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

<div id="myModal-wfamort_total" class="modal fade bs-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="box-header with-border">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title">Exportar Amortizados Total 100%</h4>
                  </div>
                  <div class="modal-body">

                      {!! Form::open(['method' => 'POST', 'route' => ['export_wfamort_total'], 'class' => 'form-horizontal', 'files' => true ]) !!}

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
                                                {!! Form::select('semester',$semester_list,'',['class' => 'combobox form-control', 'required' => 'required']) !!}
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



               // var optionModel = function(id,name){
               //      var self = this;
               //      self.id = id;
               //      self.name = name;
               //  }

               //  var selectViewModel = function(){
               //      var self = this;
               //      self.options =ko.observableArray( [
               //          new optionModel(1,"First"),
               //          new optionModel(2,"Second")
               //      ]);
               //      self.addSelect = function(){
               //          self.options.push(new optionModel(15,"joojojjo"));
               //      }
               //      self.selectedOptionId = ko.observable(self.options[0].id);
               //      self.selectedOption = ko.computed(function(){
               //          return ko.utils.arrayFirst(self.options, function(item){
               //              return item.id === self.selectedOptionId();
               //          });
               //      });
               //  }

               //  var select = new selectViewModel();

               //  ko.applyBindings(select);


               // selectViewModel.addSelect();
             //$('#eco_com_modality_id').append('<option value="1">  esto deberia adicionarse1</option>');


            $('select[name="eco_com_type"]').on('change', function() {
                var moduleID = $(this).val();


              //  $('#eco_com_modality_id').append('<option value="1">  esto deberia adicionarse2</option>');

                if(moduleID) {
                    $.ajax({
                        url: '{!! url('get_economic_complement_type') !!}/'+moduleID,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            console.log(data);
                          //  $('select[name="eco_com_modality_id"]').empty();
                            $('#eco_com_modality_id').empty();
                            $.each(data, function(key, value) {
                                console.log(value.id);

                                 //select.addSelect();
                                //viewModel.addSelect();
                           //     alert("Adicionando "+value.id)
                               //  $('#eco_com_modality_id').append('<option value="1">  esto deberia adicionarse</option>');

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
            ajax: {
                url: '{!! route('get_economic_complement') !!}',
                data: function (d) {
                    d.code = $('input[name=code]').val();
                    d.affiliate_identitycard = $('input[name=affiliate_identitycard]').val();
                    d.creation_date = $('input[name=creation_date]').val();
                    d.eco_com_state_id = $('input[name=eco_com_state_id]').val();
                    d.eco_com_modality_id = $('select[name=eco_com_modality_id]').val();
                    d.post = $('input[name=post]').val();
                    // console.log($('input[name=eco_com_procedure_id]').val());
                    d.eco_com_procedure_id = $('input[name=eco_com_procedure_id]').val();
                    d.eco_com_type = $('input[name=eco_com_type]').val();
                    //d.buscador= $('input[name=buscador]').val();
                }
            },
            columns: [
                { data: 'code', sClass: "text-center" },
                { data: 'affiliate_identitycard', bSortable: false },
                { data: 'affiliate_name', bSortable: false },

                { data: 'city',bSortable:false},
                { data: 'procedure', bSortable:false},
                { data: 'pension', bSortable:false},
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


        var oTable1 = $('#averages-table').DataTable({
            "dom": '<"top">t<"bottom"p>',
            processing: true,
            serverSide: true,
            pageLength: 8,
            autoWidth: false,
            ajax: {
                url: '{!! route('get_average') !!}'
            },
            columns: [
                { data: 'shortened' },
                { data: 'rmin', bSortable: false },
                { data: 'rmax', bSortable: false },
                { data: 'average', bSortable: false }
            ]
        });

         $("#sw_modalidad").change(function() {
                console.log('checked_event');
                    if(this.checked) {
                        //Do stuff
                        // alert('checked');
                        $("#append_modality").append('<label class="col-md-5 control-label"> Modalidad </label><div class="col-md-7"><select class="form-control" name="eco_com_modality_id" id="eco_com_modality_id" ></select><span class="help-block">Selecione la Modalidad</span>');


                    }else{
                        // alert('no checked');
                        // $("#append_modality").children().remove();
                         $('#append_modality').empty();
                    }
                });

    </script>
@endpush
