<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Votante extends Model
{
    protected $primaryKey = 'id_votante';

    public $timestamps = false;

    protected $fillable = [
        'codigo_estudiante',
        'nombres',
        'apellidos',
        'ha_votado',
        'fecha_voto',
        'puede_ver_resultados'
    ];
}
