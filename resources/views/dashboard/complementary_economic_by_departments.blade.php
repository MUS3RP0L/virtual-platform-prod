<div class="box box-danger">
	<div class="box-header with-border">
		<h3 class="box-title">Total Complemento económico por departamentos del {!! $semester !!} semestre del {!! $year !!}</h3>
	</div>
	<div class="box-body" style="width: 92%">
		<canvas id="pie-eco-com-cities" width="450" height="320"/>
	</div>
</div>
@push('scripts')
<script type="text/javascript">
	var pieCitiesData={
		labels: {!!json_encode($economic_complement_cities[0])!!},
		datasets: [
		{
			data: {!!json_encode($economic_complement_cities[1])!!},
			backgroundColor: [
			"#f1c40f",
			"#e74c3c",
			"#3498db",
			"#2ecc71",
			"#9b59b6",
			"#34495e",
			"#95a5a6",
			"#FF6384",
			"#1AB394" 
			],
			hoverBackgroundColor: [
			"#f1c40f",
			"#e74c3c",
			"#3498db",
			"#2ecc71",
			"#9b59b6",
			"#34495e",
			"#95a5a6",
			"#FF6384",
			"#1AB394" 
			]
		}]
	}
	
	var ctx = document.getElementById("pie-eco-com-cities").getContext('2d');
	var pieCities=new Chart(ctx,{
		type:'pie',
		data:pieCitiesData
	});

</script>
@endpush