<div class="box box-danger">
	<div class="box-header with-border">
		<h3 class="box-title">Total Complemento economico por tipos de modalidades --  {!! $current_year !!}</h3>

	</div>
	<div class="box-body" style="width: 92%">
		<canvas id="pie-eco-com-mod-type" width="450" height="320"/>
	</div>
</div>
@push('scripts')
<script type="text/javascript">
	var pieModData = {
		labels: {!!json_encode($economic_complement_modalities_types[0])!!},
		datasets: [
		{
			data: {!!json_encode($economic_complement_modalities_types[1])!!},
			backgroundColor: [
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
	
	var ctx = document.getElementById("pie-eco-com-mod-type").getContext('2d');
	var pieModType=new Chart(ctx,{
		type:'pie',
		data:pieModData
	});
</script>
@endpush()