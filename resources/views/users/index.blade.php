@extends('app')

@section('contentheader_title')
  {!! Breadcrumbs::render('users') !!}
@endsection

@section('main-content')
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 text-right">
                    <a href="{!! url('user/create') !!}" style="margin:-6px 1px 12px;" class="btn btn-raised btn-success" data-toggle="tooltip" data-placement="top" data-original-title="Nuevo">&nbsp;<i class="glyphicon glyphicon-plus"></i>&nbsp;</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Lista de Usuarios</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                					<table class="table table-hover" id="users-table">
                                        <thead>
                                            <tr class="success">
                                                <th>Número de Carnet</th>
                                                <th>Nombres y Apellidos</th>
                                                <th>Teléfono</th>
                                                <th>Tipo</th>
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
            { data: 'role', bSortable: false },
            { data: 'status', bSortable: false },
            { data: 'action', orderable: false, searchable: false, bSortable: false, sClass: 'text-center' }
        ]
    });
});
</script>
@endpush
