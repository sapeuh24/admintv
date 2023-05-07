@extends('layouts.app')
@section('content')
    <div id="main">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Clientes</h3>
                        <p class="text-subtitle text-muted">Administración de clientes</p>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('/') }}">Inicio</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Clientes</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        Clientes
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            @if (auth()->user()->hasPermissionTo('Crear cliente'))
                                <button class="btn btn-primary me-md-2" type="button" data-bs-toggle="modal"
                                    data-bs-target="#modal_crear_cliente">Agregar</button>
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
                        <table class="table" id="tableclientes">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Fecha creación</th>
                                    <th>Teléfono</th>
                                    <th>Email</th>
                                    <th>Notas</th>
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

    <div class="modal fade" tabindex="-1" id="modal_cliente">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Actualizar cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" id="form_actualizar_cliente" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" class="form-control" id="nombre_editar" name="nombre"
                                        placeholder="Nombre del cliente" autocomplete="nope" required>
                                </div>

                                <div class="form-group">
                                    <label for="telefono">Teléfono</label>
                                    <input type="number" class="form-control" id="telefono_editar" name="telefono"
                                        placeholder="Teléfono solo números" autocomplete="nope">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="facebook_enlace">Facebook</label>
                                    <input type="text" class="form-control" id="facebook_enlace_editar"
                                        name="facebook_enlace" placeholder="Enlace de perfil de facebook"
                                        autocomplete="nope">
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" id="email_editar" name="email"
                                        placeholder="Correo electrónico del cliente" autocomplete="nope">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="ciudad">Ciudad</label>
                                    <select class="form-select" id="ciudad_editar" name="id_ciudad">
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="notas">Notas</label>
                                    <textarea id="notas_editar" name="notas" class="form-control"></textarea>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button onclick="actualizarCliente()" type="button" class="btn btn-primary">Actualizar</button>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" tabindex="-1" id="modal_crear_cliente">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crear cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('crear_cliente') }}" id="form_crear_cliente" method="POST">
                        @method('POST')
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre"
                                        placeholder="Nombre del cliente" autocomplete="nope" required>
                                </div>

                                <div class="form-group">
                                    <label for="telefono">Teléfono</label>
                                    <input type="number" class="form-control" id="telefono" name="telefono"
                                        placeholder="Teléfono solo números" autocomplete="nope">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="facebook_enlace">Facebook</label>
                                    <input type="text" class="form-control" id="facebook_enlace"
                                        name="facebook_enlace" placeholder="Enlace de perfil de facebook"
                                        autocomplete="nope">
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" id="email" name="email"
                                        placeholder="Correo electrónico del cliente" autocomplete="nope">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="ciudad">Ciudad</label>
                                    <select class="form-select" id="ciudad" name="id_ciudad">

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="notas">Notas</label>
                                    <textarea id="notas" name="notas" class="form-control"></textarea>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button onclick="crearCliente()" type="button" class="btn btn-primary">Crear</button>
                </div>
            </div>
        </div>
    </div>

    <form id="formDeleteCliente" action="" method="POST" style="display: none">
        @csrf
        @method('DELETE')
    </form>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            function consultarCiudades() {
                $.ajax({
                    url: "{{ url('admin/consultar_ciudades') }}",
                    type: "GET",
                    success: function(response) {
                        response.forEach(ciudad => {
                            $('#ciudad').append(
                                `<option value="${ciudad.id}">${ciudad.ciudad}</option>`);
                        });
                    }
                })
            }
            consultarCiudades();
            $('#tableclientes').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('obtener_clientes') }}",
                columns: [{
                        data: 'nombre',
                        name: 'nombre'
                    },
                    {
                        data: 'fecha_creacion',
                        name: 'fecha_creacion'
                    },
                    {
                        data: 'telefono',
                        name: 'telefono'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'notas',
                        name: 'notas'
                    },
                    {
                        data: null,
                        default: 'null',
                        render: function(data, type, row) {
                            return '<div class="btn-group" role="group" aria-label="Basic example">' +
                                '<?php if (Auth::user()->can('Actualizar cliente')) { ?>' +
                                '<button type="button" class="btn btn-primary btn-sm" onclick="consultarCliente(' +
                                data.id + ')">Editar</button>' +
                                '<?php } ?>' +
                                '<?php if (Auth::user()->can('Ver servicios')) { ?>' +
                                '<a href={{ route('ver_servicios_cliente', '') }}' + '/' + data
                                .slug +
                                ' type="button" class="btn btn-primary btn-sm">Servicios</a>' +
                                '<?php } ?>' +
                                '<?php if (Auth::user()->can('Eliminar cliente')) { ?>' +
                                '<button type="button" class="btn btn-danger btn-sm" onclick="eliminarCliente(' +
                                data.id + ')">Eliminar</button>' +
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
        });

        function consultarCliente(id) {
            $('#form_actualizar_cliente').attr('action', 'actualizar_cliente/' + id);
            $('#modal_cliente').modal('show');
            event.preventDefault();
            $.ajax({
                url: "{{ url('admin/consultar_cliente') }}" + '/' + id,
                type: "GET",
                success: function(response) {
                    console.log(response);
                    $('#nombre_editar').val(response.nombre);
                    $('#telefono_editar').val(response.telefono);
                    $('#facebook_enlace_editar').val(response.facebook_enlace);
                    $('#email_editar').val(response.email);
                    $.ajax({
                        url: "{{ url('admin/consultar_ciudades') }}",
                        type: "GET",
                        success: function(data) {
                            data.forEach(ciudad => {
                                $('#ciudad_editar').append(
                                    `<option value="${ciudad.id}">${ciudad.ciudad}</option>`
                                );
                            });
                        }
                    })
                    $("#ciudad_editar option:selected").removeAttr("selected");
                    $('#ciudad_editar').val(response.id_ciudad).change();
                    $('#notas_editar').val(response.notas);
                }
            })
        }

        function consultarServiciosCliente(slug) {
            event.preventDefault();
            $.ajax({
                url: "{{ url('admin/ver_servicios_cliente') }}" + '/' + slug,
                type: "GET",
                success: function(response) {
                    console.log('ok');
                }
            })
        }

        function actualizarCliente() {
            event.preventDefault();
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡Los datos se guardaran!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1266b1',
                cancelButtonColor: '#f44335',
                confirmButtonText: 'Sí, editar!'
            }).then((result) => {
                if (result.isConfirmed) {
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
                            $('#form_actualizar_cliente').submit();
                        })
                    });
                }
            })
        };

        function eliminarCliente(id) {
            $('#formDeleteCliente').attr('action', 'eliminar_cliente/' + id);
            event.preventDefault();
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡Los datos se eliminaran!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1266b1',
                cancelButtonColor: '#f44335',
                confirmButtonText: 'Sí, eliminar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    setTimeout(function() {
                        let timerInterval;
                        Swal.fire({
                            title: 'Eliminando',
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
                            $('#formDeleteCliente').submit();
                        })
                    });
                }
            })
        };

        function crearCliente() {
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
                    $('#form_crear_cliente').submit();
                }
            })
            $('#form_crear_cliente').validate({
                rules: {
                    tarifa: {
                        required: true,
                    },
                    precio: {
                        required: true,
                    },
                    creditos: {
                        required: true,
                    },
                    comision: {
                        required: true,
                    },
                },
                messages: {
                    tarifa: {
                        required: "Por favor ingrese una tarifa",
                    },
                    precio: {
                        required: "Por favor ingrese un precio"
                    },
                    creditos: {
                        required: "Por favor ingrese los creditos",
                    },
                    comision: {
                        required: "Por favor ingrese la comisión"
                    }

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
    </script>
@endsection
