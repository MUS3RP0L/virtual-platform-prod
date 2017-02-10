@extends('app')

@section('contentheader_title')
    {!! Breadcrumbs::render('activity') !!}
@endsection

@section('main-content')

<div class="row">
    <div class="col-md-12">
        <div class="box box-warning">
            <div class="box-header with-border">
                    <h3 class="box-title"><span class="glyphicon glyphicon-search"></span> Búsqueda</h3>
            </div>
            <div class="box-body">
                    <div class="row">
                        <form method="POST" id="search-form" role="form" class="form-horizontal">
                            <div class="input-daterange input-group" id="datepicker">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('from', 'Desde', ['class' => 'col-md-8 control-label']) !!}
                                        <div class="col-md-3">
                                            <div class="input-group">
                                                <input type="text" class="input form-control" name="from" />
                                                <div class="input-group-addon" style="background-color:#fff!important;border:0!important;">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('to', 'Hasta', ['class' => 'col-md-2 control-label']) !!}
                                        <div class="col-md-3">
                                            <div class="input-group">
                                                <input type="text" class="input form-control" name="to" />
                                                <div class="input-group-addon" style="background-color:#fff!important;border:0!important;">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="col-md-12">
                                <div class="row text-center">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <button type="reset" class="btn btn-raised btn-warning" data-toggle="tooltip" data-placement="bottom" data-original-title="Limpiar">&nbsp;<span class="glyphicon glyphicon-erase"></span>&nbsp;</button>
                                            &nbsp;&nbsp;<button type="submit" class="btn btn-raised btn-success" data-toggle="tooltip" data-placement="bottom" data-original-title="Buscar">&nbsp;<span class="glyphicon glyphicon-search"></span>&nbsp;</button>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            </div>
                        </form>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered table-hover" id="activity_table">
                                <thead>
                                    <tr class="success">
                                        <th class="text-center"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Fecha">Fecha</div></th>
                                        <th class="text-left"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Actividad">Actividad</div></th>
                                        <th class="text-left"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Tipo">Usuario</div></th>
                                        <th class="text-left"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Usuario">Tipo Actividad</div></th>

                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('.input-daterange').datepicker({
        format: "dd/mm/yyyy",
        language: "es",
        orientation: "bottom right",
        daysOfWeekDisabled: "0,6",
        autoclose: true
    });

    var oTable = $('#activity_table').DataTable({
        "dom": '<"top">t<"bottom"p>',
        processing: true,
        serverSide: true,
        pageLength: 30,
        autoWidth: false,
        order: [0, "asc"],
        ajax: {
            url: '{!! route('get_activity') !!}',
            data: function (d) {
                d.from = $('input[name=from]').val();
                d.to = $('input[name=to]').val();
                d.post = $('input[name=post]').val();
            }
        },
        columns: [
            { data: 'created_at', sClass: "text-center" },
            { data: 'message', bSortable: false },
            { data: 'user_id', bSortable: false },
            { data: 'activity_type_id', bSortable: false },
        ]
    });

    $('#search-form').on('submit', function(e) {
        oTable.draw();
        e.preventDefault();
    });

</script>
@endpush
