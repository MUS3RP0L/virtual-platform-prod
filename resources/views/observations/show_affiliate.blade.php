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
                                                <a href="" class="btn btn-sm bg-yellow btn-raised" data-toggle="modal" data-target="#observationModal">
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
            {!! Form::open(['url' => 'observation/update']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Editando Observación</h4>
            </div>
            <div class="modal-body">
                {!! Form::token() !!}
                {!! Form::label('observation_type_id_edit', 'Tipo', ['']) !!}
                <div class="form-group">
                    {!! Form::select('observation_type_id', $observations_types, '', ['class' => 'col-md-2 form-control','required' => 'required', 'id'=>'observation_type_id_edit']) !!}
                </div>
                {!! Form::label('message', 'Mensaje:', []) !!}
                <textarea name="message" id="message_edit" cols="50" rows="10" required="required" class="form-control"></textarea>
               
                {!! Form::hidden('affiliate_id', $affiliate->id,['id'=>'affiliate_id_edit']) !!}
                {!! Form::hidden('observation_id','',['id'=>'observation_id_edit']) !!}
            </div>
            <div class="modal-footer">
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
</script>
@endpush
