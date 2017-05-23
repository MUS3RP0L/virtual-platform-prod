@extends('app')

@section('contentheader_title')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            {!! Breadcrumbs::render('show_inbox') !!}
        </div>
		<div class="col-md-6 text-right">
			<div class="btn-group"  data-toggle="tooltip" data-placement="top" data-original-title="Actualizar" style="margin: 0;">
					<a href="{!! url('inbox') !!}" class="btn btn-success btn-raised bg-orange" ><i class="fa fa-refresh" aria-hidden="true"></i></a>

			</div>
		</div>
    </div>
</div>
@endsection
@section('main-content')

<div class="col-md-6">
	<div class="box box-danger">
		<div class="box-header with-border">
			<h3 class="box-title">Recibidos</h3>
		</div>
		<div class="box-body" style="width: 95%">
			<table class="table table-bordered table-hover" id="affiliates-table">
                                <thead>
                                    <tr class="success">
                                    <th><input type="checkbox" name="select_all" value="1" id="example-select-all"></th>
                                        <th>Núm. Carnet</th>
                                        <th>Matrícula</th>
                                        <th>Grado</th>
                                        <th>Nombres</th>
                                        <th>Apellido Paterno</th>
                                        <th>Apellido Materno</th>
                                        <th>Estado</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                            </table>
		</div>
	</div>
</div>
<div class="col-md-6">
	<div class="box box-success">
		<div class="box-header with-border">
			<h3 class="box-title">HECHOS</h3>
		</div>
		<div class="box-body" style="width: 95%">
		{!! Form::open(['method' => 'POST', 'route' => ['inbox.store'], 'class' => 'form-horizontal','id'=>'frm-example']) !!}
		<table id="example" class="display" cellspacing="0" width="100%">
   <thead>
      <tr>
         <th></th>
         <th>nua</th>
         <th>type</th>
         <th>gender</th>
         <th>date_entry</th>
         <th>phone_number</th>
      </tr>
   </thead>
   <tfoot>
      <tr>
         <th></th>
         <th>nua</th>
         <th>type</th>
         <th>gender</th>
         <th>date_entry</th>
         <th>phone_number</th>
      </tr>
  </tfoot>
</table>
<p class="form-group">
   <button type="submit" class="btn btn-primary">Submit</button>
</p>

<p>
<b>Selected rows data:</b><br>
<pre id="example-console-rows"></pre>
</p>

<p>
<b>Form data as submitted to the server:</b><br>
<pre id="example-console-form"></pre>
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
   var table = $('#example').DataTable({
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
   $('#frm-example').on('submit', function(e){
      var form = this;
      
      var rows_selected = table.column(0).checkboxes.selected();

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
      // Output form data to a console     
      $('#example-console-rows').text(rows_selected.join(","));
      
      // Output form data to a console     
      $('#example-console-form').text($(form).serialize());
       
      // Remove added elements
      $('input[name="id\[\]"]', form).remove();
       
      // Prevent actual form submission
      //e.preventDefault();
   });
});
</script>
@endpush
@endsection