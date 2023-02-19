@extends('layouts.app')

@section('content')
    <div id="main">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Dashboard</h3>
                        <p class="text-subtitle text-muted">Vista de administrador</p>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('/') }}">Dashboard</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        Pasarelas
                    </div>
                    <div class="card-body">
                        <div class="row d-flex">
                            <div class="container d-flex">
                                <div class="col col-md-6">
                                    <h6 class="card-title text-center">Clientes nuevos</h6>
                                    <span id="current_year_bar"></span>
                                    <canvas id="barChartClientes"></canvas>
                                </div>
                                <div class="col col-md-6">
                                    <h6 class="card-title text-center">Ventas</h6>
                                    <span id="current_year_area"></span>
                                    <canvas id="barChartVentas"></canvas>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        Registro de acciones
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table_logs">
                                <thead>
                                    <tr>
                                        <th>Usuario</th>
                                        <th>Acción</th>
                                        <th>Tabla</th>
                                        <th>Fecha</th>
                                        <th>Registro</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
            </section>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        var route_clientes = "{{ route('reporte_clientes') }}";
        var route_ventas = "{{ route('reporte_ventas') }}";
    </script>
    <script src="{{ asset('js/chartjs.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#table_logs').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('reporte_acciones') }}",
                "columns": [{
                        data: 'user.name',
                        name: 'user.name'
                    },
                    {
                        data: 'accion',
                        name: 'accion'
                    },
                    {
                        data: 'tabla',
                        name: 'tabla'
                    },
                    {
                        data: 'fecha',
                        name: 'fecha'
                    },
                    {
                        data: 'registro_id',
                        name: 'registro_id'
                    }
                ],
                "language": {
                    "lengthMenu": "Mostrar _MENU_ registros por página",
                    "zeroRecords": "No se encontraron registros",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay registros disponibles",
                    "infoFiltered": "(filtrado de _MAX_ registros totales)",
                    "search": "Buscar:",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                },
            });
        });
    </script>
@endsection
