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
                            <label class="control-sidebar-subheading"><i class="fa fa-users"></i> Usuarios</label>
                        </div>
                      </a>
                    </li>
                @endcan
                @can('economic_complement')
                    <li>
                        <a href="{!! url('averages') !!}">
                            <div class="menu">
                                <label class="control-sidebar-subheading"><i class="glyphicon glyphicon-equalizer"></i> Promedios</label>
                            </div>
                        </a>
                    </li>
                    <li>
                      <a href="{{ url('economic_complement_procedure') }}">
                        <div class="menu">
                            <label class="control-sidebar-subheading"><i class="fa fa-calendar-check-o"></i> Intervalos de Fechas</label>
                        </div>
                      </a>
                    </li>
                    <li>
                        <a href="{{ url('complementary_factor') }}">
                            <div class="menu">
                                <label class="control-sidebar-subheading"><i class="fa fa-percent"></i> Factor de Complementación</label>
                            </div>
                        </a>
                    </li>
                @endcan
                @can('retirement_fund')
                    <li>
                        <a href="{{ url('contribution_rate') }}">
                            <div class="menu">
                                <label class="control-sidebar-subheading"><i class="fa fa-line-chart"></i> Tasas de Aporte</label>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('ipc_rate') }}">
                            <div class="menu">
                                <label class="control-sidebar-subheading"><i class="fa fa-bar-chart-o"></i> Tasas de IPC</label>
                            </div>
                        </a>
                    </li>
                @endcan
                <li>
                  <a href="{{ url('base_wage') }}">
                    <div class="menu">
                        <label class="control-sidebar-subheading"><i class="fa fa-money"></i> Salario Básico</label>
                    </div>
                  </a>
                </li>
            </ul>
        </div>

        <div class="tab-pane" id="control-sidebar-reports-tab">
            
            <h4 class="control-sidebar-heading"><b>Reportes del Beneficio</b></h4>
            <ul class="control-sidebar-menu">
                
                    <li>
                      <a href="{!! url('report_complement') !!}">
                        <div class="menu">
                            <label class="control-sidebar-subheading"><i class="fa fa-line-chart"></i> Parametrizada</label>
                        </div>
                      </a>
                    </li>
                    <li>
                        <a href="{!! url('get_updated_list') !!}">
                            <div class="menu">
                                <label class="control-sidebar-subheading"><i class="fa fa-pencil-square-o"></i> Modificaciones</label>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="{!! url('invalid_cell_phone') !!}">
                            <div class="menu">
                                <label class="control-sidebar-subheading"><i class="fa fa-phone"></i> Teléfonos incorrectos</label>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="{!! url('reports') !!}">
                            <div class="menu">
                                <label class="control-sidebar-subheading"><i class="fa fa-file"></i> Reportes</label>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="{!! url('afi_observations') !!}">
                            <div class="menu">
                                <label class="control-sidebar-subheading"><i class="fa fa-file"></i>Afiliados Observados</label>
                            </div>
                        </a>
                    </li>
             
            </ul>
        </div>
    </div>
</aside>

<div class='control-sidebar-bg'></div>
