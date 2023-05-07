<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activacion extends Model
{
    use HasFactory;

    protected $table = 'activaciones';

    protected $fillable = [
        'servicio',
        'creditos',
        'fecha_inicio',
        'fecha_fin',
    ];

    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'servicio');
    }
}
