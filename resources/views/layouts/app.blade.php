<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdminTV</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendors/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.4/css/buttons.dataTables.min.css">

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body>
    <div id="app">
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <div class="d-flex justify-content-center">
                        <a href="{{ route('/') }}"><img src="{{ asset('assets/images/logo.png') }}" alt="Logo"
                                class="img-fluid" style="height: 6.5rem"></a>
                        <div class="toggler">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i
                                    class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-item  ">
                            <a href="{{ route('/') }}" class='sidebar-link'>
                                <i class="bi bi-graph-up"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        @if (auth()->user()->can('Ver Ver roles y permisos') ||
                                auth()->user()->can('Ver usuarios') ||
                                auth()->user()->can('Ver ventas') ||
                                auth()->user()->can('Ver anulaciones'))
                            <li class="sidebar-title">Administración</li>
                        @endif
                        @if (auth()->user()->can('Ver roles y permisos'))
                            <li class="sidebar-item  ">
                                <a href="{{ route('roles_permisos') }}" class='sidebar-link'>
                                    <i class="bi bi-gear-fill"></i>
                                    <span>Roles y permisos</span>
                                </a>
                            </li>
                        @endif

                        @if (auth()->user()->can('Ver usuarios'))
                            <li class="sidebar-item">
                                <a href="{{ route('usuarios') }}" class='sidebar-link'>
                                    <i class="bi bi-person-fill"></i>
                                    <span>Usuarios</span>
                                </a>
                            </li>
                        @endif

                        @if (auth()->user()->can('Ver ventas'))
                            <li class="sidebar-item">
                                <a href="{{ route('ventas') }}" class='sidebar-link'>
                                    <i class="bi bi-clipboard-data"></i>
                                    <span>Ventas</span>
                                </a>
                            </li>
                        @endif

                        @if (auth()->user()->can('Ver anulaciones'))
                            <li class="sidebar-item">
                                <a href="{{ route('anulaciones') }}" class='sidebar-link'>
                                    <i class="bi bi-x-circle"></i>
                                    <span>Anulaciones</span>
                                </a>
                            </li>
                        @endif

                        @if (auth()->user()->can('Ver tarifas') ||
                                auth()->user()->can('Ver aplicaciones') ||
                                auth()->user()->can('Ver dispositivos') ||
                                auth()->user()->can('Ver pasarelas'))
                            <li class="sidebar-title">Parametrizar</li>
                        @endif

                        @if (auth()->user()->can('Ver tarifas'))
                            <li class="sidebar-item">
                                <a href="{{ route('tarifas') }}" class='sidebar-link'>
                                    <i class="bi bi-receipt"></i>
                                    <span>Tarifas</span>
                                </a>
                            </li>
                        @endif

                        @if (auth()->user()->can('Ver aplicaciones'))
                            <li class="sidebar-item">
                                <a href="{{ route('aplicaciones') }}" class='sidebar-link'>
                                    <i class="bi bi-app-indicator"></i>
                                    <span>Aplicaciones</span>
                                </a>
                            </li>
                        @endif

                        @if (auth()->user()->can('Ver dispositivos'))
                            <li class="sidebar-item">
                                <a href="{{ route('dispositivos') }}" class='sidebar-link'>
                                    <i class="bi bi-display"></i>
                                    <span>Dispositivos</span>
                                </a>
                            </li>
                        @endif

                        @if (auth()->user()->can('Ver pasarelas'))
                            <li class="sidebar-item  ">
                                <a href="{{ route('pasarelas') }}" class='sidebar-link'>
                                    <i class="bi bi-cash"></i>
                                    <span>Pasarelas</span>
                                </a>
                            </li>
                        @endif

                        <li class="sidebar-title">Gestión</li>

                        <li class="sidebar-item  ">
                            <a href="{{ route('clientes') }}" class='sidebar-link'>
                                <i class="bi bi-person-lines-fill"></i>
                                <span>Clientes</span>
                            </a>
                        </li>

                        {{-- li to logout --}}
                        <li class="sidebar-item  ">
                            <a href="{{ route('logout') }}" class='sidebar-link'
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Salir</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </div>
                <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
            </div>
        </div>
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/chartjs/Chart.min.js') }}"></script>
    @yield('scripts')
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>

</html>
