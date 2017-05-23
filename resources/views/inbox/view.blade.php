@extends('app')

@section('contentheader_title')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            {!! Breadcrumbs::render('show_inbox') !!}
        </div>
		<div class="col-md-6 text-right">
			<div class="btn-group"  data-toggle="tooltip" data-placement="top" data-original-title="Actualizar" style="margin: 0;">
			</div>
		</div>
    </div>
</div>
@endsection
@section('main-content')
<div class="col-md-6">
	<div class="box box-success">
		<div class="box-header with-border">
			<h3 class="box-title">Recibidos</h3>
		</div>
		<table id="received" class="table table-bordered table-hover">
		   <thead>
		      <tr>
		         <th>id</th>
		         <th>code</th>
		         <th>Opciones</th>
		      </tr>
		   </thead>
		</table>
	</div>
</div>

<div class="col-md-6">
	<div class="box box-success">
		<div class="box-header with-border">
			<h3 class="box-title">HECHOS</h3>
		</div>
		<div class="box-body" style="width: 95%">
		{!! Form::open(['method' => 'POST', 'route' => ['inbox.store'], 'class' => 'form-horizontal','id'=>'frm-edited']) !!}
		<table id="edited" class="display" cellspacing="0" width="100%">
		   <thead>
		      <tr>
		         <th></th>
		         <th>code</th>
		      </tr>
		   </thead>
		   <tfoot>
		      <tr>
		         <th></th>
		         <th>code</th> 
		      </tr>
		  </tfoot>
		</table>
<p class="form-group">
   <button type="submit" class="btn btn-primary">Submit</button>
</p>
{!! Form::close() !!}
		</div>
	</div>
</div>

@push('scripts')
<link type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/se-1.2.0/datatables.min.css" rel="stylesheet" />
<link type="text/css" href="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.6/css/dataTables.checkboxes.css" rel="stylesheet" />
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/se-1.2.0/datatables.min.js"></script>
<script type="text/javascript" src="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.6/js/dataTables.checkboxes.min.js"></script>
<script>
$(document).ready(function (){
	var oTable = $('#received').DataTable({
            "dom": '<"top">t<"bottom"p>',
            processing: true,
            serverSide: true,
            pageLength: 8,
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


   /*var tableR = $('#received').DataTable({
      'ajax': '/received_data',
      'columnDefs': [
         {
            'targets': 0,
            'checkboxes': {
               'selectRow': true
            }
         }
      ],
      'select': {
         'style': 'multi'
      },
      'order': [[1, 'asc']]
   });


   // Handle form submission event 
   $('#frm-received').on('submit', function(e){
      var form = this;
      
      var rows_selected = tableR.column(0).checkboxes.selected();

      // Iterate over all selected checkboxes
      $.each(rows_selected, function(index, rowId){
         // Create a hidden element 
         $(form).append(
             $('<input>')
                .attr('type', 'text')
                .attr('name', 'edited[]')
                .val(rowId)
         );
      });
   });*/
   var tableE = $('#edited').DataTable({
      'ajax': '/edited_data',
      'columnDefs': [
         {
            'targets': 0,
            'checkboxes': {
               'selectRow': true
            }
         }
      ],
      'select': {
         'style': 'multi'
      },
      'order': [[1, 'asc']]
   });


   // Handle form submission event 
   $('#frm-edited').on('submit', function(e){
      var form = this;
      var rows_selected = tableE.column(0).checkboxes.selected();
      $.each(rows_selected, function(index, rowId){
         $(form).append(
             $('<input>')
                .attr('type', 'text')
                .attr('name', 'edited[]')
                .val(rowId)
         );
      });
   });
});
</script>
@endpush
@endsection