<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Tarifa;

class TarifaController extends Controller
{
    public function verTarifas()
    {
        $user = auth()->user();
        if ($user->can('Ver tarifas')) {
            return view('tarifas');
        }
        abort(403, 'No tienes permiso para ver esta página');
    }

    public function obtenerTarifas()
    {
        $user = auth()->user();
        if ($user->can('Ver tarifas')) {
            $tarifas = Tarifa::all();
            return Datatables::of($tarifas)->toJson();
        }
        abort(403, 'No tienes permiso para ver esta página');
    }

    public function consultarTarifa($id)
    {
        $user = auth()->user();
        if ($user->can('Ver tarifas')) {
            $tarifa = Tarifa::find($id);
            return response()->json($tarifa);
        }
        abort(403, 'No tienes permiso para ver esta página');
    }

    public function actualizarTarifa(Request $request, $id)
    {
        $user = auth()->user();
        if ($user->can('Actualizar tarifas')) {
            $tarifa = Tarifa::find($id);
            $tarifa->update($request->all());
            return back()->with('success', 'Tarifa actualizada correctamente');
        }
        abort(403, 'No tienes permiso para ver esta página');
    }

    public function eliminarTarifa($id)
    {
        $user = auth()->user();
        if ($user->can('Eliminar tarifas')) {
            $tarifa = Tarifa::find($id);
            $tarifa->delete();
            return back()->with('success', 'Tarifa eliminada correctamente');
        }
        abort(403, 'No tienes permiso para ver esta página');
    }

    public function crearTarifa(Request $request)
    {
        $user = auth()->user();
        if ($user->can('Crear tarifas')) {
            $tarifa = Tarifa::create($request->all());
            return back()->with('success', 'Tarifa creada correctamente');
        }
        abort(403, 'No tienes permiso para ver esta página');
    }
}
