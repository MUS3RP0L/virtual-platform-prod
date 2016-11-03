<aside class="control-sidebar control-sidebar-dark">

    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab">Configuración</a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane active" id="control-sidebar-home-tab">
            <!-- <h3 class="control-sidebar-heading">Configuración</h3> -->
            <ul class='control-sidebar-menu'>
                <li>
                  <a href="{{ url('user') }}">
                    <div class="menu" style="font-size:16px;font-weight:400;color:#fff;">
                    <i class="fa fa-wrench"></i> Usuarios
                    </div>
                  </a>
                </li>
                <li>
                  <a href="{{ url('contribution_rate') }}">
                    <div class="menu" style="font-size:16px;font-weight:400;color:#fff;">
                    <i class="fa fa-wrench"></i> Tasa Aporte
                    </div>
                  </a>
                </li>
                <li>
                  <a href="{{ url('ipc_rate') }}">
                    <div class="menu" style="font-size:16px;font-weight:400;color:#fff;">
                    <i class="fa fa-wrench"></i> Tasa IPC
                    </div>
                  </a>
                </li>
                <li>
                  <a href="{{ url('base_wage') }}">
                    <div class="menu" style="font-size:16px;font-weight:400;color:#fff;">
                    <i class="fa fa-wrench"></i> Salario Básico
                    </div>
                  </a>
                </li>
                
            </ul><!-- /.control-sidebar-menu -->

        </div><!-- /.tab-pane -->
    </div>
</aside><!-- /.control-sidebar -->

<!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
<div class='control-sidebar-bg'></div>
