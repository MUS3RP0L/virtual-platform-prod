<div class="box box-warning box-solid">
    <div class="box-header with-border">
        <h3 class="box-title"><span class="fa fa-eye" ></span> Observaciones</h3>
        <div class="box-tools pull-right">
            @can("eco_com_review_reception_calification_contabilidad")
                <div data-toggle="tooltip" data-placement="right" data-original-title="Ver Observaciones Eliminadas">
                    <div class="togglebutton">
                        <label>
                            <input type="checkbox" id="seeObservations"> 
                        </label>
                    </div>
                </div>
            @endcan
        </div>
    </div>
    <div class="box-body">
        <div class="box-group" id="accordion">
            <div class="panel box box-danger">
                    <div class="box-header with-border">
                        <h4 class="box-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#affiliate_observations">
                            Afiliado <span class="badge ">{{ $observations_quantity }}</span>
                        </a>
                        </h4>
                        <div class="box-tools pull-right">
                                <div class="box-tools pull-right">
                                    @can("eco_com_review_reception_calification_contabilidad")
                                        <div data-toggle="tooltip" data-placement="left" data-original-title="Añadir">
                                                <a href="" class="btn btn-sm bg-yellow btn-raised" data-toggle="modal" data-target="#observationEditModal" data-observation-id="" data-observation-type-id="" data-observation-message="" >
                                                    <span class="fa fa-lg fa-plus" aria-hidden="true"></span>
                                                </a>
                                        </div>
                                    @endcan
                                </div>
                        </div>
                    </div>
                    <div id="affiliate_observations" class="panel-collapse collapse in">
                        <div class="box-body">
                        <div class="row">
                                <div class="col-md-12">
                                    
                                    <table class="table table-bordered table-hover table-striped" id="observations-table">
                                        <thead>
                                            <tr class="success">
                                                <th class="col-md-2">Fecha </th>
                                                <th class="col-md-3">Tipo </th>
                                                <th class="col-md-5">Descripción </th>
                                                <th class="col-md-1">Opciones</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>

            <div class="panel box panel-primary">
                <div class="box-header with-border">
                  <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#note_observations">
                          Notas  <span class="badge">{{ $notes_quantity }}</span>
                    </a>
                   
                  </h4>
                  <div class="box-tools pull-right">
                            <div data-toggle="tooltip" data-placement="left" data-original-title="Añadir">
                                  <a href="" class="btn btn-sm btn-info btn-raised" data-toggle=
                                  "modal" data-target="#observationEditModal" data-observation-id="" data-observation-type-id="11" data-observation-message="" data-observation-enabled="" data-notes="1">
                                      <span class="fa fa-lg fa-plus" aria-hidden="true"></span>
                                  </a>
                            </div>
                  </div>
                </div>
                  <div id="note_observations" class="panel-collapse collapse">
                  <div class="box-body">
                          <div class="row">
                                 
                              <div class="col-md-12">
                                  <table class="table table-bordered table-hover table-striped" id="notes-table">
                                      <thead>
                                          <tr class="success">
                                              <th class="col-md-2">Fecha </th>
                                              <th class="col-md-9">Descripción </th>
                                              <th class="col-md-1">Opciones</th>
                                          </tr>
                                      </thead>
                                  </table>
                              </div>
                          
                          </div>
                  </div>
                </div>
            </div>

            <div class="panel box panel-primary observer">
                <div class="box-header with-border">
                    <h4 class="box-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#observations_eliminated">
                        Eliminados <span class="badge">{{ $observations_eliminated }}</span>
                    </a>
                    
                    </h4>
                    
                </div>
                    <div id="observations_eliminated" class="panel-collapse collapse">
                    <div class="box-body">
                        <div class="row">
                                
                            <div class="col-md-12">
                                <table class="table table-bordered table-hover table-striped" id="eliminated-table">
                                    <thead>
                                        <tr class="success">
                                            <th class="col-md-2">Fecha </th>
                                            <th class="col-md-3">Tipo </th>
                                            <th class="col-md-9">Descripción </th>
                                            {{-- <th class="col-md-1">Opciones</th> --}}
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- <div class="row">
            @if(isset($affi_observations))
                <div class="col-md-12">
                    <table class="table table-bordered table-hover table-striped" id="observations-table">
                        <thead>
                            <tr class="success">
                                <th>Fecha de la Observación Realizada</th>
                                <th>Tipo de Observación</th>
                                <th>Descripción de la Observación</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            @else
                <div class="row text-center">
                    <div data-toggle="modal" data-target="#">
                        <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="No hay observaciones">
                        <span class="fa fa-eye fa-5x" style="opacity: .4"></span>
                        </button>
                    </div>
                </div>
            @endif
        </div> --}}
    </div>
