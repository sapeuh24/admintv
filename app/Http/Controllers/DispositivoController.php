<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Dispositivo;
use App\Models\ServicioDispositivos;
use App\Models\Log;

class DispositivoController extends Controller
{
    public function verDispositivos()
    {
        $user = auth()->user();
        if ($user->can('Ver dispositivos')) {
            return view('dispositivos');
        }
        abort(403, 'No tienes permiso para ver esta página');
    }

    public function obtenerDispositivos()
    {
        $user = auth()->user();
        if ($user->can('Ver dispositivos')) {
            $dispositivos = Dispositivo::all();
            return Datatables::of($dispositivos)->toJson();
        }
        abort(403, 'No tienes permiso para ver esta página');
    }

    public function consultarDispositivo($id)
    {
        $user = auth()->user();
        if ($user->can('Ver dispositivos')) {
            $dispositivo = Dispositivo::find($id);
            return response()->json($dispositivo);
        }
        abort(403, 'No tienes permiso para ver esta página');
    }

    public function crearDispositivo(Request $request)
    {
        $user = auth()->user();
        if ($user->can('Crear dispositivo')) {
            $dispositivo = Dispositivo::create([
                'nombre' => $request->nombre,
            ]);
            Log::saveLogs('Dispositivos', 'Crear', $dispositivo->id);
            return back()->with('success', 'Dispositivo creado correctemente');
        }
        abort(403, 'No tienes permiso para ver esta página');
    }

    public function actualizarDispositivo(Request $request)
    {
        $user = auth()->user();
        if ($user->can('Actualizar dispositivo')) {
            $dispositivo = Dispositivo::find($request->id);
            $dispositivo->nombre = $request->nombre;
            $dispositivo->save();
            Log::saveLogs('Dispositivos', 'Actualizar', $dispositivo->id);
            return back()->with('success', 'Dispositivo actualizado correctamente');
        }
        abort(403, 'No tienes permiso para ver esta página');
    }

    public function eliminarDispositivo($id)
    {
        $user = auth()->user();
        if ($user->can('Eliminar dispositivo')) {
            $dispositivo = Dispositivo::find($id);
            $servicio_dispositivos = ServicioDispositivos::where('id_dispositivo', $id)->get();
            if (count($servicio_dispositivos) > 0) {
                return back()->with('error', 'No se puede eliminar el dispositivo porque está asociado a un servicio');
            }
            $dispositivo->delete();
            Log::saveLogs('Dispositivos', 'Eliminar', $id);
            return back()->with('success', 'Dispositivo eliminado correctamente');
        }
        abort(403, 'No tienes permiso para ver esta página');
    }
}