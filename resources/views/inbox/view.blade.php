@extends('app')
@section('contentheader_title')
    <div class="row">
        <div class="col-md-6">
            {!! Breadcrumbs::render('show_inbox') !!}
        </div>
    		<div class="col-md-6 text-right">
    			
          <div class="btn-group"  data-toggle="tooltip" data-original-title="Exportar Informe Usuario" style="margin: 0;">
                    <a href="{!! url('export_excel_user') !!}" class="btn btn-success btn-raised bg-blue" ><i class="glyphicon glyphicon-save glyphicon-lg"></i></a>
          </div>
          <div class="btn-group"  data-toggle="tooltip" data-original-title="Exportar Informe Todos" style="margin: 0;">
                    <a href="{!! url('export_excel') !!}" class="btn btn-success btn-raised bg-green" ><i class="glyphicon glyphicon-save glyphicon-lg"></i></a>
          </div>
          <!-- <div class="btn-group"  data-toggle="tooltip" data-original-title="Exportar Complementos" style="margin: 0;">
                    <a href="{!! url('export_excel_general') !!}" class="btn btn-success btn-raised bg-red" > <i class="glyphicon glyphicon-import glyphicon-lg"></i> </a>
          </div> -->
          <div class="btn-group"  data-toggle="tooltip" data-original-title="Actualizar" style="margin: 0;">
                    <a href="{!! url('inbox') !!}" class="btn btn-success btn-raised bg-orange" ><i class="fa fa-refresh fa-lg"></i></a>
          </div>
    		</div>
    </div>
@endsection
@section('main-content')
<style>
    input[type="checkbox"]:hover{
        cursor: pointer;
    }
    input[type="checkbox"]{
        transform: scale(1.5);
    }
</style>
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
  		         {{-- <th>id</th> --}}
               <th>Ci</th>
               <th>Nombre</th>
  		         <th>Número</th>
  		         <th>Opciones</th>
  		      </tr>
  		   </thead>
  		</table>
  </div>
	</div>
</div>
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
                    <th>
                        <div class="checkboxx">
                            <label>
                                <input type="checkbox" id="editedCheckboxAll" name="select_all"><span class="checkbox-decorator"><span  class="check"></span></span>
                            </label>
                        </div>
                    </th>
                    <th>ci</th>
                    <th>Nombre</th>
                    <th>Codigo</th>
                </tr>
            </thead>
		</table>
    <button type="submit" class="btn btn-primary btn btn-success btn-raised">Enviar</button>
        <input type="hidden" id="ids" name="ids">
    {!! Form::close() !!}
		</div>
	</div>
</div>
</div>
@push('scripts')
<script>
$(document).ready(function (){
    var oTable = $('#received').DataTable({
        columnDefs : [
        { targets: 0, sortable: false},
        ],
        order: [[ 3, "asc" ]],
        "dom":"<'row'<'col-sm-6'l><'col-sm-6'f>><'row'<'col-sm-12't>><'row'<'col-sm-5'i>><'row'<'bottom'p>>",
        processing: true,
        serverSide: true,
        pageLength: 10,
        autoWidth: false,
        ajax: {
            url: '{!! route('received_data') !!}',
        },
        columns: [
            // { data: 'id'},
            { data: 'ci', bSortable:false},
            { data: 'name', bSortable:false},
            { data: 'code'},
            { data: 'action', name: 'action', orderable: false, searchable: false, bSortable: false, sClass: 'text-center' }
        ]
        });
//     var tableEdited = $('#editedd').DataTable({
//         columnDefs : [
//             { targets: 0, sortable: false},
//         ],
//         order: [[ 3, "asc" ]],
//         "dom":"<'row'<'col-sm-6'l><'col-sm-6'f>><'row'<'col-sm-12't>><'row'<'col-sm-5'i>><'row'<'bottom'p>>",
//         processing: true,
//         serverSide: true,
//         pageLength: 10,
//         autoWidth: false,
//         ajax: {
//             url: '{!! route('edited_data') !!}',
//         },
//         columns: [
//             { data: 'action', name: 'action', sClass: 'text-center'},
//             { data: 'ci', bSortable:false},
//             { data: 'name', bSortable:false},
//             { data: 'code' },
//         ]
//     });
//     // $("#editedCheckboxAll").change(function () {
//     //     $(".checkBoxClass").prop('checked', $(this).prop('checked'))    
//     // });

});
$(document).ready(function (){   
   var table = $('#edited').DataTable({
    "dom":"<'row'<'col-sm-6'l><'col-sm-6'f>><'row'<'col-sm-12't>><'row'<'col-sm-5'i>><'row'<'bottom'p>>",
       ajax: {
            url: '{!! route('edited_data') !!}',
        },
        "lengthMenu": [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
      'columnDefs': [{
         'targets': 0,
         'searchable':false,
         'orderable':false,
         'className': 'dt-body-center',
         'render': function (data, type, full, meta){
            return '<input type="checkbox" name="id[]" value="' 
                + $('<div/>').text(data).html() + '">';
         }
      }],
      'order': [1, 'asc']
   });

   $('#editedCheckboxAll').on('click', function(){
      var rows = table.rows({ 'search': 'applied' }).nodes();
      $('input[type="checkbox"]', rows).prop('checked', this.checked);
   });

   $('#edited tbody').on('change', 'input[type="checkbox"]', function(){
      if(!this.checked){
         var el = $('#editedCheckboxAll').get(0);
         if(el && el.checked && ('indeterminate' in el)){
            el.indeterminate = true;
         }
      }
   });
    
   $('#frm-edited').on('submit', function(e){
      var form = this;
      var ids=[];
      table.$('input[type="checkbox"]').each(function(){
         if(!$.contains(document, this)){
            if(this.checked){
               ids.push(this.value);
            }
         }else{
            if(this.checked){
               ids.push(this.value);
            }
         }
      });
      $('#ids').val(ids);

   });
});
</script>
@endpush
@endsection