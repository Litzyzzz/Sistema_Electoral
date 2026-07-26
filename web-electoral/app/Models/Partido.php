<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partido extends Model
{
    protected $primaryKey = 'id_partido';

    public $timestamps = false;

    protected $fillable = [
        'nombre_partido',
        'bandera',
        'nombre_candidato',
        'rostro_candidato',
        'descripcion'
    ];

    public function votos()
    {
        return $this->hasMany(Voto::class, 'id_partido'); 
    }
}
