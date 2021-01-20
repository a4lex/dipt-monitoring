
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('img/4l-logo.jpg') }}" alt="just for fun" class="brand-image img-square elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">just for fun</span>
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
                <li class="nav-item has-treeview {{ (request()->is(['users*', 'roles*', 'domains*', 'snmp_templates*'])) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Configuration
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('users') }}" class="nav-link {{ (request()->is('users')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Users </p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('roles') }}" class="nav-link {{ (request()->is('roles')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Roles </p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('domains') }}" class="nav-link {{ (request()->is('domains')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Domains </p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('snmp_templates') }}" class="nav-link {{ (request()->is('snmp_templates')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p> SNMP Templates </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview {{ (request()->is(['devices*', 'device_ifaces*', 'device_types*', 'init_variables*', 'device_type_iface_types*'])) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Devices
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('device_types') }}" class="nav-link {{ (request()->is('device_types')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Device Types </p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('init_variables') }}" class="nav-link {{ (request()->is('init_variables')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Devices Initial Vars </p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('device_type_iface_types') }}" class="nav-link {{ (request()->is('device_type_iface_types')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Interface Types </p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('devices') }}" class="nav-link {{ (request()->is('devices')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Devices </p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('device_ifaces') }}" class="nav-link {{ (request()->is('device_ifaces')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Device Iterfaces </p>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="nav-item has-treeview {{ (request()->is(['mt_ifaces*', 'mt_links*'])) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            MikroTiks
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('mt_ifaces') }}" class="nav-link {{ (request()->is('mt_ifaces')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Wireless Ifaces </p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('mt_links') }}" class="nav-link {{ (request()->is('mt_links')) ? 'active' : '' }}">
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
                            <a href="{{ url('models') }}" class="nav-link {{ (request()->is('models')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Models </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('columns') }}" class="nav-link {{ (request()->is('columns')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Columns </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('joins') }}" class="nav-link {{ (request()->is('joins')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Joins </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('wheres') }}" class="nav-link {{ (request()->is('wheres')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Wheres </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('column_options') }}" class="nav-link {{ (request()->is('column_options')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Column Options </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('column_types') }}" class="nav-link {{ (request()->is('column_types')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Column Types </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('actions') }}" class="nav-link {{ (request()->is('v')) ? 'active' : '' }}">
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
