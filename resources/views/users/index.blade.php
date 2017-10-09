@extends('app')

@section('contentheader_title')

    <div class="row">
        <div class="col-md-8">
            {!! Breadcrumbs::render('users') !!}
        </div>
        <div class="col-md-4 text-right">
            <a href="{!! url('user/create') !!}" class="btn btn-raised btn-success" data-toggle="tooltip" data-placement="top" data-original-title="Nuevo">&nbsp;
                <i class="glyphicon glyphicon-plus"></i>&nbsp;
            </a>
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
                    <h3 class="panel-title">Lista de Usuarios</h3>
                </div>
                <div class="box-body">
    				<table class="table table-bordered table-hover" id="users-table">
                        <thead style="display:table-row-group;">
                            <tr class="success">
                                <th>Nombre de Usuario</th>
                                <th>Nombres y Apellidos</th>
                                <th>Celular</th>
                                <th>Departamento</th>
                                <th>Unidad</th>
                                <th>Rol</th>
                                <th>Cargo</th>
                                <th>Estado</th>
                                <th class="text-center">Acción</th>
                            </tr>
                        </thead>
                        <tfoot style="display: table-header-group;">
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        
                        </tfoot>
                    </table>
                </div>
			</div>
        </div>
    </div>

@endsection


@push('scripts')

    <script type="text/javascript">

        $(function() {
            $('#users-table').DataTable({
                "dom": '<"top">t<"bottom"p>',
                "order": [[ 0, "desc" ]],
                //processing: true,
                //serverSide: true,
                pageLength: 10,
                autoWidth: false,
                ajax: '{!! route('get_user') !!}',
                columns: [
                    { data: 'username',searchable: true },
                    { data: 'name', searchable: true },
                    { data: 'phone', bSortable: false, searchable: true },
                    { data: 'city', bSortable: false, searchable: true },
                    { data: 'module', bSortable: false, searchable: true },
                    { data: 'role', bSortable: false, searchable: true },
                    { data: 'position', bSortable: false, searchable: true },
                    { data: 'status', bSortable: false, searchable: true },
                    { data: 'action', orderable: false, searchable: true, searchable: false, bSortable: false, sClass: 'text-center' }
                ],
                initComplete: function(){
                    this.api().columns('0,1,2,3,4,5,6,7').every(function(){
                        var column = this;
                        var input = document.createElement('input');
                        input.setAttribute('class','inputSearch');
                        //input.setAttribute('placeholder','filtro');
                        //input.setAttribute('size','5');
                        $(input).appendTo($(column.footer()).empty()).on(
                                    'keyup change',function(){
                                        var val = $(this).val();
                                        column.search(val).draw();
                                    });                                       
                    });
                    }

                });
        });

    </script>

@endpush
