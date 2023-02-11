@extends('layouts.app')
@section('content')
    <div id="main">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Roles y permisos</h3>
                        <p class="text-subtitle text-muted">Administración de roles y permisos del programa</p>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('/') }}">Inicio</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Roles y permisos</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        Roles y permisos
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
    <div class="modal fade" tabindex="-1" id="modal_rol">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Actualizar rol</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" id="form_actualizar_rol" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="nombre">Rol</label>
                            <input type="text" class="form-control" id="nombre" name="name"
                                placeholder="Nombre del rol">
                        </div>
                        <div id="permisos">

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button onclick="actualizarRol()" type="button" class="btn btn-primary">Actualizar</button>
                </div>
            </div>
        </div>
        <form id="formDeleteRol" action="" method="POST" style="display: none">
            @csrf
            @method('DELETE')
        </form>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#tableroles').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('obtener_roles') }}",
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: null,
                        default: 'null',
                        render: function(data, type, row) {
                            return '<div class="btn-group" role="group" aria-label="Basic example">' +
                                '<?php if (Auth::user()->can('Actualizar rol')) { ?>' +
                                '<button type="button" class="btn btn-primary btn-sm" onclick="consultarRol(' +
                                data.id + ')">Editar</button>' +
                                '<?php } ?>' +
                                '<?php if (Auth::user()->can('Eliminar rol')) { ?>' +
                                '<button type="button" class="btn btn-danger btn-sm" onclick="eliminarRol(' +
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

        function consultarRol(id) {
            $('#form_actualizar_rol').attr('action', 'actualizar_rol/' + id);
            $('#modal_rol').modal('show');
            event.preventDefault();
            $('#formActualizarCategoria').attr('action', 'actualizar_categoria/' + id);
            $.ajax({
                url: "{{ url('admin/consultar_rol') }}" + '/' + id,
                type: "GET",
                success: function(response) {
                    $('#nombre').val(response.rol.name);
                    $('#permisos').empty();
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

        function actualizarRol() {
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
                            $('#form_actualizar_rol').submit();
                        })
                    });
                }
            })
        };

        function eliminarRol(id) {
            $('#formDeleteRol').attr('action', 'eliminar_rol/' + id);
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
                            $('#formDeleteRol').submit();
                        })
                    });
                }
            })
        };
    </script>
@endsection
