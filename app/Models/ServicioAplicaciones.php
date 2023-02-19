<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicioAplicaciones extends Model
{
    use HasFactory;

    protected $table = 'servicio_aplicaciones';

    protected $fillable = [
        'id_servicio',
        'id_aplicacion',
    ];
}