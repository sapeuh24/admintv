<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Tarifa;
use App\Models\Pasarela;
use App\Models\Aplicacion;
use App\Models\Dispositivo;
use App\Models\Log;
use App\Models\Servicio;

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
            $tarifas = Tarifa::where('id_empresa', $user->id_empresa)->get();
            return Datatables::of($tarifas)->toJson();
        }
        abort(403, 'No tienes permiso para ver esta página');
    }

    public function consultarTarifa($id)
    {
        $tarifa = Tarifa::find($id);
        return response()->json($tarifa);
    }

    public function actualizarTarifa(Request $request, $id)
    {
        $user = auth()->user();
        if ($user->can('Actualizar tarifas')) {
            $tarifa = Tarifa::find($id);
            $tarifa->update($request->all());
            Log::saveLogs('Tarifas', 'Actualizar', $tarifa->id);
            return back()->with('success', 'Tarifa actualizada correctamente');
        }
        abort(403, 'No tienes permiso para ver esta página');
    }

    public function eliminarTarifa($id)
    {
        $user = auth()->user();
        if ($user->can('Eliminar tarifas')) {
            $tarifa = Tarifa::find($id);
            $tarifas = Servicio::where('id_tarifa', $id)->get();
            if (count($tarifas) > 0) {
                return back()->with('error', 'No se puede eliminar la tarifa porque está asociada a un servicio');
            }
            Log::saveLogs('Tarifas', 'Eliminar', $tarifa->id);
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
            Log::saveLogs('Tarifas', 'Crear', $tarifa->id);
            return back()->with('success', 'Tarifa creada correctamente');
        }
        abort(403, 'No tienes permiso para ver esta página');
    }

    public function obtenerTarifasJSON()
    {
        $user = auth()->user();

        $tarifas = Tarifa::where('id_empresa', $user->id_empresa)->get();

        return response()->json($tarifas);
    }

    public function obtenerPasarelasJSON()
    {
        $user = auth()->user();

        $pasarelas = Pasarela::where('id_empresa', $user->id_empresa)->get();

        return response()->json($pasarelas);
    }

    public function obtenerAplicacionesJSON()
    {
        $aplicaciones = Aplicacion::get();

        return response()->json($aplicaciones);
    }

    public function obtenerDispositivosJSON()
    {
        $dispositivos = Dispositivo::get();

        return response()->json($dispositivos);
    }
}
