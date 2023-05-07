<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Servicio;
use App\Models\Activacion;

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
        //i need a method that return all activaciones of Activacion model that are not expired in the fecha_fin field, if the fecha fin have 5 days or less to expire,
        // i need to send a notification to the user that have that activacion in the table servicios, and the notification must be send to the user email and to the user phone number,
        // the notification must be send with the name of the service and the date of the expiration, and the notification must be send 5 days before the expiration date.
        $activaciones = Activacion::where('fecha_fin', '<=', now()->addDays(5))
        ->with('servicio')
        ->limit(10)
        ->get();

        $servicios = [];

        foreach ($activaciones as $activacion) {
            $servicios[] = $activacion->servicio;
        }

        $servicios = Servicio::whereIn('id', $servicios)->with('cliente')->get();

        //seend a mail with Mail class

        foreach ($servicios as $servicio) {
            $user = User::find($servicio->cliente->id_usuario);
            Mail::to($user->email)->send(new Activaciones($servicio));
        }

        dd($servicios);
    }
}
