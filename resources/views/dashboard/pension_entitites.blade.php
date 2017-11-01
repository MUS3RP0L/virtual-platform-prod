<div class="box box-warning">
	<div class="box-header with-border">
		<h3 class="box-title">Total Afiliados por Ente Gestor</h3>
	</div>
	<div class="box-body" style="width: 92%">
		<canvas id="pension_entities_pie" width="450" height="320"/>
	</div>
</div>
@push('scripts')
<script type="text/javascript">
var options = {
		responsive: true,
		legend: {
			display: true
		},
	};
	var doughnutData = {
		labels: {!!json_encode($pension_entities_pie[0])!!} ,
		datasets: [
		{
			data: {!!json_encode($pension_entities_pie[1])!!},
			backgroundColor: [
			"#FF6384",
			"#5AD3D1",
			"#FFCE56",
			"#F7464A",
			"#46BFBD",
			"#36A2EB",
			],
			hoverBackgroundColor: [
			"#FF6384",
			"#5AD3D1",
			"#FFCE56",
			"#F7464A",
			"#46BFBD",
			"#36A2EB",
			]
		}]
	};

	var ctx = document.getElementById("pension_entities_pie").getContext("2d");
	
	var myDoughnutChart = new Chart(ctx, {
		type: 'doughnut',
		data: doughnutData,
		options: options
	});
	
</script>
@endpush