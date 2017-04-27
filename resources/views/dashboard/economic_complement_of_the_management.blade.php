<div class="box box-success">
	<div class="box-header with-border">
		<h3 class="box-title">Total complemento economico de la Gestión {!! $current_year !!}</h3>
	</div>
	<div class="box-body" style="width: 95%">
		<canvas id="bar-semestre" width="450px" height="150"></canvas>
	</div>
</div>
@push('scripts')
<script type="text/javascript">
	var dataBar = {
		labels: {!!json_encode($economic_complement_bar[0])!!},
		datasets: [
		{
			label: "Total Tramites",
			borderWidth: 1,
			data: {!!json_encode($economic_complement_bar[1])!!}
		}
		]
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

	
	var ctx = document.getElementById("bar-semestre").getContext('2d');
	var myBarChart = new Chart(ctx, {
		type: 'bar',
		data: dataBar,
		options: optionsBar
	});
</script>
@endpush