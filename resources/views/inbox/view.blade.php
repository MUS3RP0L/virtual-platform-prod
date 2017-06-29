@extends('app')

@section('contentheader_title')

    <div class="row">
        <div class="col-md-6">
            {!! Breadcrumbs::render('show_inbox') !!}
        </div>
    		<div class="col-md-6 text-right">
    			<div class="btn-group"  data-toggle="tooltip" data-original-title="Actualizar" style="margin: 0;">
                    <a href="{!! url('inbox') !!}" class="btn btn-success btn-raised bg-orange" ><i class="fa fa-refresh fa-lg"></i></a>
    			</div>
    		</div>
    </div>

@endsection
@section('main-content')
<div class="row">
<div class="col-md-6">
	<div class="box box-success">
		<div class="box-header with-border">
			<h3 class="box-title">Recibidos</h3>
		</div>
    <div class="box-body">
  		<table id="received" class="table table-bordered table-hover">
  		   <thead>
  		      <tr>
  		         <th>id</th>
  		         <th>Número</th>
  		         <th>Opciones</th>
  		      </tr>
  		   </thead>
  		</table>
   
  </div>
	</div>
</div>
{{-- <link rel="stylesheet" href="http://cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
<style>
  table.dataTable.select tbody tr,
  table.dataTable thead th:first-child {
    cursor: pointer;
  }
</style> --}}
<div class="col-md-6">
	<div class="box box-success">
		<div class="box-header with-border">
			<h3 class="box-title">{{Auth::user()->roles->first()->action}}</h3>
		</div>
		<div class="box-body">
		{!! Form::open(['method' => 'POST', 'route' => ['inbox.store'], 'class' => 'form-horizontal','id'=>'frm-edited']) !!}
		<table id="edited" style="width:100%" class="table table-bordered table-hover">
		   <thead>
		      <tr>
		         <th></th>
		         <th>Número</th>
		      </tr>
		   </thead>
		</table>
   <button type="submit" class="btn btn-primary btn btn-success btn-raised">Enviar</button>
{!! Form::close() !!}
		</div>
	</div>
</div>
</div>
@push('scripts')
<script>
$(document).ready(function (){
	var oTable = $('#received').DataTable({
            "dom": '<"top">t<"bottom"p>',
            processing: true,
            serverSide: true,
            pageLength: 10,
            autoWidth: false,
            ajax: {
                url: '{!! route('received_data') !!}',
            },
            columns: [
                { data: 'id'},
                { data: 'code', bSortable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false, bSortable: false, sClass: 'text-center' }
            ]
        });
  var tableEdited = $('#edited').DataTable({
    "dom": '<"top">t<"bottom"p>',
    processing: true,
    serverSide: true,
    pageLength: 10,
    autoWidth: false,
    ajax: {
      url: '{!! route('edited_data') !!}',
    },
    columns: [
      { 
        data: 'action',
        name: 'action',
        orderable: false,
        searchable: false,
        bSortable: false,
        sClass: 'text-center'
      },
      { 
        data: 'code',
        bSortable: false 
      },
    ]
  });
});
</script>
@endpush
@endsection