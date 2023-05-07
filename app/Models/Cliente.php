<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'fecha_creacion',
        'telefono',
        'facebook_enlace',
        'email',
        'notas',
        'slug',
        'id_ciudad',
        'id_usuario',
        'id_empresa',
    ];

    public $timestamps = false;

    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class);
    }

    public function servicios()
    {
        return $this->hasMany(Servicio::class, 'id_cliente');
    }
}