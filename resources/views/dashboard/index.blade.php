@extends('app')

@section('contentheader_title')

    {!! Breadcrumbs::render('dashboard') !!}

@endsection

@section('main-content')

    <div class="row">

        <div class="col-md-4">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Total Afiliados por Estado</h3>
                </div>
                <div class="box-body" style="width: 92%">
                    <canvas id="doughnu-estado" width="450" height="320"/>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Total Aportes por Gestión</h3>
                </div>
                <div class="box-body" style="width: 95%">
                    <canvas id="bar-aportes" width="450px" height="150"></canvas>
                </div>
            </div>
        </div>

    </div>

	<div class="row">

		<div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Total Afiliados por Tipo</h3>
                </div>
                <div class="box-body" style="width: 92%">
                    <canvas id="pie-tipo" width="450" height="320"/>
               </div>
            </div>
		</div>

		<div class="col-md-8">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Total Aportes Voluntarios de la Gestión {!! $current_year !!}</h3>
                </div>
                <div class="box-body" style="width: 95%">
                    <canvas id="bar-AporteVoluntario" width="450px" height="150"></canvas>
                </div>
            </div>
        </div>

	</div>

    <div class="row">

        <div class="col-md-4">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Total Afiliados por Distrito {!! $current_year !!}</h3>

                </div>
                <div class="box-body" style="width: 92%">
                    <canvas id="pie-distrito" width="450" height="320"/>
                </div>
            </div>
        </div>

  	    <div class="col-md-8">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Total Trámites de la Gestión {!! $current_year !!}</h3>
                </div>
                <div class="box-body" style="width: 95%">
                    <canvas id="bar-tramites" width="450px" height="150"></canvas>
                </div>
            </div>
		</div>

	</div>
	<div class="row">
		

  	    <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Total complemento economico de la Gestión {!! $current_year !!}</h3>
                </div>
                <div class="box-body" style="width: 95%">
                    <canvas id="bar-semestre" width="450px" height="150"></canvas>
                </div>
            </div>
		</div>
	</div>

@endsection

