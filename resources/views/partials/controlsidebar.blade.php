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
                            <label class="control-sidebar-subheading"><i class="fa fa-users"> Usuarios</i></label>
                        </div>
                      </a>
                    </li>
                @endcan
                @can('economic_complement')
                    <li>
                        <a href="{!! url('averages') !!}">
                            <div class="menu">
                                <label class="control-sidebar-subheading"><i class="fa fa-medium"> Promedios</i></label>
                            </div>
                        </a>
                    </li>
                    <li>
                      <a href="{{ url('economic_complement_procedure') }}">
                        <div class="menu">
                            <label class="control-sidebar-subheading"><i class="fa fa-calendar-check-o"> Intervalos de Fechas</i></label>
                        </div>
                      </a>
                    </li>
                    <li>
                        <a href="{{ url('complementary_factor') }}">
                            <div class="menu">
                                <label class="control-sidebar-subheading"><i class="fa fa-percent"> Factor de Complemantación</i></label>
                            </div>
                        </a>
                    </li>
                @endcan
                @can('retirement_fund')
                    <li>
                        <a href="{{ url('contribution_rate') }}">
                            <div class="menu">
                                <label class="control-sidebar-subheading"><i class="fa fa-line-chart"> Tasas de Aporte</i></label>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('ipc_rate') }}">
                            <div class="menu">
                                <label class="control-sidebar-subheading"><i class="fa fa-bar-chart-o"> Tasas de IPC</i></label>
                            </div>
                        </a>
                    </li>
                @endcan
                <li>
                  <a href="{{ url('base_wage') }}">
                    <div class="menu">
                        <label class="control-sidebar-subheading"><i class="fa fa-money"> Salario Básico</i></label>
                    </div>
                  </a>
                </li>
            </ul>
        </div>

        <div class="tab-pane" id="control-sidebar-reports-tab">
            
            <h4 class="control-sidebar-heading"><b>Reportes del Beneficio</b></h4>
            <ul class="control-sidebar-menu">
                @can('economic_complement')
                    <li>
                      <a href="{!! url('report_complement') !!}">
                        <div class="menu">
                            <label class="control-sidebar-subheading"><i class="fa fa-line-chart"> Parametrizada</i></label>
                        </div>
                      </a>
                    </li>
                    <li>
                        <a href="{!! url('get_updated_list') !!}">
                            <div class="menu">
                                <label class="control-sidebar-subheading"><i class="fa fa-pencil-square-o"> Modificaciones</i></label>
                            </div>
                        </a>
                    </li>
                @endcan
            </ul>
        </div>
    </div>
</aside>

<div class='control-sidebar-bg'></div>
