@extends('app')
@section('contentheader_title')
    <div class="row">
        <div class="col-md-12">
            {!! Breadcrumbs::render('eco_com_procedure') !!}
        </div>
    </div>
@endsection
@section('main-content')
<div class="col-md-12">
	<div class="box box-danger">
		<div class="box-header with-border">
			<h3 class="box-title">Rango de fechas</h3>
		</div>
		<div class="box-body" style="width: 95%">
			<table id="procedure" class="table table-hover table-condensed">
			<thead>
			<tr>
				<th>Label id</th>
				<th>Label id</th>
				<th>Label id</th>
				<th>Label id</th>
				<th>Label id</th>
				<th>Label id</th>
				<th>Label id</th>
				<th>Label id</th>
				<th>Label id</th>
			</tr>
			</thead>
		</table>
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
                "order": [[ 0, "desc" ]],
                pageLength: 10,
                autoWidth: false,
				ajax: "{{ route('eco_com_pro_data') }}",
				columns: [
					
					{data: 'id', name: 'id'},
					{data: 'year', name: 'year'},
					{data: 'semester', name: 'release_date'},
					{data: 'normal_start_date', name: 'normal_start_date'},
					{data: 'normal_end_date', name: 'normal_end_date'},
					{data: 'lagging_start_date', name: 'lagging_start_date'},
					{data: 'lagging_end_date', name: 'lagging_end_date'},
					{data: 'additional_start_date', name: 'additional_start_date'},
					{data: 'additional_end_date', name: 'additional_end_date'},
				],
				search: {
					"regex": true
				}
			});
		});
	</script>
@endpush