</div>

 <!-- Edit Observation Modal -->
 <div class="modal fade" id="observationEditModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open(['action' => 'Observation\AffiliateObservationController@store']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="editModalTitle">Editando Observación</h4>
            </div>
            <div class="modal-body">
               <h4> <span id="observation_name" class="label label-danger"></span> </h4>
                {!! Form::label('observation_type_id_edit', 'Tipo', ['class'=>'selItem']) !!}
                
                <div class="form-group">
                    <select class="form-control  selItem" name="observation_type_id" id='observation_type_id_edit'  >
                        <option value=''> </option>
                        @foreach($observations_types as $observation_type)
                            <option value='{{ $observation_type->id }}'> {{ $observation_type->name }} </option>
                        @endforeach
                    </select>
                </div>
                {!! Form::label('message', 'Mensaje:', []) !!}
                <textarea name="message" id="message_edit" cols="50" rows="10" required="required" class="form-control"></textarea>

                <div class="form-group">
                    <div class="togglebutton isNote">
                        <label>
                            <input type="checkbox" name="is_note" id="is_note"> <span id="check_title"> </span>
                        </label>
                    </div>
                </div>

                {!! Form::hidden('affiliate_id', $affiliate->id,['id'=>'affiliate_id_edit']) !!}
                <input type="hidden" name="observation_id" id="observation_id_edit" >
            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <a href="#" data-dismiss="modal" class="btn btn-raised btn-warning"><span class="fa fa-close"></span></a>
                    <button type="submit" class="btn btn-raised btn-success" data-toggle="tooltip" data-placement="bottom" data-original-title="Guardar">&nbsp;&nbsp;&nbsp;<span class="fa fa-save"></span>&nbsp;&nbsp;&nbsp;</button>
                </div>
            </div>
                {!! Form::close() !!}
        </div>
    </div>
</div>
<!-- Delete Observation Modal -->
<div class="modal fade" id="observationDeleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open(['method' => 'POST', 'route' => ['observation_delete'], 'class' => 'form-horizontal']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">¿Esta seguro de Eliminar la observación?</h4>
            </div>
            <div class="modal-body">
                {!! Form::token() !!}
                {!! Form::hidden('affiliate_id', $affiliate->id,['id'=>'affiliate_id_delete']) !!}
                {!! Form::hidden('observation_id','',['id'=>'observation_id_delete']) !!}
                <div class="text-center">
                    <a href="#" data-dismiss="modal" class="btn btn-raised btn-warning">&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;&nbsp;</a>
                    &nbsp;&nbsp;&nbsp;
                    <button type="submit" class="btn btn-raised btn-success" data-toggle="tooltip" data-placement="bottom" data-original-title="Guardar">&nbsp;<span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;</button>
                </div>
            </div>
                {!! Form::close() !!}
        </div>
    </div>
</div>

