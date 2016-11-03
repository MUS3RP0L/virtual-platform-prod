
	{!! Html::script('bower_components/jquery/dist/jquery.min.js') !!}
	{!! Html::script('bower_components/bootstrap/dist/js/bootstrap.min.js') !!}
	{!! Html::script('bower_components/bootstrap-material-design/dist/js/ripples.min.js') !!}
	{!! Html::script('bower_components/bootstrap-material-design/dist/js/material.min.js') !!}

	<script type="text/javascript">
		$.ajaxSetup({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        }
		});
        $(document).on('ready', function(){
            $.material.init();
        });
	    $(document).ready(function(){
		    $('[data-toggle="tooltip"]').tooltip();
		});
    </script>

@if (Session::has('error'))
	<script type="text/javascript">
    	$(document).ready(function(){
			$("#myModal-error").modal('show');
		});
   </script>
@endif
