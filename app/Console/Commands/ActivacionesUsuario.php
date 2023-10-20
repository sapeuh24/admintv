<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Servicio;
use App\Models\Activacion;
use Carbon\Carbon;
use App\Mail\Activaciones as ActivacionesUsuarioMail;
use Mail;

class ActivacionesUsuario extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ActivacionesUsuario';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para actualización de activaciones de usuarios';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $activaciones = Activacion::whereDate('fecha_fin', '>=', Carbon::today())
    ->whereDate('fecha_fin', '<=', Carbon::today()->addDays(5))
    ->select('id', 'servicio', 'fecha_fin')
    ->get();

$usuariosAgrupados = [];

foreach ($activaciones as $activacion) {
    $servicio = Servicio::find($activacion->servicio);

    if ($servicio) {
        $idUsuario = $servicio->id_usuario;
        $usuario = $servicio->usuario->email;
        $cliente = $servicio->cliente ? $servicio->cliente->nombre : null;
        $fecha_fin = $activacion->fecha_fin;

        if (!isset($usuariosAgrupados[$idUsuario])) {
            $usuariosAgrupados[$idUsuario] = [];
        }

        $usuariosAgrupados[$idUsuario][] = [
            'id_activacion' => $activacion->id,
            'id_servicio' => $activacion->servicio,
            'cliente' => $cliente,
            'fecha_fin' => $fecha_fin,
            'usuario' => $usuario
        ];
    } else {

        $idServicioError = $activacion->servicio;
    }
}

foreach ($usuariosAgrupados as $activ) {
    $correo = new ActivacionesUsuarioMail($activ);
    Mail::to($activ[0]['usuario'])->send($correo);
}
    }
}