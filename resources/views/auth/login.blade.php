@extends('auth.auth')

@section('content')
<body class="login-page">
    <div class="login-box">
        <div class="login-logo">
            Plataforma Virtual <b>MUSERPOL</b>
        </div>

        <div id="myModal-error" class="modal modal-danger fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Mensaje</h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            @foreach ($errors->all() as $error)
                                <div><h4>{{ $error }}</h4></div>
                            @endforeach
                            <div><h4>{{Session::get('error')}}</h4></div>
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

        <div class="box box-success">
            <div class="login-box-body">
                {!! Form::open(['url' => 'login', 'role' => 'form']) !!}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" placeholder="Nombre de Usuario" name="username" required/>
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" placeholder="Contraseña" name="password" required/>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-block btn-raised btn-primary">Ingresar</button>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>

    </div><!-- /.login-box -->

    @include('auth.scripts')

</body>

@endsection
