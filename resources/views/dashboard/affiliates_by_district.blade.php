<div class="box box-danger">
	<div class="box-header with-border">
		<h3 class="box-title">Total Afiliados por Distrito {!! $current_year !!}</h3>

	</div>
	<div class="box-body" style="width: 92%">
		<canvas id="pie-distrito" width="450" height="320"/>
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
	var pieDistritoData= {
		labels: {!!json_encode($list_affiliateByDisctrict[0])!!},
		datasets: [
		{
			data: {!!json_encode($list_affiliateByDisctrict[1])!!},

			backgroundColor: [
			"#F7464A",
			"#46BFBD",
			"#FDB45C",
			"#949FB1",
			"#4D5360",
			"#D8BFD8",
			"#008080",
			"#A52A2A",
			"#6495ED",
			"#DC143C",
			"#8B008B",
			"#2F4F4F",
			"#00BFFF",
			"#1E90FF",
			"#D2B48C",
			"#228B22",
			"#FFFAF0",
			"#E9967A",
			"#8FBC8F",
			"#F4A460",
			"#4682B4"
			],
			hoverBackgroundColor: [
			"#FF5A5E",
			"#5AD3D1",
			"#FFC870",
			"#A8B3C5",
			"#616774",
			"#E1CFE1",
			"#0E9696",
			"#A44444",
			"#759EEB",
			"#DA3254",
			"#616774",
			"#616774",
			"#8F258F",
			"#2994FF",
			"#D1B999",
			"#259C25",
			"#F6F3EC",
			"#E9967A",
			"#94BD94",
			"#F6A965",
			"#528AB7"
			]
		}]
	};
	
	var ctx = document.getElementById("pie-distrito").getContext("2d");
	window.myPie = new Chart(ctx,{
		type: 'pie',
		data: pieDistritoData,
        	    options: options
        	});

        </script>	
        @endpush()