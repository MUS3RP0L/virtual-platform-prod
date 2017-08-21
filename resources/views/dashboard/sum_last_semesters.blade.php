<div class="box box-success">
	<div class="box-header with-border">
		<h3 class="box-title">Totales de los últimos 5 semestres</h3>
	</div>
	<div class="box-body" style="width: 95%">
		<canvas id="bar-sum-last-semesters" width="450px" height="150"></canvas>
	</div>
</div>
@push('scripts')
<script type="text/javascript">
	var dataBar = {
		labels: {!!json_encode($sum_last_semesters[0])!!},
		datasets: [{
			label: 'Tramites',
			backgroundColor: 'rgba(255, 118, 132,.5)',
		    borderWidth: 1,
		    data: {!!json_encode($sum_last_semesters[1])!!}
		}]
	};
	var optionsBar={
		legend:{
			display:false
		},
		tooltips: {
			enabled: true,
			mode: 'single',
			callbacks: {
				label: function(tooltipItems, data) { 
					var n = tooltipItems.yLabel;
					n = n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,')
					return n + ' Bs';
				}
			}
		},
		responsive: true,
		scales: {
			yAxes: [{
				ticks: {
					beginAtZero: true,
				}
			}]
		}
	};


	var ctx = document.getElementById("bar-sum-last-semesters").getContext('2d');
	var myBarChart = new Chart(ctx, {
		type: 'bar',
		data: dataBar,
		options: optionsBar
	});
</script>
@endpush