<div class="box box-info">
	<div class="box-header with-border">
		<h3 class="box-title">Ubicación de los Trámites del {!! $last_economic_complement->semester !!} semestre de {!! $last_year !!}</h3>
	</div>
	<div class="box-body" style="width: 95%">
		<canvas id="bar-wf-states" width="450px" height="150"></canvas>
	</div>
</div>
@push('scripts')
<script type="text/javascript">
	var barChartData = {
	           labels: {!! json_encode($wf_states_bar[0]) !!},
	           datasets: [{
	               label: 'Revisados',
	               backgroundColor: 'rgb(75, 192, 192)',
	               data: {!! json_encode($wf_states_bar[1]) !!}
	           },{
	               label: 'NO revisados',
	               backgroundColor: 'rgb(255, 99, 132)',
	               data: {!! json_encode($wf_states_bar[2]) !!}
	           }]

	       };	

	var ctx = document.getElementById("bar-wf-states").getContext("2d");
	window.myBar = new Chart(ctx, {
		type: 'bar',
        data: barChartData,
        options: {
            tooltips: {
                mode: 'index',
                intersect: false
            },
            responsive: true,
			legend:{
				display:false
			},
            scales: {
                xAxes: [{
                    stacked: true,
                }],
                yAxes: [{
                    stacked: true
                }]
            }
        }
	});
</script>
@endpush