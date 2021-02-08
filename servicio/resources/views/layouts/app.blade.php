<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name')}}</title>

    <!-- Scripts -->
    <!--<script src="{{ asset('js/app.js') }}"></script>-->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{asset('plugins/jqvmap/jqvmap.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.min.css')}}">
    <!-- jQuery -->
    <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <style>
        .scroll {
            overflow-y: scroll;
            max-height: 52vh;
        }

        /* Hide scrollbar for Chrome, Safari and Opera */
        .scroll::-webkit-scrollbar {
            width: 5px;
        }

        /* Hide scrollbar for IE, Edge and Firefox */
        .scroll {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }

        /* Track */
        .scroll::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        .scroll::-webkit-scrollbar-thumb {
            background: #888;
        }

        /* Handle on hover */
        .scroll::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div id="app">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            <!-- Search bar -->
            <input type="text" name="searchBar" list="modulos" id="searchBar" class="form-control" onkeyup="busquedaModulos()" placeholder="Busqueda de módulos">
            <datalist id="modulos">
            </datalist>
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">15</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">15 Notifications</span>
                        <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-envelope mr-2"></i> 4 new messages
                                <span class="float-right text-muted text-sm">3 mins</span>
                            </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdownUser" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownUser">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4" id="menu-izquierdo">
            <!-- Brand Logo -->
            <a class="brand-link" href="{{ url('/') }}">
                <img src="{{asset('storage/img/logo.png')}}" alt="AdminLTE Logo" class="brand-image " style="opacity: .8">
                <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                <img src="{{asset('dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
                </div>
                @guest
                @else
                <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                </div>
                @endif
            </div>


            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->

                <li class="nav-item">
                    <a href="{{route('home')}}" class="nav-link">
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                        Dashboard
                        <span class="right badge badge-danger">New</span>
                    </p>
                    </a>
                </li>
                <li class="nav-item" >
                    <a  href="{{route("Servicio.index")}}" class="nav-link" id="servicios">
                        <i class="nav-icon fas fa-user-md"></i>
                        <p>
                            Servicios
                            <span class="right badge badge-danger">New</span>
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-layer-group"></i>
                    <p>
                        Ventas
                        <i class="fas fa-angle-left right"></i>
                        <span class="badge badge-info right">12</span>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">

                    <li class="nav-item">
                        <a href="{{route("Venta.index")}}" class="nav-link" id="ventas">
                        <i class="fas fa-clipboard-list nav-icon"></i>
                        <p>Listado de Ventas</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route("Venta.create")}}" class="nav-link">
                        <i class="fas fa-plus nav-icon"></i>
                        <p>Realizar Venta</p>
                        </a>
                    </li>
                    </ul>
                </li>
                <li class="nav-item" >
                    <a  href="{{route("indexDatos")}}" class="nav-link" id="datos">
                    <i class="nav-icon fas fa-table"></i>
                    <p>
                        Datos
                        <span class="right badge badge-danger">New</span>
                    </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-layer-group"></i>
                    <p>
                        Extras
                        <i class="fas fa-angle-left right"></i>
                        <span class="badge badge-info right">1</span>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">

                    <li class="nav-item">
                        <a href="pages/layout/fixed-sidebar.html" class="nav-link">
                        <i class="fas fa-mobile nav-icon"></i>
                        <p>Recargas telefónicas</p>
                        </a>
                    </li>
                    </ul>
                </li>
                <li class="nav-header">Admin</li>
                <li class="nav-item">
                    <a href="{{route('Cliente.index')}}" class="nav-link">
                    <i class="nav-icon far fa-address-book"></i>
                    <p>
                        Clientes
                        <span class="badge badge-info right">5</span>
                    </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('Usuario.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                        Usuarios
                    </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-box-open"></i>
                    <p>
                        Inventarios
                        <i class="fas fa-angle-left right"></i>
                        <span class="badge badge-info right">6</span>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('Inventario.index')}}" class="nav-link">
                            <i class="fas fa-clipboard-list nav-icon"></i>
                            <p>Listado de Inventario</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route("Inventario.create")}}" class="nav-link">
                            <i class="fas fa-plus nav-icon"></i>
                            <p>Agregar/Editar Inventario</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('TipoInventario.index')}}" class="nav-link">
                            <i class="fas fa-thumbtack nav-icon"></i>
                            <p>Categorias</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('Inventario.index')}}" class="nav-link">
                            <i class="fas fa-tools nav-icon"></i>
                            <p>Refacciones</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{route('Sucursal.index')}}" class="nav-link">
                    <i class="nav-icon fas fa-store"></i>
                    <p>
                        Sucursales
                    </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-truck-loading"></i>
                    <p>
                        Proveedores
                    </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/calendar.html" class="nav-link">
                    <i class="nav-icon far fa-calendar-alt"></i>
                    <p>
                        Calendar
                        <span class="badge badge-info right">10</span>
                    </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/gallery.html" class="nav-link">
                    <i class="nav-icon far fa-user-circle"></i>
                    <p>
                        Perfil
                    </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-pager"></i>
                        <p>
                            Plantillas
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('plantillaGeneral')}}" class="nav-link">
                                <i class="fas fa-clipboard-list nav-icon"></i>
                                <p>Listado General</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route("agregarEditarConDetalle")}}" class="nav-link">
                                <i class="fas fa-plus nav-icon"></i>
                                <p>Agregar/Editar Con Detalle</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('agregarEditarSinDetalle')}}" class="nav-link">
                                <i class="fas fa-plus-circle nav-icon"></i>
                                <p>Agregar/Editar Sin Detalle</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-server"></i>
                    <p>
                        Configuración
                        <i class="fas fa-angle-left right"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="pages/layout/fixed-sidebar.html" class="nav-link">
                            <i class="fas fa-info-circle nav-icon"></i>
                            <p>Información</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('Configuracion.index')}}" class="nav-link">
                            <i class="fas fa-ad nav-icon"></i>
                            <p>Personalización</p>
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

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" >
            <main class="py-4">
                @yield('content', View::make('Inicio.dashboard'))
            </main>
        </div>
        <footer class="main-footer">
            <strong>Copyright &copy; 15-10-2020 <a href="https://lodesbloqueo.com">{{ config('app.name') }}</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 0.0.1
            </div>
        </footer>
    </div>

