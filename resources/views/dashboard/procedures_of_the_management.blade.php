<div class="box box-success">
	<div class="box-header with-border">
		<h3 class="box-title">Total Trámites de la Gestión {!! $current_year !!}</h3>
	</div>
	<div class="box-body" style="width: 95%">
		<canvas id="bar-tramites" width="450px" height="150"></canvas>
	</div>
</div>
@push('scripts')
<script type="text/javascript">
	
	

	
    		/* Faltan estas graficas del dhasboard general

    		var ctx = document.getElementById("bar-tramites").getContext("2d");
    		window.myBar = new Chart(ctx).Bar(barTramites, {responsive : true});
    		*/
    		// for complement economic

    		/*
    		*/
    		
    	</script>
    	@endpush