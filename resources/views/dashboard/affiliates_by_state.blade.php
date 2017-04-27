<div class="box box-warning">
	<div class="box-header with-border">
		<h3 class="box-title">Total Afiliados por Estado</h3>
	</div>
	<div class="box-body" style="width: 92%">
		<canvas id="doughnu-estado" width="450" height="320"/>
	</div>
</div>
@push('scripts')
<script type="text/javascript">
var options = {
		responsive: true,
		tooltipTemplate: " <%=label%>: <%= value + ' Bs' %>",
		legend: {
			display: true
		},
	};
	var doughnutData = {
		labels: {!!json_encode($Total_AffiliatebyState[0])!!} ,
		datasets: [
		{
			data: {!!json_encode($Total_AffiliatebyState[1])!!},
			backgroundColor: [
			"#FF6384",
			"#36A2EB",
			"#FFCE56",
			"#F7464A",
			"#46BFBD"
			],
			hoverBackgroundColor: [
			"#FF6384",
			"#36A2EB",
			"#FFCE56",
			"#FF5A5E",
			"#5AD3D1"
			]
		}]
	};

	var ctx = document.getElementById("doughnu-estado").getContext("2d");
	
	var myDoughnutChart = new Chart(ctx, {
		type: 'doughnut',
		data: doughnutData,
		options: options
	});
	
</script>
@endpush