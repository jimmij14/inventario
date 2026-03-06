<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaEquipo extends Model
{
    protected $table = 'categoria_equipo';
    protected $primaryKey = 'id_categoria_equipo';
    public $timestamps = false;

    protected $fillable = [
        'id_categoria',
        'nombre_categoria_equipo',
        'descripcion'
    ];

    // Relación con categoria
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria', 'id_categoria');
    }
}