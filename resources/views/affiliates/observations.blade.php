@extends('app')

@section('contentheader_title')

    <div class="row">
        <div class="col-md-10">
            <ol class="breadcrumb">
              
              <li class="active">Afiliados Observados</li>
            </ol>
        </div>
        <div class="col-md-12 text-right">
                
        
          <div class="btn-group"  data-toggle="tooltip" data-original-title="Exportar Informe de Observados" style="margin: 0;">
                    <a href="{!! url('export_excel_observations') !!}" class="btn btn-success btn-raised bg-blue" ><i class="glyphicon glyphicon-save glyphicon-lg"></i></a>
          </div>

          <div class="btn-group"  data-toggle="tooltip" data-original-title="Exportar Informe de Observados NO REVISADOS" style="margin: 0;">
                    <a href="{!! url('export_not_review') !!}" class="btn btn-success btn-raised bg-red" ><i class="glyphicon glyphicon-save glyphicon-lg"></i></a>
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
                <div id="tablaDetalle_wrapper">
                    <div id="tablaDetalle_filter"></div>
                </div>    
                <div class="box-body">
                    <div class="row">    
                        <form method="POST" id="search-form" role="form" class="form-horizontal">
                                <div class="col-md-12">
                                    <div class="row">
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                    {!! Form::label('type', 'Tipo de Observación', ['class' => 'col-md-4 control-label']) !!}
                                                    <div class="col-md-6">
                                                       <select class="form-control" id="observation" name="observation">
                                                                <option value="-1">Todo los Tipos</option>
                                                            <?php foreach ($typeObs as $Obs) { ?>
                                                                <option value="<?php echo $Obs->id; ?>"><?php echo $Obs->name?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <span class="help-block">Seleccione tipo de observación</span>
                                                    </div>
                                                    </div>                                                    
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                    {!! Form::label('year','Gestión/Semestre', ['class'=>'col-md-4 control-label']) !!}
                                                    <div class="col-md-6">
                                                        <select class=" form-control" id="year" name="year">
                                                            <option value="-1"> Toda las Gestiones</option>
                                                            @foreach($gestion as $gest)
                                                                <option value="{{$gest['id']}}">{{$gest['year']}}/{{$gest['semester']}}</option>
                                                            @endforeach
                                                            <span class="help-block">Seleccione Gestión-Semestre</span>
                                                        </select>
                                                    </div>
                                                    </div>
                                                </div>
                                                
                                    </div>            
                                </div>
                        </form>
                    </div>

                        <table class="table table-bordered" id="observation-table">
                                <thead>
                                    <tr>
                                  
                                        <th> Nro. Carnet </th>
                                        <th> Matricula </th> 
                                        <th> Grado </th> 
                                        <th> Nombres</th>
                                        <th> Apellidos</th>
                                     
                                        <th> Estado </th>
                                        <th> Observacion </th>
                                        <th> Accion </th>
                                      
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th> 
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tfoot>

                        </table>
                </div> 
            </div>
        </div>
</div>
   
@push('scripts')
<script>

var oTable = $('#observation-table').DataTable({
    
    processing: true,
    serverSide: true,
    ajax: {
            
            url: '{!! route('getdataobservations') !!}',
            data: function(d){
                d.observation =  $('select[name=observation]').val();
                d.year = $('select[name=year]').val();
                d.semester = $('select[name=semester]').val();
            }
    },

    columns: [
            
            { data: 'identity_card', name: 'identity_card' },
            { data: 'registration', name: 'registration' },
            { data: 'shortened', name: 'shortened' },
            { data: 'names', name: 'names' },
            { data: 'surnames', name: 'surnames' },
            { data: 'state', name: 'state',orderable: false, searchable: true},
            { data: 'observation', name: 'observation',searchable: true },
            { data: 'action', name: 'action' , orderable: false, searchable: false }

        ],
        initComplete: function(){
            this.api().columns('0,1,2,3,4,5,6').every(function(){
                var column = this;
                var input = document.createElement('input');
                input.setAttribute('class','form-control');
                input.setAttribute('placeholder','filtro');
                input.setAttribute('size','10');
                $(input).appendTo($(column.footer()).empty()).on(
                    'change',function(){
                        column.search($(this).val()).draw();
                    });
            });

        }
});

$('#search-form').on('change',function(e){
    oTable.draw();
    e.preventDefault();
});



</script>
@endpush

@endsection