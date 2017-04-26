<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">Total Afiliados por Tipo</h3>
	</div>
	<div class="box-body" style="width: 92%">
		<canvas id="pie-tipo" width="450" height="320"/>
	</div>
</div>
@push('scripts')
<script type="text/javascript">
	
	var pieData = {
		labels:{!!json_encode($Total_AffiliatebyType[0])!!},
		datasets: [
		{
			data: {!! json_encode($Total_AffiliatebyType[1])!!},

			backgroundColor: [
			"#F7464A",
			"#46BFBD"
			],
			hoverBackgroundColor: [
			"#FF5A5E",
			"#5AD3D1"
			]
		}]
	};


	var ctx = document.getElementById("pie-tipo").getContext("2d");
	window.myPie = new Chart(ctx, {
		type: 'pie',
		data: pieData,
		options: options,

	});

</script>
@endpush