@extends('app')
@section('contentheader_title')
    <div class="row">
        <div class="col-md-5">
            {!! Breadcrumbs::render('show_inbox') !!}
        </div>
    		<div class="col-md-7 text-right">
    			
          {{-- <div class="btn-group"  data-toggle="tooltip" data-original-title="Exportar Informe Usuario" style="margin: 0;">
                    <a href="{!! url('export_excel_user') !!}" class="btn btn-success btn-raised bg-blue" ><i class="glyphicon glyphicon-save glyphicon-lg"></i></a>
          </div>
          <div class="btn-group"  data-toggle="tooltip" data-original-title="Exportar Informe Todos" style="margin: 0;">
                    <a href="{!! url('export_excel') !!}" class="btn btn-success btn-raised bg-green" ><i class="glyphicon glyphicon-save glyphicon-lg"></i></a>
          </div> --}}
          <!-- <div class="btn-group"  data-toggle="tooltip" data-original-title="Exportar Complementos" style="margin: 0;">
                    <a href="{!! url('export_excel_general') !!}" class="btn btn-success btn-raised bg-red" > <i class="glyphicon glyphicon-import glyphicon-lg"></i> </a>
          </div> -->
          <div class="btn-group"  data-toggle="tooltip" data-original-title="Actualizar" style="margin: 0;">
                    <a href="{!! url('inbox') !!}" class="btn btn-success btn-raised bg-orange" ><i class="fa fa-refresh fa-lg"></i></a>
          </div>
          @can('eco_com_qualification')
            <div class="btn-group"  data-toggle="tooltip" data-original-title="Imprimir Planilla de los Trámites seleccinados" id="planilla" style="margin: 0;">
            {!! Form::open(['method' => 'POST', 'route' => ['print_edited_data']]) !!}
              <button class="btn btn-primary btn-raised  bg-blue" ><i class="fa fa-print fa-lg"></i>
              </button>
              <input type="hidden" id="ids_print" name="ids_print">
            {!! Form::close() !!} 
            </div>
          @endcan
          @can('eco_com_reception')
            <div class="btn-group"  data-toggle="tooltip" data-original-title="Imprimir Planilla de los Trámites seleccinados (recepionados)" id="planilla" style="margin: 0;">
            {!! Form::open(['method' => 'POST', 'route' => ['print_edited_data']]) !!}
              <button class="btn btn-primary btn-raised  bg-blue" ><i class="fa fa-print fa-lg"></i>
              </button>
              <input type="hidden" id="ids_print" name="ids_print">
            {!! Form::close() !!} 
            </div>
          @endcan
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
    .form-group {
        padding-bottom: 0px;
        margin: 0 0 0 0;
    }
    thead, tfoot {
        display: table-header-group;
    }
    .search-icon {
      font-family: "FontAwesome"
    }
    .padding-lr{
      padding: 0px 0px 0px 5px !important;
    }
.wrapper1{
  text-align:center;
  margin:0 auto 20px auto;
}
.tabs{
  margin-top:5px;
  font-size:18px;
  padding:0px;
  list-style:none;
  background:#fff;
  box-shadow:0px 5px 20px rgba(0,0,0,0.1);
  display:inline-block;
  border-radius:50px;
  position:relative;
}

.tabs a{
  text-decoration:none;
  color: #777;
  text-transform:uppercase;
  padding:10px 20px;
  display:inline-block;
  position:relative;
  z-index:1;
  transition-duration:0.6s;
}

.tabs a.active{
  color:#fff;
}

.tabs a i{
  margin-right:5px;
}

