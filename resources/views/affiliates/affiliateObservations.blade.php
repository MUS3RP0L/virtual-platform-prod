@extends('app')

@section('contentheader_title')

    <div class="row">
        <div class="col-md-10">
            <ol class="breadcrumb">
              
              <li class="active">Afiliados Observados</li>
            </ol>
        </div>
        <div class="col-md-12 text-right">
                
        
          <div class="btn-group"  data-toggle="tooltip" data-original-title="Afiliados Observados" style="margin: 0;">
                    <a href="{!! url('get_afi_observations') !!}" class="btn btn-success btn-raised bg-blue" ><i class="glyphicon glyphicon-save glyphicon-lg"></i></a>
          </div>
          <div class="btn-group"  data-toggle="tooltip" data-original-title="Comparar Complemento 2018 y 2017" style="margin: 0;">
                    <a href="{!! url('get_eco_com_compare2018_2017') !!}" class="btn btn-success btn-raised bg-blue" ><i class="glyphicon glyphicon-save glyphicon-lg"></i></a>
          </div>

          <div class="btn-group"  data-toggle="tooltip" data-original-title="Verificacion de Componenetes" style="margin: 0;">
                   
                    <a href="" data-toggle="modal" data-target="#myModal-check" style="padding:3px 5px;"><i class="fa fa-bank"></i>VERIFICACION</a>
          </div>

           <div class="btn-group"  data-toggle="tooltip" data-original-title="Diferencia de complementos 2017 y 2018" style="margin: 0;">
                    <a href="{!! url('get_eco_com_diferencia2017_2018') !!}" class="btn btn-success btn-raised bg-blue" ><i class="glyphicon glyphicon-save glyphicon-lg"></i></a>
          </div>
          <div class="btn-group"  data-toggle="tooltip" data-original-title="Tramites sin rentas Excel APS" style="margin: 0;">
                   
                    <a href="" data-toggle="modal" data-target="#myModal-noexiste" style="padding:3px 5px;"><i class="fa fa-bank"></i>RENTAS APS NO EXISTE</a>
          </div>
          
          
        </div>          
    </div>

<div id="myModal-check" class="modal fade bs-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="box-header with-border">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title">Veirifcacion de Componentes</h4>
                      </div>
                      <div class="modal-body">

                          {!! Form::open(['method' => 'POST', 'route' => ['get_check_excel_aps'], 'class' => 'form-horizontal', 'files' => true ]) !!}

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
                                                    {!! Form::text('year', '2018', ['class'=> 'form-control', 'required' => 'required']) !!}
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
                                                    {!! Form::text('semester', 'Primer', ['class'=> 'form-control', 'required' => 'required']) !!}
                                                    
                                                    
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



<div id="myModal-noexiste" class="modal fade bs-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="box-header with-border">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title">Veirifcacion de Componentes</h4>
                      </div>
                      <div class="modal-body">

                          {!! Form::open(['method' => 'POST', 'route' => ['get_eco_com_sin_rentas'], 'class' => 'form-horizontal', 'files' => true ]) !!}

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
                                                    {!! Form::text('year', '2018', ['class'=> 'form-control', 'required' => 'required']) !!}
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
                                                    {!! Form::text('semester', 'Primer', ['class'=> 'form-control', 'required' => 'required']) !!}
                                                    
                                                    
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

@section('main-content')

<style type="text/css">
.inputSearch
{
    background-image: url('img/searching.png');
    background-position: 0px left;
    background-repeat: no-repeat;
    padding:0 0 0 20px;
    border-top: 0px;
    border-right: 0px;
    border-left: 0px;
    width: 100%;
      
}
</style>

<div class="row">
       
</div>
@endsection   
@push('scripts')
<script>

</script>
@endpush

