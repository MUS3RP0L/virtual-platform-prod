<div class="box box-danger">
	<div class="box-header with-border">
		<h3 class="box-title"> Total Revisados y no Revisados</h3>

	</div>
	<div class="box-body" style="width: 92%">
		<canvas id="pie-review" width="450" height="320"/>
	</div>
</div>
@push('scripts')
<script type="text/javascript">
	var data_pie_type={
		type: 'pie',
		data: {
			labels: {!!json_encode($valid_array[0])!!},
			datasets: [{
				backgroundColor: [
				"#3498db",
				"#4D50D0",
				"#2ecc71",
				"#9b59b6",
				"#e74c3c",
				"#34495e",
				"#95a5a6"
				],
				data: {!!json_encode($valid_array[1])!!}
			}]
		},
		responsive:true,
		
	};
	
	var ctx = document.getElementById("pie-review").getContext('2d');
	window.myChart = new Chart(ctx, data_pie_type );

</script>
@endpush