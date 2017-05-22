@extends('app')
@section('contentheader_title')
    <div class="row">
        <div class="col-md-8">
            {!! Breadcrumbs::render('eco_com_procedure') !!}
        </div>
    	<div class="col-md-4 text-right">
            <a href="{!! url('economic_complement_procedure/create') !!}" class="btn btn-raised btn-success" data-toggle="tooltip" data-placement="top" data-original-title="Nuevo">&nbsp;
                <i class="glyphicon glyphicon-pencil"></i>&nbsp;
            </a>
        </div>
    </div>
@endsection
@section('main-content')
<div class="row">
	
	
<div class="col-md-12">
	<div class="box box-danger">
		<div class="box-header with-border">
			<h3 class="box-title">Rango de fechas</h3>
		</div>
		<div class="box-body" style="width: 95%">
			<table id="procedure" class="table table-hover table-condensed">
			<thead>
			<tr>
				<th>Año</th>
				<th>Semestre</th>
				<th>Inicio Normal</th>
				<th>Fin Normal</th>
				<th>Inicio Rezagados</th>
				<th>Fin Rezagados</th>
				<th>Inicio Adicionales</th>
				<th>Fin Adicionales</th>
			</tr>
			</thead>
		</table>
		</div>
	</div>
</div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
	$(document).ready(function() {
		var oTable = $('#procedure').DataTable({
				"dom": '<"top">t<"bottom"p>',
				processing: true,
				serverSide: true,
                pageLength: 10,
                autoWidth: false,
				ajax: "{{ route('eco_com_pro_data') }}",
				columns: [

					{data: 'year', name: 'year'},
					{data: 'semester', name: 'release_date',bSortable: false },
					{data: 'normal_start_date', name: 'normal_start_date',bSortable: false },
					{data: 'normal_end_date', name: 'normal_end_date',bSortable: false },
					{data: 'lagging_start_date', name: 'lagging_start_date',bSortable: false },
					{data: 'lagging_end_date', name: 'lagging_end_date',bSortable: false },
					{data: 'additional_start_date', name: 'additional_start_date',bSortable: false },
					{data: 'additional_end_date', name: 'additional_end_date',bSortable: false },
				],
				search: {
					"regex": true
				}
			});
		});
	</script>
@endpush