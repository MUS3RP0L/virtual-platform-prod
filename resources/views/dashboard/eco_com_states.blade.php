<div class="box box-danger">
	<div class="box-header with-border">
		<h3 class="box-title">Estado de los Trámites del {!! $semester !!} semestre del {!! $year !!}</h3>

	</div>
	<div class="box-body" style="width: 92%">
		<canvas id="pie-eco-states" width="450" height="320"/>
	</div>
</div>
@push('scripts')
<script type="text/javascript">
	var pieModData = {
		labels: {!!json_encode($eco_com_states_pie[0])!!},
		datasets: [
		{
			data: {!!json_encode($eco_com_states_pie[1])!!},
			backgroundColor: [
			'#4dc9f6',
	        '#f67019',
	        '#f53794',
	        '#537bc4',
	        '#acc236',
	        '#166a8f',
	        '#00a950',
	        '#58595b',
	        '#8549ba'
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
	        '#8549ba'
			]
		}]
	};
	
	var ctx = document.getElementById("pie-eco-states").getContext('2d');
	var pieModType=new Chart(ctx,{
		type:'pie',
		data:pieModData
	});
</script>
@endpush()