@push('scripts')

    <script type="text/javascript">

    	var doughnutData = [
    			{
    				value: {!! json_encode($Total_AffiliatebyState[1]) !!},
    				color:"#F7464A",
    				highlight: "#FF5A5E",
    				label: "Servicio" //rojo
    			},
    			{
    				value: {!! json_encode($Total_AffiliatebyState[2]) !!},
    				color: "#46BFBD",
    				highlight: "#5AD3D1",
    				label: "Comision" //verde
    			},
    			{
    				value: {!! json_encode($Total_AffiliatebyState[3]) !!},
    				color: "#FDB45C",
    				highlight: "#FFC870",
    				label: "Disponibilidad" //amarillo
    			},
    			{
    				value: {!! json_encode($Total_AffiliatebyState[4]) !!},
    				color: "#949FB1",
    				highlight: "#A8B3C5",
    				label: "Fallecido"  //grey
    			},
    			{
    				value: {!! json_encode($Total_AffiliatebyState[5]) !!},
    				color: "#4D5360",
    				highlight: "#616774",
    				label: "Jubilado"  //Dark Grey
    			},
    			{
    				value: {!! json_encode($Total_AffiliatebyState[6]) !!},
    				color: "#FF8C00",
    				highlight: "#FC9E2B",
    				label: "Jublición por Invalidez"  //Dark Orange
    			},
    			{
    				value: {!! json_encode($Total_AffiliatebyState[7]) !!},
    				color: "#8FBC8F",
    				highlight: "#8FC08F",
    				label: "Forzosa" //Dark Sea Green
    			},
    			{
    				value: {!! json_encode($Total_AffiliatebyState[8]) !!},
    				color: "#1E90FF",
    				highlight: "#3496F8",
    				label: "Voluntario" //DodgerBlue
    			},
    			{
    				value: {!! json_encode($Total_AffiliatebyState[9]) !!},
    				color:"#B0C4DE",
    				highlight: "#BAC9DE",
    				label: "Temporal" //LightSteelBlue
    			}

    		];

    	var pieData = [
    				{
    					value: {!! json_encode($Total_AffiliatebyType[1]) !!},
    					color:"#F7464A",
    					highlight: "#FF5A5E",
    					label: "Comando"
    				},
    				{
    					value: {!! json_encode($Total_AffiliatebyType[2]) !!},
    					color: "#46BFBD",
    					highlight: "#5AD3D1",
    					label: "Batallon"
    				}

    			];

    	var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
    	var barChartData = {
    		labels : {!! json_encode($totalContributionByYear[0]) !!},
    		datasets : [

    			{
    				fillColor : "rgba(151,187,205,0.5)",
    				strokeColor : "rgba(151,187,205,0.8)",
    				highlightFill : "rgba(151,187,205,0.75)",
    				highlightStroke : "rgba(151,187,205,1)",
    				data : {!! json_encode($totalContributionByYear[1]) !!}
    			}
    		]

    	}

    	var pieDistrito = [
    				{
    					value: {!! json_encode($list_affiliateByDisctrict["CHUQUISACA"]) !!},
    					color:"#F7464A",
    					highlight: "#FF5A5E",
    					label: "Chuquisaca" //red
    				},
    				{
    					value: {!! json_encode($list_affiliateByDisctrict["LA PAZ"]) !!},
    					color: "#46BFBD",
    					highlight: "#5AD3D1",
    					label: "La Paz" //green
    				},
    				{
    					value: {!! json_encode($list_affiliateByDisctrict["EL ALTO"]) !!},
    					color: "#FDB45C",
    					highlight: "#FFC870",
    					label: "El Alto" //yellow
    				},
    				{
    					value: {!! json_encode($list_affiliateByDisctrict["ZONA SUR"]) !!},
    					color: "#949FB1",
    					highlight: "#A8B3C5",
    					label: "Zona Sur" // grey
    				},
    				{
    					value: {!! json_encode($list_affiliateByDisctrict["COCHABAMBA"]) !!},
    					color: "#4D5360",
    					highlight: "#616774",
    					label: "Cochabamba" //DarkGrey
    				},
    				{
    					value: {!! json_encode($list_affiliateByDisctrict["ORURO"]) !!},
    					color: "#D8BFD8",
    					highlight: "#E1CFE1",
    					label: "Oruro" //Thistle
    				},
    				{
    					value: {!! json_encode($list_affiliateByDisctrict["POTOSI"]) !!},
    					color: "#008080",
    					highlight: "#0E9696",
    					label: "Potosí" // teal
    				},
    				{
    					value: {!! json_encode($list_affiliateByDisctrict["TUPIZA"]) !!},
    					color: "#A52A2A",
    					highlight: "#A44444",
    					label: "Tupiza" //Brown
    				},
    				{
    					value: {!! json_encode($list_affiliateByDisctrict["VILLAZON"]) !!},
    					color: "#6495ED",
    					highlight: "#759EEB",
    					label: "Villazon" //CornFlowerBlue
    				},
    				{
    					value: {!! json_encode($list_affiliateByDisctrict["TARIJA"]) !!},
    					color: "#DC143C",
    					highlight: "#DA3254",
    					label: "Tarija" //Crimson
    				},
    				{
    					value: {!! json_encode($list_affiliateByDisctrict["YACUIBA"]) !!},
    					color: "#8B008B",
    					highlight: "#616774",
    					label: "Yacuiba" //DarkMagenta
    				},
    				{
    					value: {!! json_encode($list_affiliateByDisctrict["VILLAMONTES"]) !!},
    					color: "#2F4F4F",
    					highlight: "#616774",
    					label: "Villamontes" //DarkSlateGray
    				},
    				{
    					value: {!! json_encode($list_affiliateByDisctrict["BERMEJO"]) !!},
    					color: "#00BFFF",
    					highlight: "#8F258F",
    					label: "Bermejo" // DeepSkyBlue
    				},
    				{
    					value: {!! json_encode($list_affiliateByDisctrict["SANTA CRUZ"]) !!},
    					color: "#1E90FF",
    					highlight: "#2994FF",
    					label: "Santa Cruz" //DodgerBlue
    				},
    				{
    					value: {!! json_encode($list_affiliateByDisctrict["SAN MATIAS"]) !!},
    					color: "#D2B48C",
    					highlight: "#D1B999",
    					label: "San Matias" //tan
    				},
    				{
    					value: {!! json_encode($list_affiliateByDisctrict["S. I. VELASCO"]) !!},
    					color: "#228B22",
    					highlight: "#259C25",
    					label: "Velasco" //ForestGreen
    				},
    				{
    					value: {!! json_encode($list_affiliateByDisctrict["PTO. SUAREZ"]) !!},
    					color: "#FFFAF0",
    					highlight: "#F6F3EC",
    					label: "Pto. Suarez" //FloralWhite
    				},
    				{
    					value: {!! json_encode($list_affiliateByDisctrict["BENI"]) !!},
    					color: "#E9967A",
    					highlight: "#E9967A",
    					label: "Beni" //DarkSalmon
    				},
    				{
    					value: {!! json_encode($list_affiliateByDisctrict["RIBERALTA"]) !!},
    					color: "#8FBC8F",
    					highlight: "#94BD94",
    					label: "Riberalta" //DarkSeaGreen
    				},
    				{
    					value: {!! json_encode($list_affiliateByDisctrict["GUAYARAMERIN"]) !!},
    					color: "#F4A460",
    					highlight: "#F6A965",
    					label: "Guayaramerin" //SandyBrown
    				},
    				{
    					value: {!! json_encode($list_affiliateByDisctrict["PANDO"]) !!},
    					color: "#4682B4",
    					highlight: "#528AB7",
    					label: "Pando" //SteelBlue
    				}

    			];

    	var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
    	var barAporteVoluntario = {
    		labels : {!! json_encode($total_voluntayContributionByMonth[0]) !!},
    		datasets : [

    			{
    				fillColor : "rgba(151,187,205,0.5)",
    				strokeColor : "rgba(151,187,205,0.8)",
    				highlightFill : "rgba(151,187,205,0.75)",
    				highlightStroke : "rgba(151,187,205,1)",
    				data : {!! json_encode($total_voluntayContributionByMonth[1]) !!}
    			}
    		]

    	}
        var options = {
            responsive: true,
            tooltipTemplate: " <%=label%>: <%= value + ' Bs' %>",
        };

        //for complement economic

        var barChartDataSemestre = {
        	labels : {!! json_encode($totalContributionByYear[0]) !!},
        	datasets : [
        		{
        			fillColor : "rgba(151,187,105,0.5)",
        			strokeColor : "rgba(151,187,105,0.8)",
        			highlightFill : "rgba(151,187,105,0.75)",
        			highlightStroke : "rgba(151,187,105,1)",
        			data : {!! json_encode($totalContributionByYear[1]) !!}
        		}
        	]

        }

    	window.onload = function(){

    		var ctx = document.getElementById("doughnu-estado").getContext("2d");
    		window.myDoughnut = new Chart(ctx).Doughnut(doughnutData, {responsive : true});

    		var ctx = document.getElementById("pie-tipo").getContext("2d");
    		window.myPie = new Chart(ctx).Pie(pieData, {responsive : true});

    		var ctx = document.getElementById("bar-aportes").getContext("2d");
    		window.myBar = new Chart(ctx).Bar(barChartData, options);

    		var ctx = document.getElementById("pie-distrito").getContext("2d");
    		window.myPie = new Chart(ctx).Pie(pieDistrito, {responsive : true});
    		/* Faltan estas graficas del dhasboard general

    		var ctx = document.getElementById("bar-AporteVoluntario").getContext("2d");
    		window.myBar = new Chart(ctx).Bar(barAporteVoluntario, {responsive : true});

    		var ctx = document.getElementById("bar-tramites").getContext("2d");
    		window.myBar = new Chart(ctx).Bar(barTramites, {responsive : true});
			*/
    		// for complement economic

    		var ctx = document.getElementById("bar-semestre").getContext("2d");
    		window.myBar = new Chart(ctx).Bar(barChartDataSemestre, {responsive : true});

    	}

    </script>

@endpush
