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

Route::get('/', function () {
    return view('home');
})->name('/');


Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/admin/roles_permisos', [App\Http\Controllers\RoleController::class, 'verRolesyPermisos'])->name('roles_permisos');
Route::get('admin/obtener_roles', [App\Http\Controllers\RoleController::class, 'obtenerRoles'])->name('obtener_roles');
Route::get('admin/consultar_rol/{id}', [App\Http\Controllers\RoleController::class, 'consultarRol'])->name('consultar_rol');
Route::put('admin/actualizar_rol/{id}', [App\Http\Controllers\RoleController::class, 'actualizarRol'])->name('actualizar_rol');
Route::delete('admin/eliminar_rol/{id}', [App\Http\Controllers\RoleController::class, 'eliminarRol'])->name('eliminar_rol');

//rutas para usuarios
Route::get('/admin/usuarios', [App\Http\Controllers\UserController::class, 'verUsuarios'])->name('usuarios');
Route::get('admin/obtener_usuarios', [App\Http\Controllers\UserController::class, 'obtenerUsuarios'])->name('obtener_usuarios');
Route::get('admin/consultar_usuario/{id}', [App\Http\Controllers\UserController::class, 'consultarUsuario'])->name('consultar_usuario');
Route::put('admin/actualizar_usuario/{id}', [App\Http\Controllers\UserController::class, 'actualizarUsuario'])->name('actualizar_usuario');

//rutas para tarifas
Route::get('/admin/tarifas', [App\Http\Controllers\TarifaController::class, 'verTarifas'])->name('tarifas');
Route::get('admin/obtener_tarifas', [App\Http\Controllers\TarifaController::class, 'obtenerTarifas'])->name('obtener_tarifas');
Route::post('admin/crear_tarifa', [App\Http\Controllers\TarifaController::class, 'crearTarifa'])->name('crear_tarifa');
Route::get('admin/consultar_tarifa/{id}', [App\Http\Controllers\TarifaController::class, 'consultarTarifa'])->name('consultar_tarifa');
Route::put('admin/actualizar_tarifa/{id}', [App\Http\Controllers\TarifaController::class, 'actualizarTarifa'])->name('actualizar_tarifa');
Route::delete('admin/eliminar_tarifa/{id}', [App\Http\Controllers\TarifaController::class, 'eliminarTarifa'])->name('eliminar_tarifa');


//rutas para clientes
Route::get('/admin/clientes', [App\Http\Controllers\ClienteController::class, 'verClientes'])->name('clientes');
Route::get('admin/obtener_clientes', [App\Http\Controllers\ClienteController::class, 'obtenerClientes'])->name('obtener_clientes');
Route::post('admin/crear_cliente', [App\Http\Controllers\ClienteController::class, 'crearCliente'])->name('crear_cliente');
Route::get('admin/consultar_cliente/{id}', [App\Http\Controllers\ClienteController::class, 'consultarCliente'])->name('consultar_cliente');
Route::put('admin/actualizar_cliente/{id}', [App\Http\Controllers\ClienteController::class, 'actualizarCliente'])->name('actualizar_cliente');
Route::delete('admin/eliminar_cliente/{id}', [App\Http\Controllers\ClienteController::class, 'eliminarCliente'])->name('eliminar_cliente');

Route::get('admin/consultar_ciudades', [App\Http\Controllers\ClienteController::class, 'consultarCiudades'])->name('consultar_ciudades');
Route::get('admin/obtener_servicios/{id}', [App\Http\Controllers\ClienteController::class, 'obtenerServicios'])->name('obtener_servicios');

//verServiciosCiente
Route::get('ver_servicios_cliente/{slug}', [App\Http\Controllers\ClienteController::class, 'verServiciosCliente'])->name('ver_servicios_cliente');
