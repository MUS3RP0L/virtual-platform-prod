<header class="main-header">

    <a href="{{ url('/home') }}" class="logo">
        <span class="logo-mini"><img src="{{asset('/img/logo_muserpol.png')}}" alt="Logo Muserpol" style="width: 30px;margin: 5px;"/></span>
        <span class="logo-lg">MUSERPOL</span>
    </a>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li>
                    <div class="form-group" style="padding-bottom:0px;padding-top:4px;padding-right:12px;">
                        <select id="searchbox" name="q" class="form-control" style="width: 200px; top: 34px; visibility: visible;"></select>
                    </div>
                </li>

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="hidden-xs"><i class="fa fa-user fa-fw fa-lg"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <p style="color:#fff;  font-weight: bold;">
                                {!! Util::ucw(Auth::user()->first_name) !!} {!! Util::ucw(Auth::user()->last_name)!!}
                            </p>
                            <p >
                                 {!!   Util::getRol()->name !!}
                                <!-- {!!Auth::user()->getModule()->name !!} -->
                                <a href="{{ url('ChangeRol')}}" class="btn btn-raised btn-xs" data-toggle="tooltip" title="Cambiar de Rol" ><i class="fa fa-exchange"></i></a>
                            </p>
                            
                     
                        </li>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{!! url('user/' . Auth::user()->id . '/edit') !!}" class="btn btn-raised btn-info">Perfil</a>
                            </div>
                            <div class="pull-right">
                                <a href="{!! url('logout') !!}" class="btn btn-raised btn-danger">Salir</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-cog fa-fw fa-lg"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>
