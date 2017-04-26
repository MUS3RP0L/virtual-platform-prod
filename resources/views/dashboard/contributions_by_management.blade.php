<div class="box box-info">
	<div class="box-header with-border">
		<h3 class="box-title">Total Aportes por Gestión</h3>
	</div>
	<div class="box-body" style="width: 95%">
		<canvas id="bar-aportes" width="450px" height="150"></canvas>
	</div>
</div>
@push('scripts')
<script type="text/javascript">
	
	var barChartData = {
		labels : {!! json_encode($totalContributionByYear[0]) !!},
		datasets : [

		{
			label: false,
			backgroundColor: [
			'rgba(255, 99, 132, 0.2)',
			'rgba(54, 162, 235, 0.2)',
			'rgba(255, 206, 86, 0.2)',
			'rgba(75, 192, 192, 0.2)',
			'rgba(153, 102, 255, 0.2)',
			'rgba(255, 159, 64, 0.2)'
			],
			borderColor: [
			'rgba(255,99,132,1)',
			'rgba(54, 162, 235, 1)',
			'rgba(255, 206, 86, 1)',
			'rgba(75, 192, 192, 1)',
			'rgba(153, 102, 255, 1)',
			'rgba(255, 159, 64, 1)'
			],
			data : {!! json_encode($totalContributionByYear[1]) !!}
		}
		]

	};

	var ctx = document.getElementById("bar-aportes").getContext("2d");
	window.myBar = new Chart(ctx, {
		type: 'bar',
		data: barChartData,
		options: {
			legend:{
				display:false
			},
			tooltips: {
				enabled: true,
				mode: 'single',
				callbacks: {
					label: function(tooltipItems, data) { 
						return tooltipItems.yLabel + ' Bs';
					}
				}
			},
		}
	});
</script>
@endpush