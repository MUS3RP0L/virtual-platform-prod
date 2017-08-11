@extends('app')

@section('contentheader_title')

    <div class="row">
        <div class="col-md-10">
            <ol class="breadcrumb">
              
              <li class="active">Afiliados Observados</li>
            </ol>
        </div>
        <div class="col-md-2 text-right">
            <div data-toggle="tooltip" data-placement="top" data-original-title="Nuevo">
                <a href="" class="btn btn bg-olive" data-toggle="modal" data-target="#myModal-personal">
                    <span class="fa fa-lg fa-plus" aria-hidden="true"></span>
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
                  
                   
                        <table class="table table-bordered" id="observation-table">
                                <thead>
                                    <tr>
                                  
                                        <th> Nro. Carnet </th>
                                        <th> Matricula </th>
                                        <th> Grado </th>
                                                                             <th> Accion</th>
                                      
                                    </tr>
                                </thead>
                        </table>
                    
                </div>  

              

            </div>
        </div>
</div>
   


@push('scripts')
<script>
$(function() {
    $('#observation-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('getdataobservations') !!}',
        columns: [
            
            { data: 'identity_card', name: 'identity_card' },
            { data: 'registration', name: 'registration' },
            { data: 'degrees', name: 'degrees' },
            { data: 'action', name: 'action' , orderable: false, searchable: false }

        ]
    });
});
</script>
@endpush

@endsection