.tabs .selector{
  height:100%;
  display:inline-block;
  position:absolute;
  left:0px;
  top:0px;
  z-index:1;
  border-radius:50px;
  transition-duration:0.6s;
  transition-timing-function: cubic-bezier(0.68, -0.55, 0.265, 1.55);
  background: #37ecba;
  background-image: linear-gradient(to top, #37ecba 0%, #72afd3 100%);
  background: -moz-linear-gradient(45deg, #37ecba 0%, #72afd3 100%);
  background: -webkit-linear-gradient(45deg, #37ecba 0%,#72afd3 100%);
  background: linear-gradient(45deg, #37ecba 0%,#72afd3 100%);
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#37ecba', endColorstr='#72afd3',GradientType=1 );
}
</style>
<div class="row111">
  <div class="wrapper1">
    <nav class="tabs">
      <div class="selector"></div>
      <a href="#home" role="tab" data-toggle="tab" class="active" data-value="received"><i class="fa fa-clock-o"></i><span id="received_quantity"></span> &nbsp;&nbsp;Trámites recibidos</a>
      <a href="#home1" role="tab" data-toggle="tab" data-value="edited">{{Util::getRol()->action}} &nbsp;&nbsp;<span id="edited_quantity"></span> <i class="fa fa-check"></i></a>
    </nav>
  </div>
  {{-- <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Home</a></li>
    <li role="presentation"><a href="#home1" aria-controls="profile" role="tab" data-toggle="tab">Profile</a></li>

  </ul> --}}

  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">
      <div class="col-md-12">
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Trámites recibidos</h3>
            <div class="box-tools pull-right">
              <div data-bind="foreach: listaWorkflowsReceived">
                <span data-toggle="tooltip" data-placement="top" data-bind="attr: {title: nombre}">
                  <a data-bind="attr: {'data-id': id},css:color, style:{fontWeight:'bold'},style:{fontWeight: 'bold'}"  href="#" class="btn-received btn btn-sm btn-raised "><i data-bind="text: quantityStyle, style:{fontWeight: 'bold'}" class="fa fa-file-text-o"></i></a>
                </span>
              </div> 
            </div>
            {{-- @can('eco_com_approval') --}}
            <div class="col-md-1">
              <span data-toggle="modal" data-target="#sendAllModal" >
                <a href="#" class="btn btn-md btn-raised btn-success" data-toggle="tooltip" data-placement="top" title="Derivar todos los tramites" ><i class="fa  fa-files-o"></i> <i class="fa fa-arrow-right"></i> </a>
              </span>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="sendAllModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog " role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><strong>¿Esta seguro de derivar todos los trámites?</strong></h4>
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
            {{-- @endcan --}}

          </div>
          <div class="box-body">
            {{-- {!! Form::select('select-received', $workflow_ids, null, ['id'=>'select-received']); !!} --}}
            <table id="received" class="table table-bordered table-hover">
                <tfoot>
                  <th></th>
                  <th class="padding-lr" style="max-width: 100px;"><input type="text" class="form-control search-icon" style="width:100%" placeholder="&#xf002;"></th>
                  <th class="padding-lr">
                    <div class="form-group">
                      
                    <input type="text" class="form-control search-icon" style="width:100%" placeholder="&#xf002;">
                    </div>
                  </th>
                  <th class="padding-lr" style="max-width: 60px;">
                    
                    <input type="text" class="form-control search-icon" style="width:100%" placeholder="&#xf002;">
                  </th>
                  <th class="padding-lr" style="max-width: 60px;"><input type="text" class="form-control search-icon" style="width:100%" placeholder="&#xf002;"></th>
                  <th class="padding-lr" style="max-width: 60px;"><input type="text" class="form-control search-icon" style="width:100%" placeholder="&#xf002;"></th>
                  <th class="padding-lr" style="max-width: 60px;"><input type="text" class="form-control search-icon" style="width:100%" placeholder="&#xf002;"></th>
                  <th class="padding-lr" style="max-width: 60px;"><input type="text" class="form-control search-icon" style="width:100%" placeholder="&#xf002;"></th>
                  {{-- <th>Opciones</th> --}}
                </tfoot>
              <thead>
                  <tr class="success">
                    <th></th>
                    <th>CI</th>
                    <th>Nombre de beneficiario</th>
                    <th>Reg</th>
                    <th>Tŕamite</th>
                    <th>Tipo</th>
                    <th>Tipo de Prestación</th>
                    <th>Fecha de Recepcion</th>
                    {{-- <th>Opciones</th> --}}
                  </tr>
              </thead>
              
            </table>
        </div>
        </div>
      </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="home1">
      <div class="col-md-12">
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title"> {{Util::getRol()->action}} </h3>
            <div class="box-tools pull-right">
              <div data-bind="foreach: listaWorkflows">

                <span data-toggle="tooltip" data-placement="top" data-bind="attr: {title: nombre}">
                  <a data-bind="attr: {'data-id': id},css:color, click:$parent.wf_click,style:{fontWeight: 'bold'}"  href="#" class="btn-edited btn btn-sm btn-raised"><i data-bind="text: quantityStyle, style:{fontWeight: 'bold'}" class="fa fa-file-text-o"></i></a>
                </span>
              </div> 
            </div>
          </div>
          <div class="box-body">

              {{-- <select data-bind=" options: listaWorkflows ,optionsValue: 'id', optionsText: 'nombre',value: workflowSelected" id='select-edited'></select>  --}}

          {!! Form::open(['method' => 'POST', 'route' => ['inbox.store'], 'class' => 'form-horizontal','id'=>'frm-edited']) !!}
          <table id="edited" style="width:100%" class="table table-bordered table-hover">
            <tfoot>
                    <th></th>
                    <th></th>
                    <th class="padding-lr">
                      <div class="form-group col-md-12">
                        <input type="text" class="form-control search-icon" style="width:100%" placeholder="&#xf002;">
                      </div>
                    </th>
                    <th class="padding-lr">
                      <div class="form-group col-md-12">
                        <input type="text" class="form-control search-icon" style="width:100%" placeholder="&#xf002;">
                      </div>
                    </th>
                    <th class="padding-lr">
                      <div class="form-group col-md-12">
                        <input type="text" class="form-control search-icon" style="width:100%" placeholder="&#xf002;">
                      </div>
                    </th>
                    <th class="padding-lr">
                      <div class="form-group col-md-12">
                        <input type="text" class="form-control search-icon" style="width:100%" placeholder="&#xf002;">
                      </div>
                    </th>
                    <th class="padding-lr">
                      <div class="form-group col-md-12">
                        <input type="text" class="form-control search-icon" style="width:100%" placeholder="&#xf002;">
                      </div>
                    </th>
                    <th class="padding-lr">
                      <div class="form-group col-md-12">
                        <input type="text" class="form-control search-icon" style="width:100%" placeholder="&#xf002;">
                      </div>
                    </th>
                    <th class="padding-lr">
                      <div class="form-group col-md-12">
                        <input type="text" class="form-control search-icon" style="width:100%" placeholder="&#xf002;">
                      </div>
                    </th>
                  </tfoot>
                  <thead>
                      <tr class="success">
                          <th></th>
                          <th>
                              <div class="checkboxx">
                                  <label>
                                      <input type="checkbox" id="editedCheckboxAll" name="select_all"><span class="checkbox-decorator"><span  class="check"></span></span>
                                  </label>
                              </div>
                          </th>
                          <th>CI</th>
                          <th>Nombre de beneficiario</th>
                          <th>Reg</th>
                          <th>Tŕamite</th>
                          <th>Tipo</th>
                          <th>Tipo de Prestación</th>
                          <th>Fecha de Recepcion</th>
                      </tr>
                  </thead>
                  
          </table>
          @if($sw_actual)
          
          
          <div data-bind="visible: secuenciaIsVisible, if: secuenciaIsVisible ">
            
            {{-- boton de retroceso --}}
            <div class="row text-center">

              <div class="col-md-6" data-bind="visible: once">
                <div class="btn-group">
                  <button type="button" class="btn btn-raised btn-warning" data-bind="click: setBack()"  data-target="#back-modal"  data-toggle="modal" ><i class="fa fa-arrow-left" ></i> <strong data-bind="text: secuenciaActualAtras().name"></strong></button>
                  <button type="button" class="btn btn-raised btn-warning dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                
                  <ul class="dropdown-menu" role="menu" data-bind="foreach: listaSecuenciasAtras">
                    <li ><a href="#" data-bind="text: name,click: $root.seleccionaSecuenciaAtras"></a></li>
                  </ul>
                </div>
              </div>

              {{-- boton de envio --}}
              <div class="cod-md-6" data-bind="visible: once">
                <div class="btn-group">
                  <button type="button" class="btn btn-raised btn-success" data-bind="click: setNext()" data-target="#modal-confirm"  data-toggle="modal" > <strong data-bind="text: secuenciaActual.nombre"></strong>  <i class="fa fa-arrow-right" ></i></button>
                  <button type="button" class="btn btn-raised btn-success dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                
                  <ul class="dropdown-menu" role="menu" data-bind="foreach: listaSecuencias">
                    <li ><a href="#" data-bind="text: nombre, click: $root.secuenciaSeleccionada"></a></li>
                  </ul>
                </div>
              </div>

            </div>


            <input type="hidden" name="wf_state_next_id" data-bind="value: secuenciaActual.id">
            <input type="hidden" id="ids" name="ids">
            <input type="hidden" name="type" data-bind="value: type()">

                <div id="modal-confirm" class="modal fade modal-info" tabindex="-1" role="dialog">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">  
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Enviar tramite</h4>
                      </div>
                      <div class="modal-body">
                      
                            Esta seguro de enviar los tramites de <strong> {{ $sw_actual->name }}</strong>  a  <strong data-bind="text: secuenciaActual.nombre"> </strong> ?
                          
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-raised" data-dismiss="modal"> No</button>
                        <button type="submit" class="btn btn-raised" >Si </button>
                      </div>
                    </div><!-- /.modal-content -->
                  </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

                <div id="back-modal" class="modal fade modal-default" tabindex="-1" role="dialog">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><strong class=""> Retroceso de Tramite</strong></h4>
                      </div>
                      <div class="modal-body">
                      
                            Esta seguro de enviar el o los tramites a  <strong data-bind="text: secuenciaActualAtras().name"></strong>
                            <textarea class="form-control" name="nota" placeholder=" Nota"></textarea>
                            <input type="hidden" name="wf_state_id" data-bind="value: secuenciaActualAtras().id">
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-raised btn-default" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-raised btn-danger">Si </button>
                      </div>
                    </div><!-- /.modal-content -->
                  </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

          </div>

          <div data-bind="visible: messageVisible">
              <br>
              <div class="alert alert-primary alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                El <strong data-bind="text: workflowSelectedName"> </strong> No tiene opciones de envio.
              </div>
          </div>
          
          @else
          <br>
          <div class="alert alert-primary alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong> Fin del Tramite!</strong> ultimo punto del flujo del tramite.
          </div>  
          @endif
          {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


@push('scripts')
<script>

$(document).ready(function (){
  $('#planilla').hide();
  $('#received_quantity').text({!! json_encode($wf_received); !!}.reduce((total, c)=>{
    return total + c.quantity;
  },0));
  $('#edited_quantity').text({!! json_encode($wfs); !!}.reduce((total, c)=>{
    return total + c.quantity;
  },0));
  var tabs = $('.tabs');
  var items = $('.tabs').find('a').length;
  var selector = $(".tabs").find(".selector");
  var activeItem = tabs.find('.active');
  var activeWidth = activeItem.innerWidth();
  $(".selector").css({
    "left": activeItem.position.left + "px", 
    "width": activeWidth + "px"
  });

  $(".tabs").on("click","a",function(){
    $('.tabs a').removeClass("active");
    $(this).addClass('active');
    if ($(this).data('value') == 'edited') {
      $('#planilla').fadeIn();
    }else{
      $('#planilla').fadeOut();
    }
    var activeWidth = $(this).innerWidth();
    var itemPos = $(this).position();
    $(".selector").css({
      "left":itemPos.left + "px",
      "width": activeWidth + "px"
    });
  });

    var oTable = $('#received').DataTable({
        
        "dom":"<'row'<'col-sm-6'l><'col-sm-6'>><'row'<'col-sm-12't>><'row'<'col-sm-5'i>><'row'<'bottom'p>>",
        // processing: true,
        // serverSide: true,
        "lengthMenu": [[15, 25, 50,100, -1], [15, 25, 50,100, "Todos"]],
        autoWidth: false,
        ajax: {
            url: '{!! route('received_data') !!}',
        },
        columns: [
            { data: 'workflow_id', name:'workflow_id', "visible": false,"searchable": true},
            { data: 'ci', name:'ci'},
            { data: 'name',name: 'name'},
            { data: 'city',name: 'city'},
            { data: 'code',name:'code',"sType": "code" },
            { data: 'reception_type'},
            { data: 'benefit_type'},
            { data: 'reception_date'},
            // { data: 'action', name: 'action', orderable: false, searchable: false, bSortable: false, sClass: 'text-center' }
        ],
       'order': [3, 'asc'],

        });
    // $('#received tfoot th').each( function (index) {
    //   var title = $(this).text();
  //     <label class="control-label" for="inputDefault">Default input</label>
  // <input type="text" class="form-control" id="inputDefault">
      // var divp=$('<div>').addClass('form-group col-md-12');
      // var label=$('<label>').addClass('control-label').html('Buscar por '+title+" ").attr('for', 'filter_re_'+index);;
      // var i=$('<i>').addClass('fa fa-search');
      // var input=$('<input>').addClass('form-control col-md-12').attr('id', 'filter_re_'+index).attr('placeholder','Buscar por '+title);
      // divp.append(label);
      // label.append(i);
      // divp.append(input);
      // $(this).html(input);
  // });

    oTable.columns().every( function () {
      var that = this;
      $( 'input', this.footer() ).on( 'keyup change', function () {
        if ( that.search() !== this.value ) {
          that.search( this.value ).draw();
        }
      });
    });
    
    $(document).on('click','.btn-received', function(){
       oTable.columns(0).search($(this).data('id')).draw();   
    });

});
var table;
function cli() {
   var ids=[];
    table.$('input[type="checkbox"]').each(function(){
      console.log("hola");
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
 }


$(document).ready(function (){ 
  // $('#edited tfoot th').each( function (index) {
  //   if (index > 0) {
  //     var title = $(this).text();
  //     var divp=$('<div>').addClass('col-md-12').css({
  //       margin: '0px',
  //       padding: '0px',
  //     }).css('padding-right','15px').css('padding-left','15px');
  //     // var label=$('<label>').addClass('control-label').html('Buscar por '+title+" ").attr('for', 'filter_ed_'+index);;
  //     // var i=$('<i>').addClass('fa fa-search');
  //     var input=$('<input>').addClass('form-control').attr('placeholder','&#xf002;').css('width', '100%').css('font-family', 'FontAwesome');
  //     // divp.append(label);
  //     // label.append(i);
  //     divp.append(input);
  //     $(this).html(divp);
  //   }
  // });

  table = $('#edited').DataTable({
    "dom":"<'row'<'col-sm-6'l><'col-sm-6'>><'row'<'col-sm-12't>><'row'<'col-sm-5'i>><'row'<'bottom'p>>",
        "lengthMenu": [[15, 25, 50,100, -1], [15, 25, 50,100, "Todos"]],
      ajax: {
            url: '{!! route('edited_data') !!}',
        },
     "columns": [
        { "data": 'workflow_id', "name":'workflow_id', "visible": false,"searchable": true},
        { "data": "id",
          bSortable: false 
          // "render":function (data, type, row, meta) {
          //   if(type === 'display'){
          //     data = '<input type="checkbox" name="id[]" value="'+data+'">'; 
          //   }
            
          //   return data;
          // } 
        }, 
        { "data": "ci"}, 
        { 
           "data": "name",
           // "render": function(data, type, row, meta){
           //    if(type === 'display'){
           //        data = '<a href="' + data + '">' + data + '</a>';
           //    }
              
           //    return data;
           // }
        },
        { "data":"city" },
        { "data":"code","sType": "code" },
        { "data":"reception_type"},
        { "data":"benefit_type"},
        { "data":"reception_date", render:function(data, type, row){
          var d= new Date(data);
          var options = {  
            weekday: "long", year: "numeric", month: "short",  
            day: "numeric", hour: "2-digit", minute: "2-digit"  
        };  
          return d.toLocaleDateString('es-ES', options);
        }},

     ],
      'order': [4, 'asc'],
  });
   function reg(s){
    var regex = /<(.*?)>/g;
    var str = s;
    var subst = '';
    var result = str.replace(regex, subst);
    return result;
  }
  
  jQuery.fn.dataTableExt.oSort["code-desc"] = function (x, y) {
      function getMins(str){
          return parseInt(reg(str).split('/')[0]);
      };
      return getMins(x) - getMins(y);
  };
  
  jQuery.fn.dataTableExt.oSort["code-asc"] = function (x, y) {
      return jQuery.fn.dataTableExt.oSort["code-desc"](y, x);
  }
  
  jQuery.fn.dataTableExt.oSort["reception-date-desc"] = function (x, y) {
      function getDate(date){
          var d = date +' 00:00:00';
          return new Date(d);
      };
      return ((getDate(x)< getDate(y)) ? -1 : ((getDate(x)> getDate(y)) ? 1 : 0));
  };
  
  jQuery.fn.dataTableExt.oSort["reception-date-asc"] = function (x, y) {
      return jQuery.fn.dataTableExt.oSort["reception-date-desc"](y, x);
  }
  
  table.columns().every( function () {
    var that = this;
    $( 'input', this.footer() ).on( 'keyup change', function () {
      if ( that.search() !== this.value ) {
        that.search( this.value ).draw();
      }
    });
  });
  // $('#select-edited').on('change', function(){
  //      table.columns(0).search(this.value).draw();   
  //   });
  $(document).on('click', '.btn-edited', function(event) {
    table.columns(0).search($(this).data('id')).draw();   
    event.preventDefault();
  });


   // var table = $('#edited').DataTable({
   //  "dom":"<'row'<'col-sm-6'l><'col-sm-6'f>><'row'<'col-sm-12't>><'row'<'col-sm-5'i>><'row'<'bottom'p>>",
   //     ajax: {
   //          url: '{!! route('edited_data') !!}',
   //      },
   //      "lengthMenu": [[15, 25, 50,100, -1], [15, 25, 50,100, "Todos"]],
   //    'columnDefs': [{
   //       'targets': 0,
   //       'searchable':false,
   //       'orderable':false,
   //       'className': 'dt-body-center',
   //       'render': function (data, type, full, meta){

   //          return '<input type="checkbox" name="id[]" value="' 
   //              + $('<div/>').text(data).html() + '">';
            
   //       }
   //    }],
   //    'order': [1, 'asc']
   // });

   $('#editedCheckboxAll').on('click', function(){
      var rows = table.rows({ 'search': 'applied' }).nodes();
      $('input[type="checkbox"]', rows).prop('checked', this.checked);
      cli();
   });

   $('#edited tbody').on('change', 'input[type="checkbox"]', function(){
      if(!this.checked){
         var el = $('#editedCheckboxAll').get(0);
         if(el && el.checked && ('indeterminate' in el)){
            el.indeterminate = true;
         }
      }
   });
   // $("input").on('click', function(e){
   //  console.log('sdasd'); 
   //    var form = this;
   //    var ids=[];
   //    table.$('input[type="checkbox"]').each(function(){
   //       if(!$.contains(document, this)){
   //          if(this.checked){
   //             ids.push(this.value);
   //          }
   //       }else{
   //          if(this.checked){
   //             ids.push(this.value);
   //          }
   //       }
   //    });
   //    $('#ids').val(ids);
   //    $('#ids_print').val(ids);
   // });

    function Workflow(id,nombre, quantity, color)
    {
      var self = this;
      self.id = ko.observable(id);
      self.nombre = ko.observable(nombre);
      self.quantity = ko.observable(quantity);
      self.quantityStyle = ko.computed(function(){
        return  '  '+self.quantity();
      });

      self.color = ko.observable(color);
    }

    function Secuencia(id,nombre,workflow_id)
    {
      var self = this;
      self.id = ko.observable(id);
      self.nombre = ko.observable(nombre);
      self.workflow_id = ko.observable(workflow_id);
    }

   @if($sw_actual)
    
    console.log("trabajando con la secuencia model");
    function SecuenciaViewModel()
    {
        var self = this;


        var workflowsList = {!! json_encode($wfs); !!};
        var workflowsListReceived = {!! json_encode($wf_received); !!};
        var secuencias = {!! json_encode($secuencias); !!} ;

        self.type = ko.observable(1);
        
        self.listaSecuenciasAtras = ko.observableArray({!! json_encode($secuencias_atras); !!});
        // console.log(self.listaSecuenciasAtras());
        self.secuenciaActualAtras = ko.observable(self.listaSecuenciasAtras()[0]);
        self.seleccionaSecuenciaAtras = function(secuencia){
          // console.log(self.secuenciaActualAtras());
            self.secuenciaActualAtras(secuencia);
        };

        self.setBack= function(){
          self.type(1);
        };       
        
        self.setNext= function(){
          self.type(2);
        };       
        
        self.once = ko.observable(false);
       
        self.listaWorkflows = ko.observableArray();
        self.listaWorkflowsReceived = ko.observableArray();
        self.listaSecuencias = ko.observableArray();
        

        for (var i in workflowsList) {
          self.listaWorkflows.push(new Workflow(workflowsList[i].id,workflowsList[i].name,workflowsList[i].quantity,workflowsList[i].color));

        }
        for (var i in workflowsListReceived) {
          self.listaWorkflowsReceived.push(new Workflow(workflowsListReceived[i].id,workflowsListReceived[i].name,workflowsListReceived[i].quantity,workflowsListReceived[i].color));
        }
        console.log(self.listaWorkflows());
     
        self.secuenciaIsVisible = ko.observable(true);
        self.messageVisible =ko.observable(false);
        self.workflowSelected = ko.observable(workflowsList[0].id);
        self.workflowSelectedName = ko.observable(workflowsList[0].name);

        /*haciendo correr algoritmo por primera vez */

          // for(var i in secuencias)
          // {
          //   if(secuencias[i].workflow_id == workflowsList[0].id)
          //   {
          //     self.listaSecuencias.push(new Secuencia(secuencias[i].id,secuencias[i].name,secuencias[i].workflow_id));

          //   }
          // } 
          // console.log('size'+self.listaSecuencias().length)
          // if(self.listaSecuencias().length > 0)
          // {
          //     self.secuenciaActual.nombre(self.listaSecuencias()[0].nombre());
          //     self.secuenciaActual.id(self.listaSecuencias()[0].id());
          //     self.secuenciaActual.workflow_id(self.listaSecuencias()[0].workflow_id());
              
          //     console.log(self.secuenciaActual.workflow_id());
          //     self.secuenciaIsVisible(true);
          //     self.messageVisible(false);
          // }
          // else
          // {
          //     self.secuenciaIsVisible(false);
          //     self.messageVisible(true);
          // }

        /********/

        // self.wf_click = ko.observable();  

        self.wf_click = function(data, event){
          var rows = table.rows({ 'search': 'applied' }).nodes();
          $('input[type="checkbox"]', rows).prop('checked', false);
          $('#editedCheckboxAll').prop('checked', false);

          workflow_id=data.id();
        
          self.listaSecuencias.removeAll();
          for(var i in secuencias)
          {
            if(secuencias[i].workflow_id == workflow_id)
            {
              self.listaSecuencias.push(new Secuencia(secuencias[i].id,secuencias[i].name,secuencias[i].workflow_id));

            }
          } 
          console.log('size'+self.listaSecuencias().length)
          if(self.listaSecuencias().length > 0)
          {
              self.secuenciaActual.nombre(self.listaSecuencias()[0].nombre());
              self.secuenciaActual.id(self.listaSecuencias()[0].id());
              self.secuenciaActual.workflow_id(self.listaSecuencias()[0].workflow_id());
              
              console.log(self.secuenciaActual.workflow_id());
              self.secuenciaIsVisible(true);
              self.messageVisible(false);
          }
          else
          {
              self.secuenciaIsVisible(false);
              self.messageVisible(true);
          }

          console.log(self.messageVisible());
          console.log(workflow_id);

          for (var i in workflowsList) {
              if(workflowsList[i].id==workflow_id )
              {

                self.workflowSelectedName(workflowsList[i].name);
              }  
          }
          self.once(true);

          console.log('--------------');
        };



        self.workflowSelected.subscribe(function(workflow_id) {
        
          self.listaSecuencias.removeAll();
          for(var i in secuencias)
          {
            if(secuencias[i].workflow_id == workflow_id)
            {
              self.listaSecuencias.push(new Secuencia(secuencias[i].id,secuencias[i].name,secuencias[i].workflow_id));

            }
          } 
          console.log('size'+self.listaSecuencias().length)
          if(self.listaSecuencias().length > 0)
          {
              self.secuenciaActual.nombre(self.listaSecuencias()[0].nombre());
              self.secuenciaActual.id(self.listaSecuencias()[0].id());
              self.secuenciaActual.workflow_id(self.listaSecuencias()[0].workflow_id());
              
              console.log(self.secuenciaActual.workflow_id());
              self.secuenciaIsVisible(true);
              self.messageVisible(false);
          }
          else
          {
              self.secuenciaIsVisible(false);
              self.messageVisible(true);
          }

          console.log(self.messageVisible());
          console.log(workflow_id);

          for (var i in workflowsList) {
            
              if(workflowsList[i].id==workflow_id )
              {

                self.workflowSelectedName(workflowsList[i].name);
              }  
            
          }



        }, self); 
        // self.workflowSelected = ko.computed(function());
        console.log('hasta aqui ok XD');

        
        console.log(secuencias);

        for(var i in secuencias)
        {
          console.log(secuencias[i]);
          self.listaSecuencias.push(new Secuencia(secuencias[i].id,secuencias[i].name,secuencias[i].workflow_id));
        }

        // self.listaSecuencias = ko.observableArray([new Secuencia(1,'opcion 1'), new Secuencia(2,'opcion 2')]);

        self.secuenciaActual = new Secuencia(secuencias[0].id,secuencias[0].name,secuencias[0].workflow_id);
    
        console.log(self.secuenciaActual);

        self.secuenciaSeleccionada = function(secuencia)
        {


          self.secuenciaActual.nombre(secuencia.nombre());
          self.secuenciaActual.id(secuencia.id());
          self.secuenciaActual.workflow_id(secuencia.workflow_id());
          
          console.log(secuencia.nombre()+" workflow_id "+secuencia.workflow_id());

        }

       
    }

    ko.applyBindings(new SecuenciaViewModel());
    @else
    console.log("Sin Secuencia");
    function SecuenciaViewModel()
    {
        var self = this;

        var workflowsList = <?php echo json_encode($wfs); ?>;
        var secuencias = <?php echo json_encode($secuencias);?>;
        // console.log(workflowsList);
        // console.log('size '+workflowsList.length);
        self.listaWorkflows = ko.observableArray();
        self.listaSecuencias = ko.observableArray();
        
        for (var i in workflowsList) {
          self.listaWorkflows.push(new Workflow(workflowsList[i].id,workflowsList[i].name));
          console.log(self.listaWorkflows()); 
        }

        self.workflowSelected = ko.observable();

      }

      ko.applyBindings(new SecuenciaViewModel);

    @endif
});



</script>
@endpush
@endsection