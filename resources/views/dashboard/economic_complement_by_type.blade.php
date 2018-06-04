<div class="box box-danger">
	<div class="box-header with-border">
		<h3 class="box-title">Total Complemento económico por tipos del {!! $semester !!} semestre del {!! $year !!}</h3>

	</div>
	<div class="box-body" style="width: 92%">
		<canvas id="pie-eco-com-type" width="450" height="320"/>
	</div>
</div>
@push('scripts')
<script type="text/javascript">
	var data_pie_type={
		type: 'pie',
		data: {
			labels: {!!json_encode($economic_complement_pie_types[0])!!},
			datasets: [{
				backgroundColor: [
				"#f1c40f",
				"#3498db",
				"#2ecc71",
				"#9b59b6",
				"#e74c3c",
				"#34495e",
				"#95a5a6"
				],
				data: {!!json_encode($economic_complement_pie_types[1])!!}
			}]
		},
		responsive:true,
		
	};
	
	var ctx = document.getElementById("pie-eco-com-type").getContext('2d');
	window.myChart = new Chart(ctx, data_pie_type );

</script>
@endpush