<?php

namespace App\Http\Controllers;

use Yajra\Datatables\Datatables;
use App\Models\Cliente;
use App\Models\Ciudad;
use App\Models\Servicio;
use App\Models\Activacion;
use App\Models\ServicioAplicaciones;
use App\Models\ServicioDispositivos;
use App\Models\Log;

use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function verClientes()
    {
        $user = auth()->user();

        if ($user->can('Ver clientes')) {
            return view('clientes');
        }
        abort(403, 'No tiene permisos para ver esta pagina');
    }

    public function obtenerClientes()
    {
        $user = auth()->user();
        if ($user->can('Ver clientes')) {
            $clientes = Cliente::all();
            return Datatables::of($clientes)->toJson();
        }
        abort(403, 'No tienes permiso para ver esta página');
    }

    public function consultarCliente($id)
    {
        $user = auth()->user();
        if ($user->can('Ver clientes')) {
            $cliente = Cliente::find($id);
            return response()->json($cliente);
        }
        abort(403, 'No tienes permiso para ver esta página');
    }

    public function crearCliente(Request $request)
    {
        $user = auth()->user();
        $slug = random_bytes(10);
        $slug = bin2hex($slug);

        if ($user->can('Crear cliente')) {
            $cliente = Cliente::create([
                'nombre' => $request->nombre,
                'fecha_creacion' => Date('Y-m-d'),
                'telefono' => $request->telefono,
                'facebook_enlace' => $request->facebook_enlace,
                'email' => $request->email,
                'notas' => $request->notas,
                'slug' => $slug,
                'id_ciudad' => $request->id_ciudad,
                'id_usuario' => $user->id
            ]);
            Log::saveLogs('Clientes', 'Crear', $cliente->id);
            return back()->with('success', 'Cliente creado correctamente');
        }
        abort(403, 'No tienes permiso para ver esta página');
    }

    public function verServiciosCliente($slug)
    {
        $user = auth()->user();

        $cliente = Cliente::where('slug', $slug)->first();

        return view('servicios', compact('cliente'));
    }

    public function actualizarCliente(Request $request, $id)
    {
        $user = auth()->user();
        if ($user->can('Actualizar cliente')) {
            $cliente = Cliente::find($id);
            $cliente->update($request->all());
            Log::saveLogs('Clientes', 'Actualizar', $cliente->id);
            return back()->with('success', 'Cliente actualizada correctamente');
        }
        abort(403, 'No tienes permiso para ver esta página');
    }

    public function obtenerServicios($id)
    {
        $user = auth()->user();
        if ($user->can('Ver clientes')) {
            $cliente = Cliente::find($id);
            $servicios = $cliente->servicios->load('aplicaciones', 'dispositivos', 'tarifa');
            return Datatables::of($servicios)->toJson();
        }
        abort(403, 'No tienes permiso para ver esta página');
    }

    public function crearServicio(Request $request)
    {
        $user = auth()->user();
        if ($user->can('Crear servicio')) {
            $cliente = Cliente::find($request->id_cliente);
            $servicio = Servicio::create([
                'id_tarifa' => $request->id_tarifa,
                'id_cliente' => $request->id_cliente,
                'id_pasarela' => $request->id_pasarela,
                'id_usuario' => $user->id,
                'fecha_creacion' => Date('Y-m-d'),
                'creditos_restantes' => $request->creditos,
                'estado' => 'Activo'
            ]);

            foreach ($request->aplicaciones as $aplicacion) {
                ServicioAplicaciones::create([
                    'id_servicio' => $servicio->id,
                    'id_aplicacion' => $aplicacion
                ]);
            }

            foreach ($request->dispositivos as $dispositivo) {
                ServicioDispositivos::create([
                    'id_servicio' => $servicio->id,
                    'id_dispositivo' => $dispositivo
                ]);
            }
            Log::saveLogs('Servicios', 'Crear', $servicio->id);
            return back()->with('success', 'Servicio creado correctamente');
        }
        abort(403, 'No tienes permiso para ver esta página');
    }

    public function obtenerActivaciones($id)
    {
        $user = auth()->user();
        if ($user->can('Ver clientes')) {
            $servicio = Servicio::find($id);
            $activaciones = $servicio->activaciones;
            return Datatables::of($activaciones)->toJson();
        }
        abort(403, 'No tienes permiso para ver esta página');
    }

    public function realizarActivacion(Request $request)
    {
        $user = auth()->user();
        if ($user->can('Gestionar activaciones')) {
            $servicio = Servicio::find($request->id_servicio);
            if ($servicio->creditos_restantes < $request->creditos) {
                return response()->json([
                    'error' => 'No tienes suficientes creditos para realizar esta activacion'
                ], 400);
            };
            $creditos_a_meses = $request->creditos * 30;
            $ultima_activacion = Activacion::where('servicio', $request->id_servicio)->orderBy('id', 'desc')->first();
            $activacion = Activacion::create([
                'servicio' => $request->id_servicio,
                'creditos' => $request->creditos,
                'fecha_inicio' => $request->fecha_creacion,
                'fecha_fin' => Date('Y-m-d', strtotime($request->fecha_creacion . ' + ' . $creditos_a_meses . ' days')),
            ]);
            $servicio->creditos_restantes = $servicio->creditos_restantes - $request->creditos;
            $servicio->save();
            Log::saveLogs('Activaciones', 'Crear', $activacion->id);
            return back()->with('success', 'Activacion realizada correctamente');
        }
        abort(403, 'No tienes permiso para ver esta página');
    }

    public function consultarCiudades()
    {
        $ciudades = Ciudad::get();

        return response()->json($ciudades);
    }

    public function anularServicio(Request $request)
    {
        $user = auth()->user();
        if ($user->can('Anular servicio')) {
            $servicio = Servicio::find($request->id_servicio_anular);
            $servicio->estado = 'Anulado';
            $servicio->observaciones = $request->descripcion;
            $servicio->save();
            Log::saveLogs('Servicios', 'Anular', $servicio->id);
            return back()->with('success', 'Servicio anulado correctamente');
        }
        abort(403, 'No tienes permiso para ver esta página');
    }

    public function verAnulaciones()
    {
        $user = auth()->user();
        if ($user->can('Ver anulaciones')) {
            return view('anulaciones');
        }
        abort(403, 'No tienes permiso para ver esta página');
    }

    public function obtenerAnulaciones()
    {
        $user = auth()->user();
        if ($user->can('Ver anulaciones')) {
            $anulaciones = Servicio::where('estado', 'Anulado')->with('cliente', 'usuario', 'tarifa')->get();
            return Datatables::of($anulaciones)->toJson();
        }
        abort(403, 'No tienes permiso para ver esta página');
    }
}
