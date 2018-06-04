<!DOCTYPE html>

<html>

    @include('partials.htmlheader')

    <body class="skin-green sidebar-mini fixed wysihtml5-supported sidebar-collapse">

        <div id="myModal-error" class="modal modal-danger fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Mensaje</h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            @foreach ($errors->all() as $error)
                                <div><h4>{{ $error }}</h4></div>
                            @endforeach
                            <div><h4>{{session::get('error')}}</h4></div>
                        </p>
                    </div>
                    <div class="modal-footer">
                        <div class="row text-center">
                            <button type="button" class="btn btn-raised btn-default" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="myModal-message" class="modal modal-info fade">
		    <div class="modal-dialog">
		    	<div class="modal-content">
		        	<div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
		                <h3 class="modal-title">Mensaje</h3>
		            </div>
	                <div class="modal-body">
	                    <p>
			          		<div><h4>{!! Session::get('message') !!}</h4></div>
	                    </p>
	                </div>
	                <div class="modal-footer">
		            	<div class="row text-center">
                            <button type="button" class="btn btn-raised btn-default" data-dismiss="modal">Cerrar</button>
		            	</div>
		            </div>
		        </div>
		    </div>
		</div>

    <div class="modal fade" tabindex="-1">
             {{-- <iframe src="/print_observations/{{ Session::get('affiliate_id') }}/{{ Session::get('observation_type_id') }}" id="iFramePdfObservation" ></iframe> --}}
    </div>

        <div class="wrapper">

            @include('partials.mainheader')

            @include('partials.sidebar')

            <div class="content-wrapper">

                @include('partials.contentheader')

                <section class="content">

                    @yield('main-content')

                </section>

            </div>

            @include('partials.controlsidebar')

            @include('partials.footer')

        </div>

        @include('partials.scripts')

        @yield('scripts')

    </body>
</html>
