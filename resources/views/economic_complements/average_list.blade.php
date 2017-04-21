@extends('app')

@section('contentheader_title')
    {!! Breadcrumbs::render('report_generator') !!}
@endsection

@section('main-content')

<div class="row">
    <div class="col-md-12">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                    <h3 class="box-title"><span class="glyphicon glyphicon-search"></span>&nbsp;&nbsp;Generador de Promedios</h3>
            </div>

            <br />
            <div class="box-body">
                    <div class="row">
                        <form method="POST" id="search-form" role="form" class="form-horizontal">

                                <div class="col-md-4 col-md-offset-2">
                                    <div class="form-group">
                                        {!! Form::label('year', 'Gestión', ['class' => 'col-md-4 control-label']) !!}
                                        <div class="col-md-6">
                                            {!! Form::select('year', $year_list, null, ['class' => 'combobox form-control', 'required' ]) !!}
                                            <span class="help-block">Seleccione Gestión</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 ">
                                    <div class="form-group">
                                        {!! Form::label('semester', 'Semestre', ['class' => 'col-md-4 control-label']) !!}
                                        <div class="col-md-6">
                                            {!! Form::select('semester',$semester1_list, null, ['class' => 'combobox form-control', 'required' ]) !!}
                                            <span class="help-block">Seleccione Semestre</span>
                                        </div>
                                    </div>
                                </div>

                            <br>
                            <div class="col-md-12">
                                <div class="row text-center">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <div class="btn-group" data-toggle="tooltip" data-placement="top" data-original-title="Imprimir" style="margin:0px;">
                                                <a  href="{!! url('print_average') !!}" type="submit" class="btn btn-raised btn-success dropdown-toggle enabled" data-toggle="tooltip" data-placement="bottom" >
                                                    &nbsp;<span class="glyphicon glyphicon-print"></span>&nbsp;
                                                </a>
                                            </div>

                                            &nbsp;&nbsp;<button type="submit" class="btn btn-raised btn-success" data-toggle="tooltip" data-placement="bottom" data-original-title="Generar">&nbsp;<span class="glyphicon glyphicon-search"></span>&nbsp;</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                                <div class="col-md-12">
                                    <table class="table table-bordered table-hover" id="average_table">
                                        <thead>
                                            <tr class="success">
                                                <th class="text-center"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Grado">Grado</div></th>
                                                <th class="text-left"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Renta">Renta</div></th>
                                                <th class="text-left"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Renta Menor">Renta Menor</div></th>
                                                <th class="text-left"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Renta Mayor">Renta Mayor</div></th>
                                                <th class="text-left"><div data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Promedio">Promedio</div></th>
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
    function printTrigger() {
        var year1 = $("#year option:selected").val();
        var semester1 = $("#semester option:selected").val();
        var total = year1 + "/" + semester1;

    }

    $(document).ready(function(){
       $('.combobox').combobox();
    });

    var oTable = $('#average_table').DataTable({
        "dom": '<"top">t<"bottom"p>',
        processing: true,
        serverSide: true,
        pageLength: 30,
        autoWidth: false,
        order: [0, "asc"],
        ajax: {
            url: '{!! route('get_average') !!}',
            data: function (d) {
                d.year = $('input[name=year]').val();
                d.semester = $('input[name=semester]').val();
                d.post = $('input[name=post]').val();
            }
        },
        columns: [
            { data: 'degree', sClass: "text-center" },
            { data: 'type', bSortable: false },
            { data: 'rmin', bSortable: false },
            { data: 'rmax', bSortable: false },
            { data: 'average', bSortable: false },
        ]
    });

    $('#search-form').on('submit', function(e) {
        oTable.draw();
        e.preventDefault();
    });

</script>
@endpush
