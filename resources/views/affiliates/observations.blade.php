@extends('app')

@section('contentheader_title')

    <div class="row">
        <div class="col-md-10">
            <ol class="breadcrumb">
              
              <li class="active">Afiliados Observados</li>
            </ol>
        </div>
        <div class="col-md-12 text-right">
                
        
          {{-- <div class="btn-group"  data-toggle="tooltip" data-original-title="Exportar Informe de Observados" style="margin: 0;">
                    <a href="{!! url('export_excel_observations') !!}" class="btn btn-success btn-raised bg-blue" ><i class="glyphicon glyphicon-save glyphicon-lg"></i></a>
          </div>

          <div class="btn-group"  data-toggle="tooltip" data-original-title="Exportar Informe de Observados NO REVISADOS" style="margin: 0;">
                    <a href="{!! url('export_not_review') !!}" class="btn btn-success btn-raised bg-red" ><i class="glyphicon glyphicon-save glyphicon-lg"></i></a>
          </div> --}}

          
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
                                                        </select>
                                                        <span class="help-block">Seleccione Gestión/Semestre</span>
                                                    </div>
                                                    </div>
                                                </div>
                                                
                                    </div>            
                                </div>
                        </form>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-body">    
                        <table class="table table-bordered table-hover" id="observation-table">
                                <thead style="display:table-row-group;">
                                    <tr class="success">
                                  
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
                                <tfoot style="display: table-header-group;">
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
            </div>
        </div>
</div>
@endsection   
@push('scripts')
<script>

var oTable = $('#observation-table').DataTable({
    dom: "<'row'<'col-xs-12'<'col-xs-6'l>>t>"+
            "<'row'<'col-xs-12't>>"+
            "<'row'<'col-xs-12'<'col-xs-6'i><'col-xs-6'p>>>",
    processing: true,
    serverSide: true,
    autoWidth: false,
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
                input.setAttribute('class','inputSearch');
                //input.setAttribute('placeholder','filtro');
                //input.setAttribute('size','10');
                $(input).appendTo($(column.footer()).empty()).on(
                    'keyup change',function(){
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

