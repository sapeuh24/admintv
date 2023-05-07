<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Cliente;
use App\Models\Servicio;
use App\Models\Log;
use App\Models\User;
use App\Models\Pasarela;
use App\Models\Aplicacion;

class ReporteController extends Controller
{
    public function reporteClientes()
    {
        $user = auth()->user();
        $usuarios = [];
        if ($user->hasRole('Administrador')) {
            $usuarios = User::pluck('id')->toArray();
        } else {
            $usuarios = $user->pluck('id')->toArray();
        }

        $clientes = Cliente::selectRaw('count(*) as clientes, MONTH(fecha_creacion) as mes')
            ->whereIn('id_usuario', $usuarios)
            ->whereYear('fecha_creacion', date('Y'))
            ->groupBy('mes')
            ->get();

        $clientes_array = $clientes->map(function ($item) {
            return $item->clientes;
        });

        $clientes = $clientes->map(function ($item) {
            $item->mes = str_pad($item->mes, 2, '0', STR_PAD_LEFT);
            return $item;
        });

        $meses_texto = ['01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'];

        $meses = $clientes->map(function ($item) use ($meses_texto) {
            return $meses_texto[$item->mes];
        })->unique();

        return response()->json([
            'clientes' => $clientes_array,
            'meses' => $meses
        ]);
    }

    public function reporteVentas()
    {
        $user = auth()->user();
        $usuarios = [];
        if ($user->hasRole('admin')) {
            $usuarios = User::pluck('id')->toArray();
        } else {
            $usuarios = $user->pluck('id')->toArray();
        }

        $ventas = Servicio::selectRaw('sum(tarifas.precio) as ventas, MONTH(fecha_creacion) as mes')
            ->join('tarifas', 'tarifas.id', '=', 'servicios.id_tarifa')
            ->whereIn('id_usuario', $usuarios)
            ->whereYear('fecha_creacion', date('Y'))
            ->groupBy('mes')
            ->get();

        $ventas_array = $ventas->map(function ($item) {
            return $item->ventas;
        });

        $ventas = $ventas->map(function ($item) {
            $item->mes = str_pad($item->mes, 2, '0', STR_PAD_LEFT);
            return $item;
        });

        $meses_texto = ['01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'];

        $meses = $ventas->map(function ($item) use ($meses_texto) {
            return $meses_texto[$item->mes];
        })->unique();

        return response()->json([
            'ventas' => $ventas_array,
            'meses' => $meses
        ]);
    }

    public function reporteAcciones()
    {
        $logs = Log::with('user')->get();

        return Datatables::of($logs)->toJson();
    }

    public function reporteServicios(Request $request)
    {
        $vendedor[] = $request->vendedor;
        $pasarela[] = $request->pasarela;
        $aplicacion[] = $request->aplicacion;

        $user = auth()->user();

        if ($request->vendedor == 'all') {
            $vendedor = User::get()->where('id_empresa', $user->id_empresa)->pluck('id')->toArray();
        }
        if ($request->pasarela == 'all') {
            $pasarela = Pasarela::all()->pluck('id')->toArray();
        }
        if ($request->aplicacion == 'all') {
            $aplicacion = Aplicacion::all()->pluck('id')->toArray();
        }

        $servicios = Servicio::with('cliente', 'tarifa', 'pasarela', 'usuario', 'aplicaciones', 'activaciones')
             ->whereBetween('fecha_creacion', [$request->fecha_inicial, $request->fecha_final])
             ->whereHas('aplicaciones', function ($query) use ($aplicacion) {
                 $query->whereIn('id_aplicacion', $aplicacion);
             })
             ->whereIn('id_usuario', $vendedor)
             ->whereIn('id_pasarela', $pasarela)
             ->where('estado', '<>', 'Anulado')
             ->get();

        return Datatables::of($servicios)->toJson();
    }

    public function verVentas()
    {
        $user = auth()->user();

        if ($user->can('Ver ventas')) {
            return view('ventas');
        }
        abort(403);
    }

    public function verMisVentas()
    {
        $user = auth()->user();

        return view('mis_ventas', compact('user'));

        abort(403);
    }

    public function obtenerUsuariosVendedores()
    {
        $user = auth()->user();

        $usuarios = User::role('Vendedor')->where('id_empresa', $user->id_empresa)->get();

        return response()->json($usuarios);
    }
}
