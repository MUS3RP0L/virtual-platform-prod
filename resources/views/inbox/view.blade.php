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

          {!! Form::open(['method' => 'POST', 'route' => ['print_edited_data']]) !!}

          <div class="btn-group"  data-toggle="tooltip" data-original-title="Imprimir Revisados" style="margin: 0;">
            <button class="btn btn-primary btn-raised  bg-blue" ><i class="fa fa-print fa-lg"></i>
            </button>
            <input type="hidden" id="ids_print" name="ids_print">
          </div>
          {!! Form::close() !!} 
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
      <div class="col-md-9">
          <h3 class="box-title">Recibidos</h3>
      </div>
      @can('eco_com_approval')
      <div class="col-md-3">
        <span data-toggle="modal" data-target="#sendAllModal" >
          <a href="#" class="btn btn-md btn-raised btn-success" data-toggle="tooltip" data-placement="top" title="Enviar todos los tramites" ><i class="fa  fa-2x fa-arrow-circle-o-right"></i></a>
        </span>
      </div>
      <!-- Modal -->
      <div class="modal fade" id="sendAllModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog " role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel"><strong>¿Esta seguro de enviar Todos los tramites?</strong></h4>
            </div>
            <div class="row text-center">
              {!! Form::open(['method' => 'POST', 'route' => ['inbox_send_all'], 'class' => 'form-horizontal','id'=>'frm-edited']) !!}
                <div class="form-group">
                    <div class="col-md-12">
                        <a href="#" data-dismiss="modal" class="btn btn-raised btn-warning">&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;&nbsp;</a>
                        &nbsp;&nbsp;&nbsp;
                        <button type="submit" class="btn btn-raised btn-success" data-toggle="tooltip" data-placement="bottom" data-original-title="Confirmar">&nbsp;<span class="fa fa-check"></span>&nbsp;</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            <div class="modal-footer">
            </div>
          </div>
        </div>
      </div>
       @endcan

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
                    <th>Regional</th>
                    <th>Codigo</th>
                </tr>
            </thead>
		</table>
    <button type="button"  data-target="#modal-confirm"  data-toggle="modal"  class="btn btn-primary btn btn-success btn-raised">Enviar</button>
    <input type="hidden" id="ids" name="ids">

        <div id="modal-confirm" class="modal fade modal-info" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                 <input type="hidden" name="_token" value="{{ csrf_token() }}">  
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Enviar tramite</h4>
              </div>
              <div class="modal-body">
              
                    Esta seguro de enviar los tramites de <strong> {{ $sw_actual->name }}</strong>  a  <strong> {{ $sw_siguiente->name}}</strong> ?
                  
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-raised" data-dismiss="modal"> No</button>
                <button type="submit" class="btn btn-raised" >Si </button>
              </div>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

    {!! Form::close() !!}
		</div>
	</div>
</div>
</div>


@push('scripts')
<script>
$(document).ready(function (){
    var oTable = $('#received').DataTable({
        
        "dom":"<'row'<'col-sm-6'l><'col-sm-6'f>><'row'<'col-sm-12't>><'row'<'col-sm-5'i>><'row'<'bottom'p>>",
        // processing: true,
        // serverSide: true,
        "lengthMenu": [[15, 25, 50,100, -1], [15, 25, 50,100, "Todos"]],
        autoWidth: false,
        ajax: {
            url: '{!! route('received_data') !!}',
        },
        columns: [
            { data: 'ci', name:'ci'},
            { data: 'name',name: 'name'},
            { data: 'code',name:'code'},
            { data: 'action', name: 'action', orderable: false, searchable: false, bSortable: false, sClass: 'text-center' }
        ],
        initComplete: function () {
            this.api().columns().every(function () {
                var column = this;
                var input = document.createElement('input');
                $(input).appendTo($(column.footer()).empty())
                .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                    column.search(val ? val : '', true, false).draw();
                });
            });
        }
        });


});
$(document).ready(function (){   
   var table = $('#edited').DataTable({
    "dom":"<'row'<'col-sm-6'l><'col-sm-6'f>><'row'<'col-sm-12't>><'row'<'col-sm-5'i>><'row'<'bottom'p>>",
       ajax: {
            url: '{!! route('edited_data') !!}',
        },
        "lengthMenu": [[15, 25, 50,100, -1], [15, 25, 50,100, "Todos"]],
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
   $('#frm-edited').on('change', function(e){
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
      $('#ids_print').val(ids);
   });
});
</script>
@endpush
@endsection