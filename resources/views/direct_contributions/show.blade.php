@extends('layout')

@section('content')
<div class="container-fluid">
    {!! Breadcrumbs::render('show_direct_contribution', $affiliate) !!}
    <div class="row">
        <div class="col-md-12 text-right">
            <a href="{!! url('direct_contribution') !!}" style="margin:-6px 1px 12px;" class="btn btn-raised btn-warning" data-toggle="tooltip" data-placement="top" data-original-title="Atrás">
                &nbsp;&nbsp;<span class="glyphicon glyphicon-share-alt"></span>&nbsp;&nbsp;
            </a>
        </div>
    </div>

    <div class="row">

        @include('affiliates.simple_info')

        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="panel-title"><span class="glyphicon glyphicon-list-alt"></span> Información de Aporte</h3>
                        </div>
                    </div>
                </div>
                <div class="panel-body" style="font-size: 14px">
                    <div class="row">
                        <div class="col-md-6">

                            <table class="table table-responsive" style="width:100%;">
                                <tr>
                                    <td style="border-top:1px solid #d4e4cd;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                Gestión
                                            </div>
                                            <div class="col-md-6">
                                                 {!! $year !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-top:1px solid #d4e4cd;border-bottom:1px solid #d4e4cd;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                Tipo Aporte
                                            </div>
                                            <div class="col-md-6">
                                                {!! $type !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table" style="width:100%;">
                                <tr>
                                    <td style="border-top:1px solid #d4e4cd;border-bottom:1px solid #d4e4cd;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                Total
                                            </div>
                                            <div class="col-md-6">

                                                @if($direct_contribution)
                                                    {!! $direct_contribution->total !!}
                                                @else
                                                    <span data-bind="text: sum_total()">
                                                @endif

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
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Despliegue</h3>
                </div>
                <div class="panel-body">
                    <iframe src="{!! url('print_direct_contribution/' . $direct_contribution->id) !!}" width="99%" height="1200"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>

</script>
@endpush
