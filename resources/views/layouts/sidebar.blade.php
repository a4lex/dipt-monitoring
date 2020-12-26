
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="http://unresolved.donbass.net/public/favicon.ico" alt="just for fun" class="brand-image img-square elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">just for fun <b>4lex</b></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
    {{--        <div class="user-panel mt-3 pb-3 mb-3 d-flex">--}}
    {{--            <div class="image">--}}
    {{--                <img src="{{ asset('img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">--}}
    {{--            </div>--}}
    {{--            <div class="info">--}}
    {{--                <a href="#" class="d-block">Alexander Pierce</a>--}}
    {{--            </div>--}}
    {{--        </div>--}}

    <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-compact nav-flat nav-legacy nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item has-treeview menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/users') }}" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Users </p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/roles') }}" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Roles </p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/domains') }}" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Domains </p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/snmp_templates') }}" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p> SNMP Templates </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            MikroTiks
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/mt_boards') }}" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Boards </p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/mt_ifaces') }}" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Wireless Ifaces </p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/mt_links') }}" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Wireless Links </p>
                            </a>
                        </li>
                    </ul>

                </li>
                <li class="nav-header">EXAMPLES</li>
                <li class="nav-item">
                    <a href="pages/calendar.html" class="nav-link">
                        <i class="nav-icon far fa-calendar-alt"></i>
                        <p>
                            Calendar
                            <span class="badge badge-info right">2</span>
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-circle text-info"></i>
                        <p>Informational</p>
                    </a>
                </li>
                <li class="nav-item has-treeview menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Represent Configurations
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/models') }}" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Models </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/columns') }}" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Columns </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/joins') }}" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Joins </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/wheres') }}" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Wheres </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/column_options') }}" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Column Options </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/column_types') }}" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Column Types </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/actions') }}" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Actions </p>
                            </a>
                        </li>
                    </ul>

                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
