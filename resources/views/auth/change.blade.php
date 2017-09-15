@extends('auth.auth')

@section('content')
<body class="login-page">
    <div class="login-box">
        <div class="login-logo">
           <b>MUSERPOL</b>
        </div>

        
        <div class="box box-success">
            <div class="login-box-body">
                {!! Form::open(['url' => 'PostChangeRol', 'role' => 'form']) !!}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group has-feedback">
                        <select  class="form-control" name="rol_id">
                            @foreach($roles as $role)
                                
                                    <option value="{{$role->id}}" {{( (Util::getRol()->id ?? 0) == $role->id) ? 'selected' : '' }}> {{$role->name}} de {{$role->module->name}}  </option>
                            @endforeach
                            
                        </select>
                        
                        <span class="fa fa-exchange form-control-feedback"></span>
                    </div>
                    
                    <div class="row">
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-block btn-raised btn-primary">{{ Util::getRol() ? 'Cambiar' : 'Ingresar'  }}</button>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>

    </div><!-- /.login-box -->

    @include('auth.scripts')

</body>

@endsection
