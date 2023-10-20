@extends('layouts.app')
@section('content')
    <div id="main">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Servicios del cliente: {{ $cliente->nombre }}</h3>
                        <p class="text-subtitle text-muted">Administración de servicios</p>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('/') }}">Inicio</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Servicios</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        Servicios
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            @if (auth()->user()->hasPermissionTo('Crear servicio'))
                                <button class="btn btn-primary me-md-2" type="button" data-bs-toggle="modal"
                                    data-bs-target="#modal_crear_servicio">Agregar</button>
                            @endif
                        </div>
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
                        <table class="table" id="tableservicios">
                            <thead>
                                <tr>
                                    <th>Tarifa</th>
                                    <th>Fecha creación</th>
                                    <th>Creditos restantes</th>
                                    <th>Aplicaciones</th>
                                    <th>Dispositivos</th>
                                    <th>Estado</th>
                                    <th>Estado pago</th>
                                    <th>Acciones</th>
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

    <div class="modal fade" tabindex="-1" id="modal_activaciones">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Gestionar activaciones</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" id="form_actualizar_servicio" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="creditos">Creditos</label>
                                    <input type="text" class="form-control" id="creditos_activar" name="creditos"
                                        autocomplete="nope" required>
                                    <input type="hidden" name="id_servicio" id="id_servicio">
                                </div>
                                <div class="form-group">
                                    <button onclick="realizarActivacion()" type="button"
                                        class="btn btn-primary mt-3">Activar</button>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="fecha_creacion"></label>
                                    <input type="date" class="form-control" id="fecha_creacion" name="fecha_creacion"
                                        autocomplete="nope" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table" id="tableactivaciones">
                                    <thead>
                                        <tr>
                                            <th>Fecha inicio</th>
                                            <th>Fecha fin</th>
                                            <th>Creditos</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" tabindex="-1" id="modal_crear_servicio">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crear servicio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('crear_servicio') }}" id="form_crear_servicio" method="POST">
                        @method('POST')
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="tarifas">Tarifa</label>
                                    <select onchange="consultarTarifa(this.value)" class="form-select" name="id_tarifa"
                                        id="tarifas" required>
                                        <option value="#">Seleccione una opción</option>

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="precio">Precio</label>
                                    <input type="number" class="form-control" id="precio" name="precio"
                                        autocomplete="nope" readonly>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="creditos">Creditos</label>
                                    <input type="number" class="form-control" id="creditos" name="creditos"
                                        autocomplete="nope" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="pasarela">Pasarela</label>
                                    <select class="form-select" name="id_pasarela" id="pasarela" required>
                                        <option value="#">Seleccione una opción</option>

                                    </select>
                                </div>
                                <input type="hidden" value="{{ $cliente->id }}" name="id_cliente">
                            </div>
                        </div>
                        <div class="row">
                            @if (auth()->user()->hasRole('Administrador'))
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="vendedor">Vendedor</label>
                                        <select class="form-control" name="vendedor" id="vendedor">

                                        </select>
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_creacion">Fecha venta</label>
                                    <input type="date" class="form-control" name="fecha_creacion" id="fecha_creacion"
                                        required>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="aplicaciones">Aplicaciones</label>
                                    <select class="form-select" name="aplicaciones[]" id="aplicaciones" multiple
                                        required>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dispositivos">Dispositivos</label>
                                    <select class="form-select" name="dispositivos[]" id="dispositivos" multiple
                                        required>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button onclick="crearServicio()" type="button" class="btn btn-primary">Crear</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="modal_abonos">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Abonos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                </h5>
                <form action="{{ route('cargar_abono') }}" id="form_cargar_abono" method="POST">
                    <div class="modal-body">
                        @method('POST')
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="abono">Abono</label>
                                    <input type="text" class="form-control" id="abono" name="abono"
                                        autocomplete="nope" required>
                                </div>
                            </div>
                        </div>
                        <hr>
                        {{-- listado de abonos --}}
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table" id="tableabonos">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Hora</th>
                                            <th>Abono</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tdoby_abonos">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id_servicio" id="id_servicio_abonar">
                    <div class="modal-footer">
                        <button type="button" onclick="actualizarEstadoAbonos()" class="btn btn-success">Cambiar
                            estado</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Cargar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="modal_anular_servicio">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Anular servicio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('anular_servicio') }}" id="form_anular_servicio" method="POST">
                        @method('POST')
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="descripcion">Descripción</label>
                                    <textarea class="form-control" placeholder="Describa brevemente el motivo de la cancelación" name="descripcion"
                                        id="descripcion" cols="30" rows="4"></textarea>
                                </div>
                                <input type="hidden" name="id_servicio_anular" id="id_servicio_anular">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button onclick="completarAnulacion()" type="button" class="btn btn-danger">Anular</button>
                </div>
            </div>
        </div>
    </div>


    <form id="formDeleteTarifa" action="" method="POST" style="display: none">
        @csrf
        @method('DELETE')
    </form>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            obtener_usuarios_vendedores();
            $('#tableservicios').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('obtener_servicios', $cliente->id) }}",
                columns: [{
                        data: 'tarifa.tarifa',
                        name: 'tarifa.tarifa'
                    },
                    {
                        data: 'fecha_creacion',
                        name: 'fecha_creacion'
                    },
                    {
                        data: 'creditos_restantes',
                        name: 'creditos_restantes'
                    },
                    {
                        data: null,
                        default: 'null',
                        render: function(data, type, row) {
                            return data.aplicaciones.map(function(aplicacion) {
                                return '<li>' + aplicacion.nombre + '</li>';
                            }).join('');
                        }
                    },
                    {
                        data: null,
                        default: 'null',
                        render: function(data, type, row) {
                            return data.dispositivos.map(function(dispositivo) {
                                return '<li>' + dispositivo.nombre + '</li>';
                            }).join('');
                        }
                    },
                    {
                        data: 'estado',
                        name: 'estado'
                    },
                    {
                        data: null,
                        default: 'null',
                        render: function(data, type, row) {
                            return data.estado_abono == null ? 'No disponible' : data
                                .estado_abono.estado_abono;
                        }
                    },

                    {
                        data: null,
                        default: 'null',
                        render: function(data, type, row) {
                            return '<div class="btn-group" role="group" aria-label="Basic example">' +
                                '<?php if (Auth::user()->can('Gestionar activaciones')) { ?>' +
                                '<button type="button" class="btn btn-primary btn-sm" onclick="gestionarActivaciones(' +
                                data.id + ')">Activaciones</button>' +
                                '<?php } ?>' +
                                '<?php if (Auth::user()->can('Anular servicio')) { ?>' +
                                '<button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal_anular_servicio" onclick="anularServicio(' +
                                data.id + ')">Anular</button>' +
                                '<?php } ?>' +
                                '<?php if (Auth::user()->can('Gestionar activaciones')) { ?>' +
                                '<button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modal_abonos" onclick="abonarServicio(' +
                                data.id + ')">Abonos</button>' +
                                '<?php } ?>' +
                                '</div>';
                        }
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

            function obtenerTarifasJson() {
                $.ajax({
                    url: "{{ url('admin/obtener_tarifas_json') }}",
                    type: "GET",
                    success: function(response) {
                        response.forEach(tarifa => {
                            $('#tarifas').append(
                                `<option value="${tarifa.id}">${tarifa.tarifa}</option>`
                            );
                        });
                    }
                })
            }
            obtenerTarifasJson();

            function obtenerPasarelasJSON() {
                $.ajax({
                    url: "{{ url('admin/obtener_pasarelas_json') }}",
                    type: "GET",
                    success: function(response) {
                        response.forEach(pasarela => {
                            $('#pasarela').append(
                                `<option value="${pasarela.id}">${pasarela.nombre}</option>`
                            );
                        });
                    }
                })
            }
            obtenerPasarelasJSON();

            function obtenerAplicacionesJSON() {
                $.ajax({
                    url: "{{ url('admin/obtener_aplicaciones_json') }}",
                    type: "GET",
                    success: function(response) {
                        response.forEach(aplicaciones => {
                            $('#aplicaciones').append(
                                `<option value="${aplicaciones.id}">${aplicaciones.nombre}</option>`
                            );
                        });
                    }
                })
            }
            obtenerAplicacionesJSON();

            function obtenerDispositivosJSON() {
                $.ajax({
                    url: "{{ url('admin/obtener_dispositivos_json') }}",
                    type: "GET",
                    success: function(response) {
                        response.forEach(dispositivos => {
                            $('#dispositivos').append(
                                `<option value="${dispositivos.id}">${dispositivos.nombre}</option>`
                            );
                        });
                    }
                })
            }
            obtenerDispositivosJSON();
        });

        function consultarTarifa(id) {
            $.ajax({
                url: "{{ url('admin/consultar_tarifa') }}" + '/' + id,
                type: "GET",
                success: function(response) {
                    $('#tarifa').val(response.tarifa);
                    $('#precio').val(response.precio);
                    $('#creditos').val(response.creditos);
                }
            })
        }

        function obtener_usuarios_vendedores() {
            $.ajax({
                url: "{{ route('obtener_usuarios_vendedores') }}",
                type: "GET",
                success: function(data) {
                    console.log(data);
                    $('#vendedor').empty();
                    $('#vendedor').append('<option value="">Todos</option>');
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

        function crearServicio() {
            event.preventDefault();
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡Los datos se guardaran!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1266b1',
                cancelButtonColor: '#f44335',
                confirmButtonText: 'Sí, crear!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form_crear_servicio').submit();
                }
            })
            $('#form_crear_servicio').validate({
                rules: {
                    tarifa: {
                        required: true,
                    },
                },
                messages: {
                    tarifa: {
                        required: "Por favor seleccione una tarifa",
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
                submitHandler: function(form) {
                    setTimeout(function() {
                        let timerInterval;
                        Swal.fire({
                            title: 'Guardando',
                            html: 'Por favor espere...',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            timerProgressBar: true,
                            timer: 2000,
                            onBeforeOpen: () => {
                                Swal.showLoading()
                            },
                            willClose: () => {
                                clearInterval(timerInterval)
                            }
                        }).then((result) => {
                            form.submit();
                        })
                    });
                }
            });
        }

        function gestionarActivaciones(id) {
            $('#modal_activaciones').modal('show');
            $('#id_servicio').val(id);
            $('#tableactivaciones').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: "{{ url('admin/obtener_activaciones') }}" + '/' + id,
                columns: [{
                        data: 'fecha_inicio',
                        name: 'fecha_inicio'
                    },
                    {
                        data: 'fecha_fin',
                        name: 'fecha_fin'
                    },
                    {
                        data: 'creditos',
                        name: 'creditos'
                    },
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

        }

        function realizarActivacion() {
            var creditos = $('#creditos_activar').val();
            var fecha_creacion = $('#fecha_creacion').val();
            var id_servicio = $('#id_servicio').val();
            $.ajax({
                url: "{{ url('admin/realizar_activacion') }}",
                type: "POST",
                data: {
                    creditos: creditos,
                    fecha_creacion: fecha_creacion,
                    id_servicio: id_servicio,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    $('#modal_activaciones').modal('hide');
                    $('#tableservicios').DataTable().ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Activación realizada con éxito',
                        showConfirmButton: false,
                        timer: 2500
                    })
                },
                error: function(error) {
                    $('#modal_activaciones').modal('hide');
                    Swal.fire({
                        icon: 'error',
                        title: 'No tiene suficientes creditos',
                        showConfirmButton: false,
                        timer: 2500
                    })
                }
            })
        }

        function anularServicio(id) {
            $('#id_servicio_anular').val(id);
        }

        function completarAnulacion() {
            event.preventDefault();
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡El servicio se anulará!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1266b1',
                cancelButtonColor: '#f44335',
                confirmButtonText: 'Sí, anular!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form_anular_servicio').submit();
                }
            })
            $('#form_anular_servicio').validate({
                rules: {
                    descripcion: {
                        required: true,
                    },
                },
                messages: {
                    descripcion: {
                        required: "Por favor ingrese una descripción",
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
                submitHandler: function(form) {
                    setTimeout(function() {
                        let timerInterval;
                        Swal.fire({
                            title: 'Guardando',
                            html: 'Por favor espere...',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            timerProgressBar: true,
                            timer: 2000,
                            onBeforeOpen: () => {
                                Swal.showLoading()
                            },
                            willClose: () => {
                                clearInterval(timerInterval)
                            }
                        }).then((result) => {
                            form.submit();
                        })
                    });
                }
            });
        }

        function abonarServicio(id) {
            $('#id_servicio_abonar').val(id);
            $.ajax({
                url: "{{ url('admin/obtener_abonos_servicio') }}" + '/' + id,
                type: "GET",
                success: function(response) {
                    console.log(response);
                    $('#tdoby_abonos').empty();
                    response.forEach(element => {
                        $('#tableabonos').append('<tr><td>' + element.fecha + '</td><td>' + element
                            .hora + '</td><td>' + element.abono + '</td></tr>');
                        $('#estado').html(element.estado);
                    });
                },
                error: function(error) {
                    console.log(error);
                }
            })
        }

        function actualizarEstadoAbonos() {
            var id_servicio = $('#id_servicio_abonar').val();
            console.log(id_servicio);
            $.ajax({
                url: "{{ url('admin/actualizar_estado_abonos') }}" + '/' + id_servicio,
                type: "GET",
                success: function(response) {
                    console.log(response);
                    $('#tableservicios').DataTable().ajax.reload();
                    $('#modal_abonos').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Estado actualizado con éxito',
                        showConfirmButton: false,
                        timer: 2500
                    })
                },
                error: function(error) {
                    console.log(error);
                }
            })

        }
    </script>
@endsection
