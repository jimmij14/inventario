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

    // Compara sin importar mayúsculas/espacios, porque el nombre es editable desde Mantenimiento
    public function scopeBaja($query)
    {
        return $query->whereRaw('LOWER(TRIM(nombre_estado)) = ?', ['baja']);
    }

    public function scopeSinBaja($query)
    {
        return $query->whereRaw('LOWER(TRIM(nombre_estado)) != ?', ['baja']);
    }
}