</body>
<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>

<!-- jQuery UI 1.11.4 -->
<script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.js')}}"></script>
<!--<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>-->
<!-- ChartJS -->
<script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{asset('plugins/sparklines/sparkline.js')}}"></script>
<!-- JQVMap -->
<script src="{{asset('plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{asset('plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('dist/js/demo.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('dist/js/pages/dashboard.js')}}"></script>
<script>
    $(document).ready(function(e){
        if($('body').hasClass('sidebar-collapse')){
            $('#searchBar').hide();
        }
        /*$('.search-panel .dropdown-menu').find('a').click(function(e) {
            e.preventDefault();
            var param = $(this).attr("href").replace("#","");
            var concept = $(this).html();
            $('.search-panel span#search_concept').html(concept);
            $('.input-group #search_param').val(param);
        });*/
    });

    function busquedaModulos() {
        // Declare variables
        var input, filter, menu, modulo, a, i, txtValue;
        input = document.getElementById("searchBar");
        filter = input.value.toUpperCase();
        menu = document.getElementById("menu-izquierdo");
        modulo = menu.getElementsByTagName("li");
        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < modulo.length; i++) {
            a = modulo[i].getElementsByTagName("a")[0];
            if (a) {
                txtValue = a.textContent || a.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    modulo[i].style.display = "";
                    console.log(modulo[i]);
                    $('#modulos').append('<option value="'+$(a).children('p').text()+'">');
                } else {
                    modulo[i].style.display = "none";
                    $('#modulos').children().remove();
                }
            }
        }
    }

</script>
</html>

