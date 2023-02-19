<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateRolRequest;
use App\Models\Log;

class RoleController extends Controller
{
    public function verRolesyPermisos()
    {
        $user = auth()->user();

        if ($user->can('Ver roles y permisos')) {
            return view('rolesypermisos');
        }
        abort(403);
    }

    public function obtenerRoles()
    {
        $user = auth()->user();

        if ($user->can('Ver roles y permisos')) {
            $roles = Role::all();
            return Datatables::of($roles)->toJson();
        }
        abort(403);
    }

    public function consultarRol($id)
    {
        $user = auth()->user();

        if ($user->can('Ver roles y permisos')) {
            $rol = Role::find($id);
            $permisos = Permission::all();
            $rol->load('permissions');
            return response()->json([
                'rol' => $rol,
                'permisos' => $permisos
            ]);
        }
        abort(403);
    }

    public function actualizarRol(UpdateRolRequest $request, $id)
    {
        $user = auth()->user();

        if ($user->can('Actualizar rol')) {
            $rol = Role::find($id);
            $rol->name = $request->name;
            $rol->syncPermissions($request->permisos);
            $rol->save();
            Log::saveLogs('Roles', 'Actualizar', $rol->id);
            return back()->with('success', 'Rol actualizado correctamente');
        }
        abort(403);
    }

    public function eliminarRol($id)
    {
        $user = auth()->user();

        if ($user->can('Eliminar rol')) {
            $rol = Role::find($id);
            if ($rol->users->count() > 0) {
                return back()->with('error', 'No se puede eliminar el rol porque está siendo usado por algún usuario');
            }
            Log::saveLogs('Roles', 'Eliminar', $rol->id);
            $rol->delete();
            return back()->with('success', 'Rol eliminado correctamente');
        }
        abort(403);
    }

    public function crearRol(Request $request)
    {
        $user = auth()->user();

        if ($user->can('Crear rol')) {
            $rol = Role::create(['name' => $request->name]);
            $rol->syncPermissions($request->permisos);
            Log::saveLogs('Roles', 'Crear', $rol->id);
            return back()->with('success', 'Rol creado correctamente');
        }
        abort(403);
    }

    public function obtenerPermisos()
    {
        $user = auth()->user();
        if ($user->can('Crear rol')) {
            $permisos = Permission::all();
            return response()->json($permisos);
        }
        abort(403);
    }
}