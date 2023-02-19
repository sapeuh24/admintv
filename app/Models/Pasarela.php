<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasarela extends Model
{
    use HasFactory;

    protected $table = 'pasarelas';

    protected $fillable = [
        'nombre',
    ];

    public $timestamps = false;

    public function servicios()
    {
        return $this->hasMany(Servicio::class, 'id_pasarela');
    }
}