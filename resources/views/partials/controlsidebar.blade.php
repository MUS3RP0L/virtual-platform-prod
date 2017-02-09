<aside class="control-sidebar control-sidebar-dark">

    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
        <li class="active"><a href="#control-sidebar-settings-tab" data-toggle="tab">Configuración</a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane" id="control-sidebar-settings-tab">
            <form method="post">
              <h3 class="control-sidebar-heading">General Settings</h3>

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Report panel usage
                  <input type="checkbox" class="pull-right" checked>
                </label>

                <p>
                  Some information about this general settings option
                </p>
              </div>
              <!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Allow mail redirect
                  <input type="checkbox" class="pull-right" checked>
                </label>

                <p>
                  Other sets of options are available
                </p>
              </div>
              <!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Expose author name in posts
                  <input type="checkbox" class="pull-right" checked>
                </label>

                <p>
                  Allow the user to show his name in blog posts
                </p>
              </div>
              <!-- /.form-group -->

              <h3 class="control-sidebar-heading">Chat Settings</h3>

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Show me as online
                  <input type="checkbox" class="pull-right" checked>
                </label>
              </div>
              <!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Turn off notifications
                  <input type="checkbox" class="pull-right">
                </label>
              </div>
              <!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Delete chat history
                  <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                </label>
              </div>
              <!-- /.form-group -->
            </form>
        </div>
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
    </div>
</aside>

<div class='control-sidebar-bg'></div>
