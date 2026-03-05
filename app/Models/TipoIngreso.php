<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoIngreso extends Model
{
    protected $table = 'tipo_ingreso';
    protected $primaryKey = 'id_tipo_ingreso';
    public $timestamps = false;

    protected $fillable = [
        'nombre_tipo_ingreso',
        'descripcion'
    ];
}