<style>
    
    .selectize-dropdown.plugin-optgroup_columns .optgroup:last-child {
        border-right: 0 none;
    }
    .selectize-dropdown.plugin-optgroup_columns .optgroup:before {
        display: none;
    }
    .selectize-dropdown.plugin-optgroup_columns .optgroup-header {
        border-top: 0 none;
    }
    .selectize-control.plugin-remove_button [data-value] {
        position: relative;
        padding-right: 24px !important;
    }
    .selectize-control {
        position: relative;
    }
    .selectize-dropdown,
    .selectize-input,
    .selectize-input input {
        font-family: inherit;
        font-size: 13px;
        -webkit-font-smoothing: inherit;
        line-height: 18px;
        color: #fff;
    }
    .selectize-dropdown{
        color: #3c3c3c;
    }
    .selectize-input,
    .selectize-control.single .selectize-input.input-active {
        display: inline-block;
        padding: 0px 5px;
        cursor: text;
        background: rgba(0,0,0,.2);
    }
    .selectize-input {
        position: relative;
        z-index: 1;
        display: inline-block;
        width: 100%;
        padding: 8px 8px;
        overflow: hidden;
        border: 1px solid #d0d0d0;
        border-radius: 3px;
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.1);
        box-sizing: border-box;
        
    }
    .selectize-control.multi .selectize-input.has-items {
        padding: 5px 8px 2px;
    }
    .selectize-input > input {
        max-width: 100% !important;
        max-height: none !important;
        min-height: 0 !important;
        padding: 0 5px; 
        margin: 0 1px !important;
        line-height: 40px !important;
        text-indent: 0 !important;
        background: none !important;
        border: 0 none !important;
        -webkit-box-shadow: none !important;
        box-shadow: none !important;
        -webkit-user-select: auto !important;
    }
    .selectize-input > input:focus {
        outline: none !important;
    }
    .selectize-input::after {
        display: block;
        clear: left;
        content: ' ';
    }
    
    .selectize-control.searchbox::before {
        -moz-transition: opacity 0.2s;
        -webkit-transition: opacity 0.2s;
        transition: opacity 0.2s;
        content: ' ';
        z-index: 2;
        position: absolute;
        display: block;
        top: 12px;
        right: 34px;
        width: 16px;
        height: 16px;
        background: url('./img/spinner.gif');
        background-size: 16px 16px;
        opacity: 0;
    }
    .selectize-control.searchbox.loading::before {
        opacity: 0.4;
    }
    .selectize-dropdown>.selectize-dropdown-content> .optgroup>.active {
        color: #fff;
        background-color: rgba(0, 150, 136, 0.8);
    }
    ::-webkit-input-placeholder { /* WebKit, Blink, Edge */
        color:    #fff;
        opacity: 0.8;
        font-weight: lighter;
    }
    :-moz-placeholder { /* Mozilla Firefox 4 to 18 */
       color:    #fff;
       opacity:  0.8;
        font-weight: lighter;
    }
    ::-moz-placeholder { /* Mozilla Firefox 19+ */
       color:    #fff;
       opacity:  0.8;
        font-weight: lighter;
    }
    :-ms-input-placeholder { /* Internet Explorer 10-11 */
       opacity:  0.8;
       color:    #fff;
        font-weight: lighter;
    }
    ::-ms-input-placeholder { /* Microsoft Edge */
       opacity:  0.8;
       color:    #fff;
        font-weight: lighter;
    }
    /*.selectize-input  {
      font-family: "FontAwesome", sans-serif;
    }*/
    .selectize-input>input::-webkit-input-placeholder {
      -moz-transition: ease-in 0.3s;
      -o-transition: ease-in 0.3s;
      -webkit-transition: ease-in 0.3s;
      transition: ease-in 0.5s;
      transform-origin: 0 50%;
      font-weight: normal;
    }

    .selectize-input>input:focus::-webkit-input-placeholder{
      -moz-transform: translateX(70%);
      -ms-transform: translateX(70%);
      -webkit-transform: translateX(70%);
      transform: translateX(70%);
      opacity: 0;
    }
</style>
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
                        <div class="row form-inline">
                            <select id="search_type" name="search_type" class="form-control">
                                <option value="1" @if(Session::get('search_type')==1) selected @endif>Afiliado</option>
                                <option value="2" @if(Session::get('search_type')==2) selected @endif>Beneficiario</option>
                            </select>
                            <select id="searchbox" placeholder="Buscar ..." name="q" class="searchbox form-control" style="width: 200px; top: 34px; visibility: visible;"></select>
                        </div>
                        {{-- <select id="searchbox" placeholder="&#xf002; Buscar Afiliado..." name="q" class="searchbox form-control" style="width: 200px; top: 34px; visibility: visible;"></select> --}}
                    </div>
                </li>

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class=""><i class="fa fa-user fa-fw fa-lg"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <p style="color:#fff;  font-weight: bold;">
                                {!! Util::ucw(Auth::user()->first_name) !!} {!! Util::ucw(Auth::user()->last_name)!!}
                            </p>
                            <p >
                                 {!!   Util::getRol()->name !!}  <a href="{{ url('ChangeRol')}}" class="btn btn-raised btn-xs" data-toggle="tooltip" title="Cambiar de Rol" > <i class="fa fa-exchange"></i></a>
                                 <br>
                                 {!! Util::getRol()->module->name !!}
                               
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
                <li  data-toggle="tooltip" data-placement="bottom" title="Ayuda">
                    <a href="http://support.muserpol.gob.bo:8082" target="_blank"><i class="fa fa-question-circle-o fa-lg"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>
