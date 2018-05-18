<div class="box box-warning">
	<div class="box-header with-border">
		<h3 class="box-title">Total de tipo de recepción del {!! $last_economic_complement->semester !!} semestre del {!! $last_year !!} </h3>
	</div>
	<div class="box-body" style="width: 92%">
		<canvas id="reception_type_pie" width="450" height="320"/>
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
		labels: {!!json_encode($reception_type_pie[0])!!} ,
		datasets: [
		{
			data: {!!json_encode($reception_type_pie[1])!!},
			backgroundColor: [
			"#ff7a56",
			"#56dbff",
			],
			hoverBackgroundColor: [
			"#ff7a56",
			"#56dbff",
			]
		}]
	};

	var ctx = document.getElementById("reception_type_pie").getContext("2d");
	
	var myDoughnutChart = new Chart(ctx, {
		type: 'doughnut',
		data: doughnutData,
		options: options
	});
	
</script>
@endpush