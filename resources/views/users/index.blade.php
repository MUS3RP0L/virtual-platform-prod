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
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="panel-title">Lista de Usuarios</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                					<table class="table table-hover" id="users-table">
                                        <thead>
                                            <tr class="warning">
                                                <th>Número de Carnet</th>
                                                <th>Nombres y Apellidos</th>
                                                <th>Teléfono</th>
                                                <th>Unidad</th>
                                                <th>Cargo</th>
                                                <th>Estado</th>
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
        </div>
    </div>


@endsection


@push('scripts')
<script>
$(function() {
    $('#users-table').DataTable({
        "dom": '<"top">t<"bottom"p>',
        processing: true,
        serverSide: true,
        pageLength: 10,
        ajax: '{!! route('get_user') !!}',

        columns: [
            { data: 'username' },
            { data: 'name', bSortable: false },
            { data: 'phone', bSortable: false },
            { data: 'module', bSortable: false },
            { data: 'role', bSortable: false },
            { data: 'status', bSortable: false },
            { data: 'action', orderable: false, searchable: false, bSortable: false, sClass: 'text-center' }
        ]
    });
});
</script>
@endpush
