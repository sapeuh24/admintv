@extends('layouts.app')
@section('content')
    <div id="main">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Usuarios</h3>
                        <p class="text-subtitle text-muted">Administración de usuarios del programa</p>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('/') }}">Inicio</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Usuarios</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        Usuarios
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            @if (auth()->user()->hasPermissionTo('Crear usuario'))
                                <button class="btn btn-primary me-md-2" type="button" data-bs-toggle="modal"
                                    data-bs-target="#modalCreateUsuario" onclick="obtenerRoles()">Agregar</button>
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
                        <table class="table" id="tableroles">
                            <thead>
                                <tr>
                                    <th>Usuario</th>
                                    <th>Email</th>
                                    <th>Rol</th>
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
    {{-- modal to see the rol and their permissions --}}
    <div class="modal fade" tabindex="-1" id="modal_usuario">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Actualizar usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" id="form_actualizar_usuario" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="nombre_editar" name="name"
                                placeholder="Nombre del usuario" autocomplete="nope">
                        </div>

                        <div class="form-group">
                            <label for="email">Correo</label>
                            <input type="text" class="form-control" id="email_editar" name="email"
                                placeholder="Correo electrónico del usuario" autocomplete="nope">
                        </div>


                        <div class="form-group">
                            <label for="rol">Rol</label>
                            <select class="form-select" id="rol_editar" name="rol">

                            </select>
                        </div>

                        <div class="form-group">
                            <label for="email">Contraseña</label>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" id="password_editar" name="password"
                                    placeholder="Contraseña del usuario" autocomplete="new-password">
                                <button class="btn" type="button" id="button-addon2" onclick="mostrarPassword()"><i
                                        class="bi bi-eye"></i></button>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button onclick="actualizarUsuario()" type="button" class="btn btn-primary">Actualizar</button>
                </div>
            </div>
        </div>
        <form id="formDeleteUser" action="" method="POST" style="display: none">
            @csrf
            @method('DELETE')
        </form>
    </div>

    {{-- modal to create a new user --}}

    <div class="modal fade" tabindex="-1" id="modalCreateUsuario">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crear usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('crear_usuario') }}" id="form_crear_usuario" method="POST">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="name"
                                placeholder="Nombre del usuario" autocomplete="nope">
                        </div>

                        <div class="form-group">
                            <label for="email">Correo</label>
                            <input type="text" class="form-control" id="email" name="email"
                                placeholder="Correo electrónico del usuario" autocomplete="nope">
                        </div>


                        <div class="form-group">
                            <label for="rol">Rol</label>
                            <select class="form-select" id="rol" name="rol">

                            </select>
                        </div>

                        <div class="form-group">
                            <label for="email">Contraseña</label>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Contraseña del usuario" autocomplete="new-password">
                                <button class="btn" type="button" id="button-addon2" onclick="mostrarPassword()"><i
                                        class="bi bi-eye"></i></button>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button onclick="crearUsuario()" type="button" class="btn btn-primary">Crear</button>
                </div>
            </div>
        </div>
        <form id="formDeleteUser" action="" method="POST" style="display: none">
            @csrf
            @method('DELETE')
        </form>
    </div>
