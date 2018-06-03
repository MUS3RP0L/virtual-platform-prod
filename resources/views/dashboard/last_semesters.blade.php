<div class="box box-success">
	<div class="box-header with-border">
		<h3 class="box-title">Total de Trámites de los últimos {{ $limit_semesters }} semestres</h3>
	</div>
	<div class="box-body" style="width: 95%">
		<canvas id="bar-last-semesters" width="450px" height="150"></canvas>
	</div>
</div>
@push('scripts')
<script type="text/javascript">
	var dataBar = {
		labels: {!!json_encode($last_semesters[0])!!},
		datasets: [{
			label: 'Tramites',
		    borderWidth: 1,
		    data: {!!json_encode($last_semesters[1])!!}
		}]
	};
	var optionsBar={
		responsive: true,
		scales: {
			yAxes: [{
				ticks: {
					beginAtZero: true,
				}
			}]
		}
	};

	
	var ctx = document.getElementById("bar-last-semesters").getContext('2d');
	var myBarChart = new Chart(ctx, {
		type: 'bar',
		data: dataBar,
		options: optionsBar
	});
</script>
@endpush