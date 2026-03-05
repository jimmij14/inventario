<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaPersonal extends Model
{
    protected $table = 'categoria_personal';
    protected $primaryKey = 'id_categoria_personal';
    public $timestamps = false;

    protected $fillable = [
        'nombre_categoria_personal',
        'descripcion'
    ];
}