@endsection
@section('scripts')
    <script>
        function mostrarPassword() {
            var tipo = document.getElementById("password") || document.getElementById("password_editar");
            if (tipo.type == "password") {
                tipo.type = "text";
            } else {
                tipo.type = "password";
            }
            var icon = document.getElementById("button-addon2");
            if (icon.innerHTML == '<i class="bi bi-eye"></i>') {
                icon.innerHTML = '<i class="bi bi-eye-slash"></i>';
            } else {
                icon.innerHTML = '<i class="bi bi-eye"></i>';
            }
        }
        $(document).ready(function() {
            $('#tableroles').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('obtener_usuarios') }}",
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'roles.0.name',
                        name: 'roles.0.name'
                    },
                    {
                        data: null,
                        default: 'null',
                        render: function(data, type, row) {
                            return '<div class="btn-group" role="group" aria-label="Basic example">' +
                                '<?php if (Auth::user()->can('Actualizar usuario')) { ?>' +
                                '<button type="button" class="btn btn-primary btn-sm" onclick="consultarUsuario(' +
                                data.id + ')">Editar</button>' +
                                '<?php } ?>' +
                                '<?php if (Auth::user()->can('Eliminar usuario')) { ?>' +
                                '<button type="button" class="btn btn-danger btn-sm" onclick="eliminarUsuario(' +
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

        function consultarUsuario(id) {
            $('#form_actualizar_usuario').attr('action', 'actualizar_usuario/' + id);
            $('#modal_usuario').modal('show');
            event.preventDefault();
            $.ajax({
                url: "{{ url('admin/consultar_usuario') }}" + '/' + id,
                type: "GET",
                success: function(response) {
                    $('#nombre_editar').val(response.usuario.name);
                    $('#email_editar').val(response.usuario.email);
                    $('#rol_editar').empty();
                    $('#rol_editar').append(`<option value="0">Seleccione un rol</option>`);
                    response.roles.forEach(rol => {
                        $('#rol_editar').append(`<option value="${rol.id}">${rol.name}</option>`);
                    });
                    $("#rol_editar option:selected").removeAttr("selected");
                    $('#rol_editar').val(response.usuario.roles[0].id).change();
                    //form auutocomplete off
                    $('#form_actualizar_usuario').attr('autocomplete', 'off');
                    $('#form_actualizar_usuario').removeAttr('autocomplete');
                    let permisos_rol = response.rol.permissions;
                    let permisos = response.permisos;
                    console.log(response);
                    permisos.forEach(permiso => {
                        let checked = '';
                        permisos_rol.forEach(permiso_rol => {
                            if (permiso_rol.id == permiso.id) {
                                checked = 'checked';
                            }
                        });
                        $('#permisos').append(`
                            <div class="form-check">
                                <input class="form-check-input" name="permisos[]" type="checkbox" value="${permiso.id}" id="permiso_${permiso.id}" ${checked}>
                                <label class="form-check-label" for="permiso_${permiso.id}">
                                    ${permiso.name}
                                </label>
                            </div>
                        `);
                    });
                }
            })
        }

        function actualizarUsuario() {
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
                            $('#form_actualizar_usuario').submit();
                        })
                    });
                }
            })
        };

        function eliminarUsuario(id) {
            $('#formDeleteUser').attr('action', 'eliminar_rol/' + id);
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
                            $('#formDeleteUser').submit();
                        })
                    });
                }
            })
        };

        function obtenerRoles() {
            event.preventDefault();
            $.ajax({
                url: "{{ url('admin/obtener_roles') }}",
                type: "GET",
                success: function(response) {
                    $('#rol').empty();
                    response.data.forEach(rol => {
                        $('#rol').append(`<option value="${rol.id}">${rol.name}</option>`);
                    });
                }
            })
        }

        function crearUsuario() {
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
                    $('#form_crear_usuario').submit();
                }
            })
            $('#form_crear_usuario').validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3,
                        maxlength: 191
                    },
                    email: {
                        required: true,
                        email: true,
                        minlength: 3,
                        maxlength: 191
                    },
                    password: {
                        required: true,
                        minlength: 3,
                        maxlength: 191
                    },
                    rol: {
                        required: true,
                    },
                },
                messages: {
                    name: {
                        required: "El campo nombre es obligatorio",
                        minlength: "El campo nombre debe tener al menos 3 caracteres",
                        maxlength: "El campo nombre debe tener máximo 191 caracteres"
                    },
                    email: {
                        required: "El campo email es obligatorio",
                        email: "El campo email debe ser un email válido",
                        minlength: "El campo email debe tener al menos 3 caracteres",
                        maxlength: "El campo email debe tener máximo 191 caracteres"
                    },
                    password: {
                        required: "El campo contraseña es obligatorio",
                        minlength: "El campo contraseña debe tener al menos 3 caracteres",
                        maxlength: "El campo contraseña debe tener máximo 191 caracteres"
                    },
                    rol: {
                        required: "El campo rol es obligatorio",
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
