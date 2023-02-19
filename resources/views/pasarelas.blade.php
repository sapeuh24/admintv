@extends('layouts.app')
@section('content')
    <div id="main">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Pasarelas de pago</h3>
                        <p class="text-subtitle text-muted">Administración de pasarelas de pago</p>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('/') }}">Inicio</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Aplicaciones</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        Pasarelas
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            @if (auth()->user()->hasPermissionTo('Crear pasarela'))
                                <button class="btn btn-primary me-md-2" type="button" data-bs-toggle="modal"
                                    data-bs-target="#modal_crear_pasarela">Agregar</button>
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
                        <table class="table" id="tablepasarelas">
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

    <div class="modal fade" tabindex="-1" id="modal_pasarela">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Actualizar pasarela</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" id="form_actualizar_pasarela" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="nombre_edit">Nombre</label>
                                    <input type="text" class="form-control" id="nombre_edit" name="nombre"
                                        placeholder="Nombre de la pasarela" autocomplete="nope" required>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button onclick="actualizarPasarela()" type="button" class="btn btn-primary">Actualizar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="modal_crear_pasarela">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crear pasarela</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('crear_pasarela') }}" id="form_crear_pasarela" method="POST">
                        @method('POST')
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre"
                                        placeholder="Nombre de la aplicación" autocomplete="nope" required>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button onclick="crearPasarela()" type="button" class="btn btn-primary">Crear</button>
                </div>
            </div>
        </div>
    </div>

    <form id="formDeletePasarela" action="" method="POST" style="display: none">
        @csrf
        @method('DELETE')

    </form>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#tablepasarelas').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('obtener_pasarelas') }}",
                columns: [{
                        data: 'nombre',
                        name: 'nombre'
                    },
                    {
                        data: null,
                        default: 'null',
                        render: function(data, type, row) {
                            return '<div class="btn-group" role="group" aria-label="Basic example">' +
                                '<?php if (Auth::user()->can('Actualizar pasarela')) { ?>' +
                                '<button type="button" class="btn btn-primary btn-sm" onclick="consultarPasarela(' +
                                data.id + ')">Editar</button>' +
                                '<?php } ?>' +
                                '<?php if (Auth::user()->can('Eliminar pasarela')) { ?>' +
                                '<button type="button" class="btn btn-danger btn-sm" onclick="eliminarPasarela(' +
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

        function consultarPasarela(id) {
            $('#form_actualizar_pasarela').attr('action', 'actualizar_pasarela/' + id);
            $('#modal_pasarela').modal('show');
            event.preventDefault();
            $.ajax({
                url: "{{ url('admin/consultar_pasarela') }}" + '/' + id,
                type: "GET",
                success: function(response) {
                    $('#nombre_edit').val(response.nombre);
                }
            })
        }

        function actualizarPasarela() {
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
                            $('#form_actualizar_pasarela').submit();
                        })
                    });
                }
            })
        };

        function eliminarPasarela(id) {
            $('#formDeletePasarela').attr('action', 'eliminar_pasarela/' + id);
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
                            $('#formDeletePasarela').submit();
                        })
                    });
                }
            })
        };

        function crearPasarela() {
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
                    $('#form_crear_pasarela').submit();
                }
            })
            $('#form_crear_pasarela').validate({
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
