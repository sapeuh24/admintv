<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoAbono extends Model
{
    use HasFactory;

    protected $table = 'estado_abonos';

    protected $fillable = [
        'estado_abono',
        'id_abono',
    ];

    public function servicio()
    {
        return $this->belongsTo(Abono::class);
    }
}
