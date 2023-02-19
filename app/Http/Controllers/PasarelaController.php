<?php

namespace App\Http\Controllers;

use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use App\Models\Pasarela;
use App\Models\Log;

class PasarelaController extends Controller
{
    public function verPasarelas()
    {
        $user = auth()->user();
        if ($user->can('Ver pasarelas')) {
            return view('pasarelas');
        }
        abort(403, 'No tienes permiso para ver esta página');
    }

    public function obtenerPasarelas()
    {
        $user = auth()->user();
        if ($user->can('Ver pasarelas')) {
            $pasarelas = Pasarela::all();
            return Datatables::of($pasarelas)->toJson();
        }
        abort(403, 'No tienes permiso para ver esta página');
    }

    public function consultarPasarela($id)
    {
        $user = auth()->user();
        if ($user->can('Ver pasarelas')) {
            $pasarela = Pasarela::find($id);
            return response()->json($pasarela);
        }
        abort(403, 'No tienes permiso para ver esta página');
    }

    public function crearPasarela(Request $request)
    {
        $user = auth()->user();
        if ($user->can('Crear pasarela')) {
            $pasarela = Pasarela::create([
                'nombre' => $request->nombre,
            ]);
            Log::saveLogs('Pasarelas', 'Crear', $pasarela->id);
            return back()->with('success', 'Pasarela creada correctemente');
        }
        abort(403, 'No tienes permiso para ver esta página');
    }

    public function actualizarPasarela(Request $request)
    {
        $user = auth()->user();
        if ($user->can('Actualizar pasarela')) {
            $pasarela = Pasarela::find($request->id);
            $pasarela->nombre = $request->nombre;
            $pasarela->save();
            Log::saveLogs('Pasarelas', 'Actualizar', $pasarela->id);
            return back()->with('success', 'Pasarela actualizada correctamente');
        }
        abort(403, 'No tienes permiso para ver esta página');
    }

    public function eliminarPasarela($id)
    {
        $user = auth()->user();
        if ($user->can('Eliminar pasarela')) {
            $pasarela = Pasarela::find($id);
            $servicios = $pasarela->servicios;
            if (count($servicios) > 0) {
                return back()->with('error', 'No se puede eliminar la pasarela porque tiene servicios asociados');
            }
            Log::saveLogs('Pasarelas', 'Eliminar', $pasarela->id);
            $pasarela->delete();
            return back()->with('success', 'Pasarela eliminada correctamente');
        }
        abort(403, 'No tienes permiso para ver esta página');
    }

    public function obtenerPasarelasJSON()
    {
        $user = auth()->user();
        $pasarelas = Pasarela::all();
        return response()->json($pasarelas);
    }
}
