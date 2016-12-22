<aside class="control-sidebar control-sidebar-dark">

    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab">Configuración</a></li>
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
                  <a href="{{ url('complementarity_factor') }}">
                    <div class="menu" style="font-size:16px;font-weight:400;color:#fff;">
                    Factor de Complemantación
                    </div>
                  </a>
                </li>
            </ul>
        </div>
    </div>
</aside>

<div class='control-sidebar-bg'></div>
