<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eleccion2026 extends Model
{
    protected $fillable =[
        'nombre',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'fecha_cierre_real',

    ];

    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
        'fecha_cierre_real' => 'datetime',
    ];
}
