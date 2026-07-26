<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voto extends Model
{
    protected $primaryKey = 'id_voto';

    public $timestamps = false;

    protected $fillable = [
        'id_partido',
        'tipo_vista', 
        'fecha_votado'
    ];

    public function partido()
    {
        return $this->belongsTo(Partido::class, 'id_partido');
    }

}
