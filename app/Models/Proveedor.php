<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedor';
    protected $primaryKey = 'id_proveedor';
    public $timestamps = false;

    protected $fillable = [
        'ruc',
        'razon_social',
        'nombre_comercial',
        'telefono',
        'correo',
        'direccion',
        'descripcion'
    ];
}