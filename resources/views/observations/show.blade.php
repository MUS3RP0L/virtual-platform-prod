@can('observate')
<div class="box box-success box-solid">
    <div class="box-header with-border">
        <div class="row">
            <div class="col-md-10">
                <h3 class="box-title"><span class="glyphicon glyphicon-eye-open"></span> Observaciones</h3>
            </div>
            @if(true)
                <div class="col-md-2 text-right">
                    <div data-toggle="tooltip" data-placement="left" data-original-title="Añadir">
                        <a href="" class="btn btn-sm bg-olive" data-toggle="modal" data-target="#observationModal">
                            <span class="fa fa-lg fa-plus" aria-hidden="true"></span>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            @if(isset($affi_observations))
                <div class="col-md-12">
                    <table class="table table-bordered table-hover table-striped" id="observations-table">
                        <thead>
                            <tr class="success">
                                <th>Fecha</th>
                                <th>Tipo</th>
                                <th>Mensaje</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            @else
                <div class="row text-center">
                    <div data-toggle="modal" data-target="#observationModal">
                        <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Adicionar Observacion">
                        <span class="fa fa-eye fa-5x" style="opacity: .4"></span>
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endcan
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
                    @if(isset($economic_complement))
                        d.affiliate_id={{$economic_complement->affiliate_id}},
                        d.economic_complement_id={{$economic_complement->id}}
                    @else
                        d.affiliate_id={{$affiliate->id}}
                    @endif
                }
            },
            columns: [

                { data: 'date', bSortable: false },
                { data: 'type',name:"type" },
                { data: 'message', bSortable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false, bSortable: false, sClass: 'text-center' }
            ]
        });
</script>
@endpush