<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Aplicacion;
use App\Models\ServicioAplicaciones;
use App\Models\Log;

class AplicacionController extends Controller
{
    public function verAplicaciones()
    {
        $user = auth()->user();
        if ($user->can('Ver aplicaciones')) {
            return view('aplicaciones');
        }
        abort(403, 'No tienes permiso para ver esta página');
    }

    public function obtenerAplicaciones()
    {
        $user = auth()->user();
        if ($user->can('Ver aplicaciones')) {
            $aplicaciones = Aplicacion::all();
            return Datatables::of($aplicaciones)->toJson();
        }
        abort(403, 'No tienes permiso para ver esta página');
    }

    public function consultarAplicacion($id)
    {
        $user = auth()->user();
        if ($user->can('Ver aplicaciones')) {
            $aplicacion = Aplicacion::find($id);
            return response()->json($aplicacion);
        }
        abort(403, 'No tienes permiso para ver esta página');
    }

    public function crearAplicacion(Request $request)
    {
        $user = auth()->user();
        if ($user->can('Crear aplicacion')) {
            $aplicacion = Aplicacion::create([
                'nombre' => $request->nombre,
            ]);
            Log::saveLogs('Aplicaciones', 'Crear', $aplicacion->id);
            return back()->with('success', 'Aplicación creada correctemente');
        }
        abort(403, 'No tienes permiso para ver esta página');
    }

    public function actualizarAplicacion(Request $request)
    {
        $user = auth()->user();
        if ($user->can('Actualizar aplicacion')) {
            $aplicacion = Aplicacion::find($request->id);
            $aplicacion->nombre = $request->nombre;
            $aplicacion->save();
            Log::saveLogs('Aplicaciones', 'Actualizar', $aplicacion->id);
            return back()->with('success', 'Aplicación actualizada correctamente');
        }
        abort(403, 'No tienes permiso para ver esta página');
    }

    public function eliminarAplicacion($id)
    {
        $user = auth()->user();
        if ($user->can('Eliminar aplicacion')) {
            $aplicacion = Aplicacion::find($id);
            $servicio_aplicacion = ServicioAplicaciones::where('id_aplicacion', $id)->get();
            if (count($servicio_aplicacion) > 0) {
                return back()->with('error', 'No se puede eliminar la aplicación porque está asociada a un servicio');
            }
            Log::saveLogs('Aplicaciones', 'Eliminar', $aplicacion->id);
            $aplicacion->delete();
            return back()->with('success', 'Aplicación eliminada correctamente');
        }
        abort(403, 'No tienes permiso para ver esta página');
    }
}