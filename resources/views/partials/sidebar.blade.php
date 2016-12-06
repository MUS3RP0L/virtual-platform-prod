<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- search form (Optional) -->
        {{-- <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Buscar Afiliado..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form> --}}
        <!-- /.search form -->

        <ul class="sidebar-menu">
            <li class="header">MENÚ</li>
            <li {!! (Request::is('home') ? 'class=active' : '') !!}>
            <a href="{!! url('home') !!}"><i class='fa fa-tachometer'></i> <span>Inicio</span></a>
            </li>

            <li {!! (Request::is('affiliate') ? 'class=active' : '') !!}>
            <a href="{!! url('affiliate') !!}"><i class='glyphicon glyphicon-user'></i> <span>Afiliados</span></a>
            </li>

            <li class="treeview">
                <a href="#"><i class='fa fa-link'></i> <span>Multilevel</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="#">Link in level 2</a></li>
                    <li><a href="#">Link in level 2</a></li>
                </ul>
            </li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
