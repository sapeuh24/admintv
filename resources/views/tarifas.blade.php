@extends('layouts.app')
@section('content')
    <div id="main">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Tarifas</h3>
                        <p class="text-subtitle text-muted">Administración de tarifas</p>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('/') }}">Inicio</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Tarifas</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        Tarifas
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            @if (auth()->user()->hasPermissionTo('Crear servicio'))
                                <button class="btn btn-primary me-md-2" type="button" data-bs-toggle="modal"
                                    data-bs-target="#modal_crear_tarifa">Agregar</button>
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
                        <table class="table" id="tabletarifas">
                            <thead>
                                <tr>
                                    <th>Tarifa</th>
                                    <th>Precio</th>
                                    <th>Creditos</th>
                                    <th>Comisión</th>
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

    <div class="modal fade" tabindex="-1" id="modal_tarifa">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Actualizar tarifa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" id="form_actualizar_tarifa" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="tarifa_edit">Tarifa</label>
                                    <input type="text" class="form-control" id="tarifa_edit" name="tarifa"
                                        placeholder="Nombre de la tarifa" autocomplete="nope" required>
                                </div>

                                <div class="form-group">
                                    <label for="precio_edit">Precio</label>
                                    <input type="number" class="form-control" id="precio_edit" name="precio"
                                        placeholder="Precio en solo números" autocomplete="nope" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="creditos_edit">Creditos</label>
                                    <input type="number" class="form-control" id="creditos_edit" name="creditos"
                                        placeholder="Cantidad de creditos" autocomplete="nope" required>
                                </div>

                                <div class="form-group">
                                    <label for="comision_edit">Comisión</label>
                                    <input type="number" class="form-control" id="comision_edit" name="comision"
                                        placeholder="Comisión en solo números" autocomplete="nope" required>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button onclick="actualizarTarifa()" type="button" class="btn btn-primary">Actualizar</button>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" tabindex="-1" id="modal_crear_tarifa">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crear tarifa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('crear_tarifa') }}" id="form_crear_tarifa" method="POST">
                        @method('POST')
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="tarifa">Tarifa</label>
                                    <input type="text" class="form-control" id="tarifa" name="tarifa"
                                        placeholder="Nombre de la tarifa" autocomplete="nope" required>
                                </div>

                                <div class="form-group">
                                    <label for="precio">Precio</label>
                                    <input type="number" class="form-control" id="precio" name="precio"
                                        placeholder="Precio en solo números" autocomplete="nope" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="creditos">Creditos</label>
                                    <input type="number" class="form-control" id="creditos" name="creditos"
                                        placeholder="Cantidad de creditos" autocomplete="nope" required>
                                </div>

                                <div class="form-group">
                                    <label for="comision">Comisión</label>
                                    <input type="number" class="form-control" id="comision" name="comision"
                                        placeholder="Comisión en solo números" autocomplete="nope" required>
                                </div>
                                <input type="hidden" name="id_empresa" value="{{ Auth::user()->id_empresa }}">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button onclick="crearTarifa()" type="button" class="btn btn-primary">Crear</button>
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
            $('#tabletarifas').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('obtener_tarifas') }}",
                columns: [{
                        data: 'tarifa',
                        name: 'tarifa'
                    },
                    {
                        data: 'precio',
                        name: 'precio'
                    },
                    {
                        data: 'creditos',
                        name: 'creditos'
                    },
                    {
                        data: 'comision',
                        name: 'comision'
                    },
                    {
                        data: null,
                        default: 'null',
                        render: function(data, type, row) {
                            return '<div class="btn-group" role="group" aria-label="Basic example">' +
                                '<?php if (Auth::user()->can('Actualizar tarifas')) { ?>' +
                                '<button type="button" class="btn btn-primary btn-sm" onclick="consultarTarifa(' +
                                data.id + ')">Editar</button>' +
                                '<?php } ?>' +
                                '<?php if (Auth::user()->can('Eliminar tarifas')) { ?>' +
                                '<button type="button" class="btn btn-danger btn-sm" onclick="eliminarTarifa(' +
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

        function consultarTarifa(id) {
            $('#form_actualizar_tarifa').attr('action', 'actualizar_tarifa/' + id);
            $('#modal_tarifa').modal('show');
            event.preventDefault();
            $.ajax({
                url: "{{ url('admin/consultar_tarifa') }}" + '/' + id,
                type: "GET",
                success: function(response) {
                    $('#tarifa_edit').val(response.tarifa);
                    $('#precio_edit').val(response.precio);
                    $('#creditos_edit').val(response.creditos);
                    $('#comision_edit').val(response.comision);
                }
            })
        }

        function actualizarTarifa() {
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
                            $('#form_actualizar_tarifa').submit();
                        })
                    });
                }
            })
        };

        function eliminarTarifa(id) {
            $('#formDeleteTarifa').attr('action', 'eliminar_tarifa/' + id);
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
                            $('#formDeleteTarifa').submit();
                        })
                    });
                }
            })
        };

        function crearTarifa() {
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
                    $('#form_crear_tarifa').submit();
                }
            })
            $('#form_crear_tarifa').validate({
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
