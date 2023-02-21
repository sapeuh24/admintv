<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('/');


Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//route groput middleware auth

Route::group(['middleware' => 'auth'], function () {
    Route::get('/admin/roles_permisos', [App\Http\Controllers\RoleController::class, 'verRolesyPermisos'])->name('roles_permisos');
    Route::get('admin/obtener_roles', [App\Http\Controllers\RoleController::class, 'obtenerRoles'])->name('obtener_roles');
    Route::get('admin/consultar_rol/{id}', [App\Http\Controllers\RoleController::class, 'consultarRol'])->name('consultar_rol');
    Route::put('admin/actualizar_rol/{id}', [App\Http\Controllers\RoleController::class, 'actualizarRol'])->name('actualizar_rol');
    Route::delete('admin/eliminar_rol/{id}', [App\Http\Controllers\RoleController::class, 'eliminarRol'])->name('eliminar_rol');
    Route::post('admin/crear_rol', [App\Http\Controllers\RoleController::class, 'crearRol'])->name('crear_rol');
    Route::get('admin/obtener_permisos', [App\Http\Controllers\RoleController::class, 'obtenerPermisos'])->name('obtener_permisos');

    //rutas para usuarios
    Route::get('/admin/usuarios', [App\Http\Controllers\UserController::class, 'verUsuarios'])->name('usuarios');
    Route::get('admin/obtener_usuarios', [App\Http\Controllers\UserController::class, 'obtenerUsuarios'])->name('obtener_usuarios');
    Route::get('admin/consultar_usuario/{id}', [App\Http\Controllers\UserController::class, 'consultarUsuario'])->name('consultar_usuario');
    Route::put('admin/actualizar_usuario/{id}', [App\Http\Controllers\UserController::class, 'actualizarUsuario'])->name('actualizar_usuario');
    Route::post('admin/crear_usuario', [App\Http\Controllers\UserController::class, 'crearUsuario'])->name('crear_usuario');

    //rutas para tarifas
    Route::get('/admin/tarifas', [App\Http\Controllers\TarifaController::class, 'verTarifas'])->name('tarifas');
    Route::get('admin/obtener_tarifas', [App\Http\Controllers\TarifaController::class, 'obtenerTarifas'])->name('obtener_tarifas');
    Route::post('admin/crear_tarifa', [App\Http\Controllers\TarifaController::class, 'crearTarifa'])->name('crear_tarifa');
    Route::get('admin/consultar_tarifa/{id}', [App\Http\Controllers\TarifaController::class, 'consultarTarifa'])->name('consultar_tarifa');
    Route::put('admin/actualizar_tarifa/{id}', [App\Http\Controllers\TarifaController::class, 'actualizarTarifa'])->name('actualizar_tarifa');
    Route::delete('admin/eliminar_tarifa/{id}', [App\Http\Controllers\TarifaController::class, 'eliminarTarifa'])->name('eliminar_tarifa');
    Route::get('admin/obtener_tarifas_json', [App\Http\Controllers\TarifaController::class, 'obtenerTarifasJSON'])->name('obtener_tarifas_json');
    Route::get('admin/obtener_pasarelas_json', [App\Http\Controllers\TarifaController::class, 'obtenerPasarelasJSON'])->name('obtener_pasarelas_json');
    Route::get('admin/obtener_aplicaciones_json', [App\Http\Controllers\TarifaController::class, 'obtenerAplicacionesJSON'])->name('obtener_aplicaciones_json');
    Route::get('admin/obtener_dispositivos_json', [App\Http\Controllers\TarifaController::class, 'obtenerDispositivosJSON'])->name('obtener_dispositivos_json');

    //rutas para clientes
    Route::get('/admin/clientes', [App\Http\Controllers\ClienteController::class, 'verClientes'])->name('clientes');
    Route::get('admin/obtener_clientes', [App\Http\Controllers\ClienteController::class, 'obtenerClientes'])->name('obtener_clientes');
    Route::post('admin/crear_cliente', [App\Http\Controllers\ClienteController::class, 'crearCliente'])->name('crear_cliente');
    Route::get('admin/consultar_cliente/{id}', [App\Http\Controllers\ClienteController::class, 'consultarCliente'])->name('consultar_cliente');
    Route::put('admin/actualizar_cliente/{id}', [App\Http\Controllers\ClienteController::class, 'actualizarCliente'])->name('actualizar_cliente');
    Route::delete('admin/eliminar_cliente/{id}', [App\Http\Controllers\ClienteController::class, 'eliminarCliente'])->name('eliminar_cliente');

    //rutas para aplicaciones
    Route::get('/admin/aplicaciones', [App\Http\Controllers\AplicacionController::class, 'verAplicaciones'])->name('aplicaciones');
    Route::get('admin/obtener_aplicaciones', [App\Http\Controllers\AplicacionController::class, 'obtenerAplicaciones'])->name('obtener_aplicaciones');
    Route::post('admin/crear_aplicacion', [App\Http\Controllers\AplicacionController::class, 'crearAplicacion'])->name('crear_aplicacion');
    Route::get('admin/consultar_aplicacion/{id}', [App\Http\Controllers\AplicacionController::class, 'consultarAplicacion'])->name('consultar_aplicacion');
    Route::put('admin/actualizar_aplicacion/{id}', [App\Http\Controllers\AplicacionController::class, 'actualizarAplicacion'])->name('actualizar_aplicacion');
    Route::delete('admin/eliminar_aplicacion/{id}', [App\Http\Controllers\AplicacionController::class, 'eliminarAplicacion'])->name('eliminar_aplicacion');

    //rutas para dispositivos
    Route::get('/admin/dispositivos', [App\Http\Controllers\DispositivoController::class, 'verDispositivos'])->name('dispositivos');
    Route::get('admin/obtener_dispositivos', [App\Http\Controllers\DispositivoController::class, 'obtenerDispositivos'])->name('obtener_dispositivos');
    Route::post('admin/crear_dispositivo', [App\Http\Controllers\DispositivoController::class, 'crearDispositivo'])->name('crear_dispositivo');
    Route::get('admin/consultar_dispositivo/{id}', [App\Http\Controllers\DispositivoController::class, 'consultarDispositivo'])->name('consultar_dispositivo');
    Route::put('admin/actualizar_dispositivo/{id}', [App\Http\Controllers\DispositivoController::class, 'actualizarDispositivo'])->name('actualizar_dispositivo');
    Route::delete('admin/eliminar_dispositivo/{id}', [App\Http\Controllers\DispositivoController::class, 'eliminarDispositivo'])->name('eliminar_dispositivo');

    //rutas para pasarelas
    Route::get('/admin/pasarelas', [App\Http\Controllers\PasarelaController::class, 'verPasarelas'])->name('pasarelas');
    Route::get('admin/obtener_pasarelas', [App\Http\Controllers\PasarelaController::class, 'obtenerPasarelas'])->name('obtener_pasarelas');
    Route::post('admin/crear_pasarela', [App\Http\Controllers\PasarelaController::class, 'crearPasarela'])->name('crear_pasarela');
    Route::get('admin/consultar_pasarela/{id}', [App\Http\Controllers\PasarelaController::class, 'consultarPasarela'])->name('consultar_pasarela');
    Route::put('admin/actualizar_pasarela/{id}', [App\Http\Controllers\PasarelaController::class, 'actualizarPasarela'])->name('actualizar_pasarela');
    Route::delete('admin/eliminar_pasarela/{id}', [App\Http\Controllers\PasarelaController::class, 'eliminarPasarela'])->name('eliminar_pasarela');
    Route::get('admin/obtener_pasarelas_json', [App\Http\Controllers\PasarelaController::class, 'obtenerPasarelasJSON'])->name('obtener_pasarelas_json');



    Route::get('admin/consultar_ciudades', [App\Http\Controllers\ClienteController::class, 'consultarCiudades'])->name('consultar_ciudades');
    Route::get('admin/obtener_servicios/{id}', [App\Http\Controllers\ClienteController::class, 'obtenerServicios'])->name('obtener_servicios');

    Route::get('ver_servicios_cliente/{slug}', [App\Http\Controllers\ClienteController::class, 'verServiciosCliente'])->name('ver_servicios_cliente');
    Route::get('admin/obtener_activaciones/{id}', [App\Http\Controllers\ClienteController::class, 'obtenerActivaciones'])->name('obtener_activaciones');
    Route::post('admin/realizar_activacion', [App\Http\Controllers\ClienteController::class, 'realizarActivacion'])->name('realizar_activacion');
    Route::post('admin/anular_servicio', [App\Http\Controllers\ClienteController::class, 'anularServicio'])->name('anular_servicio');

    Route::post('crear_servicio', [App\Http\Controllers\ClienteController::class, 'crearServicio'])->name('crear_servicio');

    //reporte usuarios y reporte ventas
    Route::get('admin/reporte_clientes', [App\Http\Controllers\ReporteController::class, 'reporteClientes'])->name('reporte_clientes');
    Route::get('admin/reporte_ventas', [App\Http\Controllers\ReporteController::class, 'reporteVentas'])->name('reporte_ventas');

    Route::get('admin/reporte_acciones', [App\Http\Controllers\ReporteController::class, 'reporteAcciones'])->name('reporte_acciones');

    //reporte ventas
    Route::get('admin/reporte_servicios', [App\Http\Controllers\ReporteController::class, 'reporteServicios'])->name('reporte_servicios');
    Route::get('admin/ventas', [App\Http\Controllers\ReporteController::class, 'verVentas'])->name('ventas');
    Route::get('admin/reporte_servicios', [App\Http\Controllers\ReporteController::class, 'reporteServicios'])->name('reporte_servicios');
    //obtenerUsuariosVendedores
    Route::get('admin/obtener_usuarios_vendedores', [App\Http\Controllers\ReporteController::class, 'obtenerUsuariosVendedores'])->name('obtener_usuarios_vendedores');

    //rutas para anulaciones
    Route::get('admin/anulaciones', [App\Http\Controllers\ClienteController::class, 'verAnulaciones'])->name('anulaciones');
    Route::get('admin/obtener_anulaciones', [App\Http\Controllers\ClienteController::class, 'obtenerAnulaciones'])->name('obtener_anulaciones');
});