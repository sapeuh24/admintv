@extends('layouts.app')
@section('content')
    <div id="main">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Dispositivos</h3>
                        <p class="text-subtitle text-muted">Administración de dispositivos</p>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('/') }}">Inicio</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Dispositivos</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        Dispositivos
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            @if (auth()->user()->hasPermissionTo('Crear dispositivo'))
                                <button class="btn btn-primary me-md-2" type="button" data-bs-toggle="modal"
                                    data-bs-target="#modal_crear_dispositivo">Agregar</button>
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
                        <table class="table" id="tabledispositivos">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
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

    <div class="modal fade" tabindex="-1" id="modal_dispositivo">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Actualizar dispositivo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" id="form_actualizar_dispositivo" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="nombre_edit">Nombre</label>
                                    <input type="text" class="form-control" id="nombre_edit" name="nombre"
                                        placeholder="Nombre del dispositivo" autocomplete="nope" required>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button onclick="actualizarDispositivo()" type="button" class="btn btn-primary">Actualizar</button>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" tabindex="-1" id="modal_crear_dispositivo">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crear dispositivo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('crear_dispositivo') }}" id="form_crear_dispositivo" method="POST">
                        @method('POST')
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre"
                                        placeholder="Nombre del dispositivo" autocomplete="nope" required>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button onclick="crearDispositivo()" type="button" class="btn btn-primary">Crear</button>
                </div>
            </div>
        </div>
    </div>

    <form id="formDeleteDispositivo" action="" method="POST" style="display: none">
        @csrf
        @method('DELETE')

    </form>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#tabledispositivos').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('obtener_dispositivos') }}",
                columns: [{
                        data: 'nombre',
                        name: 'nombre'
                    },
                    {
                        data: null,
                        default: 'null',
                        render: function(data, type, row) {
                            return '<div class="btn-group" role="group" aria-label="Basic example">' +
                                '<?php if (Auth::user()->can('Actualizar dispositivo')) { ?>' +
                                '<button type="button" class="btn btn-primary btn-sm" onclick="consultarDispositivo(' +
                                data.id + ')">Editar</button>' +
                                '<?php } ?>' +
                                '<?php if (Auth::user()->can('Eliminar dispositivo')) { ?>' +
                                '<button type="button" class="btn btn-danger btn-sm" onclick="eliminarDispositivo(' +
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

        function consultarDispositivo(id) {
            $('#form_actualizar_dispositivo').attr('action', 'actualizar_dispositivo/' + id);
            $('#modal_dispositivo').modal('show');
            event.preventDefault();
            $.ajax({
                url: "{{ url('admin/consultar_dispositivo') }}" + '/' + id,
                type: "GET",
                success: function(response) {
                    $('#nombre_edit').val(response.nombre);
                }
            })
        }

        function actualizarDispositivo() {
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
                            $('#form_actualizar_dispositivo').submit();
                        })
                    });
                }
            })
        };

        function eliminarDispositivo(id) {
            $('#formDeleteDispositivo').attr('action', 'eliminar_dispositivo/' + id);
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
                            $('#formDeleteDispositivo').submit();
                        })
                    });
                }
            })
        };

        function crearDispositivo() {
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
                    $('#form_crear_dispositivo').submit();
                }
            })
            $('#form_crear_dispositivo').validate({
                rules: {
                    nombre: {
                        required: true,
                    },
                },
                messages: {
                    nombre: {
                        required: "Por favor ingrese un nombre",
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
    </script>
@endsection
