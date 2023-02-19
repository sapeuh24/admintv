@extends('layouts.app')
@section('content')
    <div id="main">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Ventas</h3>
                        <p class="text-subtitle text-muted">Administración de ventas</p>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('/') }}">Inicio</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Ventas</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        Ventas
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="container">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li class="text-white">{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                @if (session()->has('success'))
                                    <div class="alert alert-success text-white">
                                        {{ session()->get('success') }}
                                    </div>
                                @endif
                                @if (session()->has('error'))
                                    <div class="alert alert-danger text-white">
                                        {{ session()->get('error') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <section>
                            {{-- Filtros para el datatable --}}
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="vendedor">Vendedor</label>
                                        <select class="form-control" name="vendedor[]" id="vendedor">

                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="pasarela">Pasarela</label>
                                        <select class="form-control" name="pasarela[]" id="pasarela">

                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="fecha_inicial">Fecha inicial</label>
                                        <input type="date" class="form-control" name="fecha_inicial" id="fecha_inicial">
                                    </div>

                                    <div class="form-group">
                                        <label for="fecha_final">Fecha final</label>
                                        <input type="date" class="form-control" name="fecha_final" id="fecha_final">
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <div class="col-sm-12">
                                        <button class="btn float-end btn-primary" onclick="refrescarConsulta()"
                                            id="btnfiltrar">Filtrar</button>
                                        <button class="btn mx-2 float-end btn-primary" onclick="limpiarCampos()"
                                            id="btnfiltrar">Limpiar</button>
                                    </div>
                                </div>
                            </div>



                        </section>
                        <table class="table" id="tableventas">
                            <thead>
                                <tr>
                                    <th>Vendedor</th>
                                    <th>Cliente</th>
                                    <th>Tarifa</th>
                                    <th>Fecha</th>
                                    <th>Pasarela</th>
                                    <th>Valor venta</th>
                                    <th>Comisión</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Vendedor</th>
                                    <th>Cliente</th>
                                    <th>Tarifa</th>
                                    <th>Fecha</th>
                                    <th>Pasarela</th>
                                    <th>Valor venta</th>
                                    <th>Comisión</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.datatables.net/buttons/2.3.4/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script>
        $(document).ready(function() {
            obtener_usuarios_vendedores();
            obtener_pasarelas();
            $('#tableventas').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excel'
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

        function refrescarConsulta() {
            $.ajax({
                url: "{{ route('reporte_servicios') }}",
                type: "GET",
                data: {
                    vendedor: $('#vendedor').val(),
                    pasarela: $('#pasarela').val(),
                    fecha_inicial: $('#fecha_inicial').val(),
                    fecha_final: $('#fecha_final').val(),
                },
                success: function(data) {
                    console.log(data);
                    $('#tableventas').DataTable().clear().destroy();
                    $('#tableventas').DataTable({
                        dom: 'Bfrtip',
                        buttons: [
                            'excel'
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
                        data: data.data,
                        //totalize valor_venta and comision
                        footerCallback: function(row, data, start, end, display) {
                            var api = this.api(),
                                data;

                            // Remove the formatting to get integer data for summation
                            var intVal = function(i) {
                                return typeof i === 'string' ?
                                    i.replace(/[\$,]/g, '') * 1 :
                                    typeof i === 'number' ?
                                    i : 0;
                            };

                            // Total over all pages
                            total = api
                                .column(5)
                                .data()
                                .reduce(function(a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);

                            // Total over this page
                            pageTotal = api
                                .column(5, {
                                    page: 'current'
                                })
                                .data()
                                .reduce(function(a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);

                            // Update footer
                            $(api.column(5).footer()).html(
                                '$' + pageTotal + ' ( $' + total + ' total)'
                            );

                            // Total over all pages
                            total = api
                                .column(6)
                                .data()
                                .reduce(function(a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);

                            // Total over this page
                            pageTotal = api
                                .column(6, {
                                    page: 'current'
                                })
                                .data()
                                .reduce(function(a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);

                            // Update footer
                            $(api.column(6).footer()).html(
                                '$' + pageTotal + ' ( $' + total + ' total)'
                            );
                        },
                        columns: [{
                                data: 'usuario.name',
                                name: 'usuario.name'
                            },
                            {
                                data: 'cliente.nombre',
                                name: 'cliente.nombre'
                            },
                            {
                                data: 'tarifa.tarifa',
                                name: 'tarifa.tarifa'
                            },
                            {
                                data: 'fecha_creacion',
                                name: 'fecha_creacion'
                            },
                            {
                                data: 'pasarela.nombre',
                                name: 'pasarela.nombre'
                            },
                            {
                                data: 'tarifa.precio',
                                name: 'tarifa.precio'
                            },
                            {
                                data: 'tarifa.comision',
                                name: 'tarifa.comision'
                            },
                        ]
                    });
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        function obtener_usuarios_vendedores() {
            $.ajax({
                url: "{{ route('obtener_usuarios_vendedores') }}",
                type: "GET",
                success: function(data) {
                    console.log(data);
                    $('#vendedor').empty();
                    $('#vendedor').append('<option value="all">Todos</option>');
                    $.each(data, function(i, item) {
                        $('#vendedor').append('<option value="' + item.id + '">' + item.name +
                            '</option>');
                    });
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        function obtener_pasarelas() {
            $.ajax({
                url: "{{ route('obtener_pasarelas_json') }}",
                type: "GET",
                success: function(data) {
                    console.log(data);
                    $('#pasarela').empty();
                    $('#pasarela').append('<option value="all">Todas</option>');
                    $.each(data, function(i, item) {
                        $('#pasarela').append('<option value="' + item.id + '">' + item.nombre +
                            '</option>');
                    });
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        function limpiarCampos() {
            $('#vendedor').val('all');
            $('#pasarela').val('all');
            $('#fecha_inicial').val('');
            $('#fecha_final').val('');
        }
    </script>
@endsection
