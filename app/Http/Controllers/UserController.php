<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function verUsuarios()
    {
        $user = auth()->user();

        if ($user->can('Ver usuarios')) {
            return view('usuarios');
        }
        abort(403);
    }

    public function obtenerUsuarios()
    {
        $user = auth()->user();

        if ($user->can('Ver usuarios')) {
            //ghet the users with their roles
            $usuarios = User::with('roles')->get();
            return Datatables::of($usuarios)->toJson();
        }
        abort(403);
    }

    public function actualizarUsuario(Request $request, $id)
    {
        $user = auth()->user();

        if ($user->can('Actualizar usuario')) {
            $usuario = User::find($id);
            $usuario->name = $request->name;
            $usuario->email = $request->email;
            if ($request->password != null) {
                $usuario->password = bcrypt($request->password);
            }
            $usuario->save();
            return back()->with('success', 'Usuario actualizado correctamente');
        }
        abort(403);
    }

    public function eliminarUsuario($id)
    {
        $user = auth()->user();

        if ($user->can('Eliminar usuario')) {
            $usuario = User::find($id);
            $usuario->delete();
            return back()->with('success', 'Usuario eliminado correctamente');
        }
        abort(403);
    }

    public function consultarUsuario($id)
    {
        $user = auth()->user();

        if ($user->can('Ver usuarios')) {
            $usuario = User::find($id)->load('roles');
            $roles = Role::all();
            return response()->json([
                'usuario' => $usuario,
                'roles' => $roles
            ]);
        }
        abort(403);
    }
}
