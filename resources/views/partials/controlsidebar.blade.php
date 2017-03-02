<aside class="control-sidebar control-sidebar-dark">

    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li active><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
        <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="control-sidebar-home-tab">
            <ul class='control-sidebar-menu'>
                <li>
                  <a href="{{ url('user') }}">
                    <div class="menu" style="font-size:16px;font-weight:400;color:#fff;">
                    Usuarios
                    </div>
                  </a>
                </li>
                <li>
                  <a href="{{ url('contribution_rate') }}">
                    <div class="menu" style="font-size:16px;font-weight:400;color:#fff;">
                    Tasa Aporte
                    </div>
                  </a>
                </li>
                <li>
                  <a href="{{ url('ipc_rate') }}">
                    <div class="menu" style="font-size:16px;font-weight:400;color:#fff;">
                    Tasa IPC
                    </div>
                  </a>
                </li>
                <li>
                  <a href="{{ url('base_wage') }}">
                    <div class="menu" style="font-size:16px;font-weight:400;color:#fff;">
                    Salario Básico
                    </div>
                  </a>
                </li>
                <li>
                  <a href="{{ url('complementary_factor') }}">
                    <div class="menu" style="font-size:16px;font-weight:400;color:#fff;">
                    Factor de Complemantación
                    </div>
                  </a>
                </li>
            </ul>
        </div>

        <div class="tab-pane" id="control-sidebar-settings-tab">
            <div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel-group" id="accordion">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"><span class="glyphicon glyphicon-th">
                                            </span> Reportes Logs</a>
                                        </h4>
                                    </div>
                                    <div id="collapseTwo" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <table class="table">
                                                <tr>
                                                    <td>
                                                        <span class="glyphicon glyphicon-user"></span><a href="{!! url('print_activity/'."1") !!}"> Diario</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span class="glyphicon glyphicon-user"></span><a href="{!! url('activity') !!}"> Rango de Fechas</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span class="glyphicon glyphicon-tasks"></span><a href="{!! url('print_activity/'."2") !!}"> General</a>
                                                    </td>
                                                </tr>

                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo1"><span class="glyphicon glyphicon-list">
                                            </span> Reportes Complemento</a>
                                        </h4>
                                    </div>
                                    <div id="collapseTwo1" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <table class="table">
                                                <tr>
                                                    <td>
                                                        <span class="glyphicon glyphicon-print"></span><a href="{!! url('index_report_generator') !!}"> Parametrizada</a>
                                                    </td>
                                                </tr>

                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</aside>

<div class='control-sidebar-bg'></div>
