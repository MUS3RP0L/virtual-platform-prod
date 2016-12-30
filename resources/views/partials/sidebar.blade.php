<aside class="main-sidebar">

    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="header">MENÚ</li>
            <li {!! (Request::is('home') ? 'class=active' : '') !!}>
            <a href="{!! url('home') !!}"><i class='fa fa-tachometer'></i> <span>Inicio</span></a>
            </li>

            <li {!! (Request::is('affiliate') ? 'class=active' : '') !!}>
            <a href="{!! url('affiliate') !!}"><i class='glyphicon glyphicon-user'></i> <span>Afiliados</span></a>
            </li>

            <li {!! (Request::is('direct_contribution') ? 'class=active' : '') !!}>
            <a href="{!! url('direct_contribution') !!}"><i class='glyphicon glyphicon-list-alt'></i> <span>Aportes Directos</span></a>
            </li>

            <li {!! (Request::is('voucher') ? 'class=active' : '') !!}>
            <a href="{!! url('voucher') !!}"><i class="fa fa-fw fa-money"></i> <span>Cobros</span></a>
            </li>

            <li {!! (Request::is('economic_complement') ? 'class=active' : '') !!}>
            <a href="{!! url('economic_complement') !!}"><i class="fa fa-fw fa-ticket"></i> <span>Complemento Económico</span></a>
            </li>

            <!-- <li class="treeview">
                <a href="#"><i class='fa fa-link'></i> <span>Multilevel</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="#">Link in level 2</a></li>
                    <li><a href="#">Link in level 2</a></li>
                </ul>
            </li> -->
        </ul>
    </section>

</aside>
