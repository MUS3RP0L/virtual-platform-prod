<aside class="control-sidebar control-sidebar-dark">

    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li class="active"><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-wrench"></i></a></li>
        <li><a href="#control-sidebar-reports-tab" data-toggle="tab"><i class="fa fa-file-text-o"></i></a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="control-sidebar-settings-tab">
            <h4 class="control-sidebar-heading"><b>Configuración</b></h4>
            <ul class="control-sidebar-menu">
                @can('manage')
                    <li>
                      <a href="{{ url('user') }}">
                        <div class="menu">
                            <label class="control-sidebar-subheading">Usuarios</label>
                        </div>
                      </a>
                    </li>
                @endcan
                @can('economic_complement')
                    <li>
                      <a href="{{ url('complementary_factor') }}">
                        <div class="menu">
                            <label class="control-sidebar-subheading">- Intervalos de Fechas</label>
                        </div>
                      </a>
                    </li>
                    <li>
                        <a href="{{ url('complementary_factor') }}">
                            <div class="menu">
                                <label class="control-sidebar-subheading">- Factor de Complemantación</label>
                            </div>
                        </a>
                    </li>
                @endcan
                @can('retirement_fund')
                    <li>
                        <a href="{{ url('contribution_rate') }}">
                            <div class="menu">
                                <label class="control-sidebar-subheading">- Tasas de Aporte</label>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('ipc_rate') }}">
                            <div class="menu">
                                <label class="control-sidebar-subheading">- Tasas de IPC</label>
                            </div>
                        </a>
                    </li>
                @endcan
                <li>
                  <a href="{{ url('base_wage') }}">
                    <div class="menu">
                        <label class="control-sidebar-subheading">- Salario Básico</label>
                    </div>
                  </a>
                </li>
            </ul>
        </div>

        <div class="tab-pane" id="control-sidebar-reports-tab">
            <h4 class="control-sidebar-heading"><b>Reportes de Usuario</b></h4>
            <ul class="control-sidebar-menu">
                @can('economic_complement')
                    <li>
                      <a href="{!! url('print_activity/'."1") !!}">
                        <div class="menu">
                            <label class="control-sidebar-subheading">- Diario</label>
                        </div>
                      </a>
                    </li>
                    <li>
                        <a href="{!! url('activity') !!}">
                            <div class="menu">
                                <label class="control-sidebar-subheading">- Por fecha</label>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="{!! url('print_activity/'."2") !!}">
                            <div class="menu">
                                <label class="control-sidebar-subheading">- General</label>
                            </div>
                        </a>
                    </li>
                @endcan
            </ul>
            <h4 class="control-sidebar-heading"><b>Reportes del Beneficio</b></h4>
            <ul class="control-sidebar-menu">
                @can('economic_complement')
                    <li>
                      <a href="{!! url('report_complement') !!}">
                        <div class="menu">
                            <label class="control-sidebar-subheading">- Parametrizada</label>
                        </div>
                      </a>
                    </li>
                    <li>
                        <a href="{!! url('averages') !!}">
                            <div class="menu">
                                <label class="control-sidebar-subheading">- Promedios</label>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="{!! url('get_updated_list') !!}">
                            <div class="menu">
                                <label class="control-sidebar-subheading">- Modificaciones</label>
                            </div>
                        </a>
                    </li>
                @endcan
            </ul>
        </div>
    </div>
</aside>

<div class='control-sidebar-bg'></div>
