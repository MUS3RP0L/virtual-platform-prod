@extends('app')

@section('contentheader_title')
    {!! Breadcrumbs::render('report_generator') !!}
@endsection

@section('main-content')

<div class="row">
    <div class="col-md-12">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                    <h3 class="box-title"><span class="glyphicon glyphicon-search"></span>&nbsp;&nbsp;Reporte de complemento económico</h3>
            </div>
            <br />
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12" style="text-align: cesnter">                        
                        {!! Form::open(['method' => 'POST', 'route' => ['report_generator'], 'class' => 'form-inline']) !!}                                
                            <div class="form-group col-md-3">
                                {!! Form::label('type', 'Reporte', ['class' => 'control-label']) !!}                                       
                                {!! Form::select('type', $report_type_list, null, ['class' => 'combobox form-control ', 'required' ]) !!}                                                                                
                                    
                            </div> 
                            <div id = "input1">                        
                                <div class="form-group col-md-3">                                    
                                    {!! Form::label('city', 'Regional', ['class' => 'control-label']) !!}
                                    {!! Form::select('city',$cities_list, null, ['class' => 'combobox form-control', 'required' ]) !!}
                                    <span class="help-block">Seleccione Regional</span>                                   
                                        
                                </div>                            
                                   
                                <div class="form-group col-md-3">                                    
                                    {!! Form::label('year', 'Gestión', ['class' => 'control-label']) !!}
                                    {!! Form::select('year', $year_list, null, ['class' => 'combobox form-control', 'required' ]) !!}
                                    <span class="help-block">Seleccione Gestión</span>
                                        
                                </div>           

                                <div class="form-group col-md-3">                                    
                                    {!! Form::label('semester', 'Semestre', ['class' => 'control-label']) !!}
                                    {!! Form::select('semester', $semester_list, null, ['class' => ' combobox form-control', 'required' ]) !!}
                                    <span class="help-block">Seleccione Semestre</span>                                        
                                        
                                </div>
                            </div>
                            
                            <div class="form-group col-md-9" id="inputs">
                                <div class=" input-daterange input-group" id="datepicker">
                                    <div class="input-group"> 
                                        {!! Form::label('from', 'Desde', ['class' => 'control-label']) !!}                                           
                                                                                                                       
                                        <input type="text" class="input form-control" name="from" />                                                    
                                        <div class="input-group-addon" style="background-color:#fff!important;border:0!important;">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </div>
                                                      
                                    </div>          
                                   
                                        <div class="input-group">
                                            {!! Form::label('to', 'Hasta', ['class' => 'control-label']) !!}                                            
                                            
                                                <input type="text" class="input form-control" name="to" />
                                                <div class="input-group-addon" style="background-color:#fff!important;border:0!important;">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </div>
                                        </div>                                          
                                    
                                </div>
                            </div>
                                
                                

                            <br>
                            <div class="col-md-12">
                                <div class="row text-center">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <button type="reset" class="btn btn-raised btn-warning" data-toggle="tooltip" data-placement="bottom" data-original-title="Limpiar">&nbsp;<span class="glyphicon glyphicon-erase"></span>&nbsp;</button>
                                            &nbsp;&nbsp;<button type="submit" class="btn btn-raised btn-success" data-toggle="tooltip" data-placement="bottom" data-original-title="Generar">&nbsp;<span class="glyphicon glyphicon-search"></span>&nbsp;</button>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </form>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function(){
       $('.combobox').combobox();
     $('.input-daterange').datepicker({

        format: "dd/mm/yyyy",
        language: "es",
        orientation: "bottom right",
        daysOfWeekDisabled: "0,6",
        autoclose: true
    });

    $('#inputs').hide();
    $('#type').on('change',function (event) {
            event.preventDefault();
            var valor = $(this).val();
            console.log(valor);
            if(valor == 1){                
                
                $('#input1').hide();
                $('#inputs').show();
            }
            else{
                $('#inputs').hide();
                $('#input1').show();
            }            
        
     });

    });
</script>
@endpush
