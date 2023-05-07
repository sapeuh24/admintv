<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abono extends Model
{
    use HasFactory;

    protected $fillable = [
        'abono',
        'id_servicio',
        'fecha',
        'hora',
        'estado',
    ];

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }
}
