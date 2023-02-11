<?php

namespace App\Http\Controllers;

use Yajra\Datatables\Datatables;
use App\Models\Cliente;
use App\Models\Ciudad;


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
            return back()->with('success', 'Cliente actualizada correctamente');
        }
        abort(403, 'No tienes permiso para ver esta página');
    }

    public function obtenerServicios($id)
    {
        $user = auth()->user();
        if ($user->can('Ver clientes')) {
            $cliente = Cliente::find($id);
            $servicios = $cliente->servicios;
            return Datatables::of($servicios)->toJson();
        }
        abort(403, 'No tienes permiso para ver esta página');
    }

    public function consultarCiudades()
    {
        $ciudades = Ciudad::get();

        return response()->json($ciudades);
    }
}