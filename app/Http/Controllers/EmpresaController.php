<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Empresa;
use App\Models\Log;

class EmpresaController extends Controller
{
    public function verEmpresas()
    {
        $user = auth()->user();

        if ($user->can('Ver empresas')) {
            return view('empresas');
        }
        abort(403);
    }

    public function obtenerEmpresas()
    {
        $user = auth()->user();

        if ($user->can('Ver empresas')) {
            $empresas = Empresa::all();
            return Datatables::of($empresas)->toJson();
        }
        abort(403);
    }

    public function crearEmpresa(Request $request)
    {
        $user = auth()->user();

        if ($user->can('Crear empresa')) {
            $empresa = Empresa::create($request->all());
            Log::saveLogs('Empresas', 'Crear', $empresa->id);
            return back()->with('success', 'Empresa creada correctamente');
        }
        abort(403);
    }

    public function consultarEmpresa($id)
    {
        $user = auth()->user();

        if ($user->can('Ver empresas')) {
            $empresa = Empresa::find($id);
            return response()->json($empresa);
        }
        abort(403);
    }

    public function actualizarEmpresa(Request $request, $id)
    {
        $user = auth()->user();

        if ($user->can('Actualizar empresa')) {
            $empresa = Empresa::find($id);
            $empresa->update($request->all());
            Log::saveLogs('Empresas', 'Actualizar', $empresa->id);
            return back()->with('success', 'Empresa actualizada correctamente');
        }
        abort(403);
    }

    public function eliminarEmpresa($id)
    {
        $user = auth()->user();

        if ($user->can('Eliminar empresa')) {
            $empresa = Empresa::find($id);
            Log::saveLogs('Empresas', 'Eliminar', $empresa->id);
            $empresa->delete();
            return back()->with('success', 'Empresa eliminada correctamente');
        }
        abort(403);
    }

    public function consultarEmpresasJSON()
    {
        $empresas = Empresa::all();
        return response()->json($empresas);
    }
}
