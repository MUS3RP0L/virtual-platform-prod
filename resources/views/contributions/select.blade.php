@extends('app')

@section('contentheader_title')

    <div class="row">
        <div class="col-md-10">
            {!! Breadcrumbs::render('register_contribution', $affiliate) !!}
        </div>
        <div class="col-md-2 text-right">
            <a href="{!! url('affiliate/' . $affiliate->id) !!}" class="btn btn-raised btn-warning" data-toggle="tooltip" data-placement="top" data-original-title="Atrás">
                &nbsp;<span class="glyphicon glyphicon-share-alt"></span>&nbsp;
            </a>
        </div>
    </div>

@endsection

@section('main-content')

    <div class="row">
        <div class="col-md-6">
            @include('affiliates.simple_info')
        </div>
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="box-title"><span class="glyphicon glyphicon-info-sign"></span> Información Adicional</h3>
                        </div>
                    </div>
                </div>
                <div class="panel-body" style="font-size: 14px">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-responsive" style="width:100%;">
                                <tr>
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                Fecha de Ingreso
                                            </div>
                                            <div class="col-md-6">
                                                {!! $affiliate->getShortDateEntry() !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                Total Aporte
                                            </div>
                                            <div class="col-md-6">
                                                Bs {!! $total !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table" style="width:100%;">
                                <tr>
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                Total Fondo Retiro
                                            </div>
                                            <div class="col-md-6">
                                                Bs {!! $total_retirement_fund !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                Total Cuota o Auxilio
                                            </div>
                                            <div class="col-md-6">
                                                Bs {!! $total_mortuary_quota !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title"><span class="glyphicon glyphicon-list-alt"></span> Despliegue de Aportes por Gestión</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered table-hover" id="register_contribution-table">
                                <thead>
                                    <tr class="warning">
                                        <th>Gestión</th>
                                        <th>Enero</th>
                                        <th>Febrero</th>
                                        <th>Marzo</th>
                                        <th>Abril</th>
                                        <th>Mayo</th>
                                        <th>Junio</th>
                                        <th>Julio</th>
                                        <th>Agosto</th>
                                        <th>Septiembre</th>
                                        <th>Octubre</th>
                                        <th>Noviembre</th>
                                        <th>Diciembre</th>
                                        <th>Acción</th>
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
        $(function() {
            $('#register_contribution-table').DataTable({
                "dom": '<"top">t<"bottom"p>',
                "order": [[ 0, "desc" ]],
                processing: true,
                serverSide: true,
                pageLength: 12,
                autoWidth: false,
                ajax: {
                    url: '{!! route('get_select_contribution') !!}',
                    data: function (d) {
                        d.affiliate_id = {{ $affiliate->id }};
                    }
                },
                columns: [
                    { data: 'year'},
                    { data: 'm1', "sClass": "text-center", bSortable: false },
                    { data: 'm2', "sClass": "text-center", bSortable: false },
                    { data: 'm3', "sClass": "text-center", bSortable: false },
                    { data: 'm4', "sClass": "text-center", bSortable: false },
                    { data: 'm5', "sClass": "text-center", bSortable: false },
                    { data: 'm6', "sClass": "text-center", bSortable: false },
                    { data: 'm7', "sClass": "text-center", bSortable: false },
                    { data: 'm8', "sClass": "text-center", bSortable: false },
                    { data: 'm9', "sClass": "text-center", bSortable: false },
                    { data: 'm10', "sClass": "text-center", bSortable: false },
                    { data: 'm11', "sClass": "text-center", bSortable: false },
                    { data: 'm12', "sClass": "text-center", bSortable: false },
                    { data: 'action', "sClass": "text-center", bSortable: false }
                ]
            });
        });
    </script>
@endpush
