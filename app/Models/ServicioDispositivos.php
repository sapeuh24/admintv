<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicioDispositivos extends Model
{
    use HasFactory;

    protected $table = 'servicio_dispositivos';

    protected $fillable = [
        'id_servicio',
        'id_dispositivo',
    ];
}