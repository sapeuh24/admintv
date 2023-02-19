<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    protected $table = 'servicios';

    protected $fillable = [
        'id_tarifa',
        'id_cliente',
        'id_pasarela',
        'id_usuario',
        'fecha_creacion',
        'creditos_restantes',
        'estado'
    ];

    public $timestamps = false;

    public function tarifa()
    {
        return $this->belongsTo(Tarifa::class, 'id_tarifa');
    }

    public function activaciones()
    {
        return $this->hasMany(Activacion::class, 'servicio');
    }

    public function dispositivos()
    {
        return $this->belongsToMany(Dispositivo::class, 'servicio_dispositivos', 'id_servicio', 'id_dispositivo');
    }

    public function aplicaciones()
    {
        return $this->belongsToMany(Aplicacion::class, 'servicio_aplicaciones', 'id_servicio', 'id_aplicacion');
    }

    public function pasarela()
    {
        return $this->belongsTo(Pasarela::class, 'id_pasarela');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
