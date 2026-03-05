<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoEquipo extends Model
{
    protected $table = 'estado_equipo';
    protected $primaryKey = 'id_estado_equipo';
    public $timestamps = false;

    protected $fillable = [
        'nombre_estado',
        'descripcion'
    ];
}