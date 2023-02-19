<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $table = 'logs';

    protected $fillable = [
        'tabla',
        'accion',
        'fecha',
        'registro_id',
        'user_id',
    ];

    public static function saveLogs($tabla, $accion, $registro_id)
    {
        $user = auth()->user();
        Log::create([
            'tabla' => $tabla,
            'accion' => $accion,
            'fecha' => date('Y-m-d'),
            'registro_id' => $registro_id,
            'user_id' => $user->id,
        ]);
    }

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}