@push('scripts')
<script>
    var observationsTable = $('#observations-table').DataTable({
            "dom": '<"top">t<"bottom"p>',
            processing: true,
            serverSide: true,
            pageLength: 8,
            autoWidth: false,
            ajax: {
                url: '{!! route('get_observations') !!}',
                data: function (d) {
                    d.type = 'A';
                    d.affiliate_id={{$affiliate->id}}
                }
            },
            columns: [

                { data: 'created_at', bSortable: false },
                { data: 'type',name:"type" },
                { data: 'message', bSortable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false, bSortable: false, sClass: 'text-center' }
            ]
        });
            $('#notes-table').DataTable({
            "dom": '<"top">t<"bottom"p>',
            processing: true,
            serverSide: true,
            pageLength: 8,
            autoWidth: false,
            ajax: {
                url: '{!! route('get_observations') !!}',
                data: function (d) {
                    d.type = 'N';
                    d.affiliate_id={{$affiliate->id}};
                }
            },
            columns: [

                { data: 'created_at', bSortable: false },
                // { data: 'type',name:"type" },
                { data: 'message', bSortable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false, bSortable: false, sClass: 'text-center' }
            ]
        });
            
        $('#eliminated-table').DataTable({
            "dom": '<"top">t<"bottom"p>',
            processing: true,
            serverSide: true,
            pageLength: 8,
            autoWidth: false,
            ajax: {
                url: '{!! route('get_observations_eliminated') !!}',
                data: function (d) {
                 
                    d.affiliate_id={{$affiliate->id}}
                }
            },
            columns: [

                { data: 'deleted_at', bSortable: false },
                { data: 'type',name:"type" },
                { data: 'message', bSortable: false },
                // { data: 'action', name: 'action', orderable: false, searchable: false, bSortable: false, sClass: 'text-center' }
            ]
        });

    var see = false;
    $('.observer').hide();
    $('#seeObservations').change(function(){
        
            see = !see;
            if(see)
            {
                $('.observer').show();
            }else{
                $('.observer').hide();
            }
        // console.log(see);
    });

    $(document).ready(function() {
        // edit observations
        $(document).on('click', '.editObservation', function(event) {
            $.get('/observation/'+$(this).data('id'), function(data) {
                $('#observation_type_id_edit').val(data.observation_type_id);
                $('#message_edit').val(data.message);
                $('#message_edit').val(data.message);
                $('#affiliate_id').val(data.affiliate_id);
                $('#is_enabled').attr('checked', data.is_enabled);
                $('#observation_id_edit').val(data.id);
            });
            event.preventDefault();
        });
        // delete observations
        $(document).on('click', '.deleteObservation', function(event) {
            $.get('/observation/'+$(this).data('id'), function(data) {
                $('#observation_id_delete').val(data.id);
            });
            event.preventDefault();
        });
        


    });

    //funciones modal de observaciones al affiliado
    $('#observationEditModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var observation_type_id = button.data('observation-type-id') // Extract info from data-* attributes
        var observation_id = button.data('observation-id')
        var observation_message = button.data('observation-message')
        var observation_name = button.data('observation-name')
        var notes = button.data('notes')
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        
        console.log(observation_message);
        modal.find('.modal-body #is_enabled').change(function(){
            if($(this).is(":checked")){
                console.log('check');
                $('#check_title').text('Subsanado'); 
            }else
            {
                $('#check_title').text('Vigente'); 
                console.log('no check');
            }
        });
      
        modal.find('.modal-body #observation_type_id_edit').val(observation_type_id)
        modal.find('.modal-body #observation_id_edit').val(observation_id)
        modal.find('.modal-body #message_edit').val(observation_message)
       
        
        if(notes)
        {
            modal.find('.modal-body #observation_name').hide()
            if(!observation_id)
            {
                modal.find('.modal-content #editModalTitle').text('Nueva Nota')
            }else{
                modal.find('.modal-content #editModalTitle').text('Editar Nota')
            }
            
            // modal.find('.modal-body #observation_type_id_edit').hide()
            modal.find('.modal-body .note').hide()
            modal.find('.modal-body #observation_type_label').hide()
            modal.find('.modal-body #is_note').prop('checked',true)
            modal.find('.modal-body #observation_type_id_edit').prop('required',false);
            modal.find('.modal-body .selItem').hide() 
            
        }else{

            if(!observation_id)
            {
                modal.find('.modal-content #editModalTitle').text('Nueva Observación')
                modal.find('.modal-body .selItem').show() 
                modal.find('.modal-body #observation_type_id_edit').prop('required',true);
                modal.find('.modal-body #observation_name').hide()
            }else{
                modal.find('.modal-content #editModalTitle').text('Editar Observación')
                modal.find('.modal-body .selItem').hide() 
                modal.find('.modal-body #observation_type_id_edit').prop('required',false);
                modal.find('.modal-body #observation_name').text(observation_name)
                modal.find('.modal-body #observation_name').show()
                
            }

            // modal.find('.modal-body #observation_type_id_edit').show()
            modal.find('.modal-body .note').show()
            modal.find('.modal-body #observation_type_label').show()
            modal.find('.modal-body #is_note').prop('checked',false)
            
        }
        
        modal.find('.modal-body .isNote').hide()   
              
    });

</script>
@endpush
