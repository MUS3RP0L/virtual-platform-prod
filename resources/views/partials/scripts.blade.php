
{!! Html::script('plugins/jQuery/jquery-2.2.3.min.js') !!}
{!! Html::script('bower_components/bootstrap/dist/js/bootstrap.min.js') !!}
{!! Html::script('bower_components/bootstrap-material-design/dist/js/ripples.min.js') !!}
{!! Html::script('bower_components/bootstrap-material-design/dist/js/material.min.js') !!}
{!! Html::script('bower_components/data-tables/media/js/jquery.dataTables.min.js') !!}
{!! Html::script('bower_components/data-tables/media/js/dataTables.bootstrap.min.js') !!}
{!! Html::script('bower_components/knockout/dist/knockout.js') !!}
{!! Html::script('bower_components/bootstrap-combobox/js/bootstrap-combobox.js') !!}
{!! Html::script('bower_components/datePicker/js/bootstrap-datepicker.js') !!}
{!! Html::script('bower_components/Chart.js/Chart.js') !!}
{!! Html::script('vendor/selectize/dist/js/standalone/selectize.min.js') !!}
{!! Html::script('js/app.min.js') !!}

<script type="text/javascript">	$.ajaxSetup({        headers: {            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')        }    });	$(document).on('ready', function(){        $.material.init();    });    $(document).ready(function(){	    $('[data-toggle="tooltip"]').tooltip();	});	@if($errors->has())    	$(document).ready(function(){			$("#myModal-error").modal('show');		});	@endif	@if (Session::has('message'))    	$(document).ready(function(){			$("#myModal-message").modal('show');		});	@endif	var root = '{{url("/")}}';	$(document).ready(function(){	    $('#searchbox').selectize({	        valueField: 'url',	        labelField: 'first_name',	        searchField: ['first_name'],	        maxOptions: 10,	        options: [],	        create: false,	        render: {	            option: function(item, escape) {	                return '<div>' +escape(item.first_name)+'</div>';	            }	        },	        optgroups: [	            {value: 'user', label: 'Usuarios'}			],	        optgroupField: 'class',	        load: function(query, callback) {	            if (!query.length) return callback();	            $.ajax({	                url: root+'/api/search',	                type: 'GET',	                dataType: 'json',	                data: {	                    q: query	                },	                error: function() {	                    callback();	                },	                success: function(res) {	                    callback(res.data);	                }	            });	        },	        onChange: function(){	            window.location = this.items[0];	        }	    });	});</script>