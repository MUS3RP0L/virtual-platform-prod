<div class="box box-danger">
	<div class="box-header with-border">
		<h3 class="box-title">Afiliados observados con trámites del {!! $last_economic_complement->semester !!} semestre del {!! $last_year !!}</h3>

	</div>
	<div class="box-body" style="width: 92%">
		<canvas id="pie-eco-observations" width="450" height="320"/>
	</div>
</div>
@push('scripts')
<script type="text/javascript">
	var pieModData = {
		labels: {!!json_encode($eco_com_observations_pie[0])!!},
		datasets: [
		{
			data: {!!json_encode($eco_com_observations_pie[1])!!},
			backgroundColor: [
			'#4dc9f6',
	        '#f67019',
	        '#f53794',
	        '#537bc4',
	        '#acc236',
	        '#166a8f',
	        '#00a950',
	        '#58595b',
	        '#8549ba',
	        "#e74c3c",
			"#3498db",
			"#1AB394",
			"#34495e",
			"#95a5a6",
			"#f1c40f",
			"#2ecc71",
			"#9b59b6",
			"#FF6384",
			],
			hoverBackgroundColor: [
			'#4dc9f6',
	        '#f67019',
	        '#f53794',
	        '#537bc4',
	        '#acc236',
	        '#166a8f',
	        '#00a950',
	        '#58595b',
	        '#8549ba',
	        "#e74c3c",
			"#3498db",
			"#1AB394",
			"#34495e",
			"#95a5a6",
			"#f1c40f",
			"#2ecc71",
			"#9b59b6",
			"#FF6384",
			]
		}]
	};
	
	var ctx = document.getElementById("pie-eco-observations").getContext('2d');
	var pieModType=new Chart(ctx,{
		type:'pie',
		data:pieModData,
		options: {
			responsive: true,
			legend: {
				display:false,
			    // labels: {
			    //     generateLabels: function(chart) {
			    //         return [
			    //             { 
			    //                 text: '',
			    //                 fillStyle: 'red'
			    //             }
			    //         ]
			    //     }    
			    // }
			}
		}
	});
</script>
@endpush()