<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    protected $table = 'personal';
    protected $primaryKey = 'id_personal';
    public $timestamps = false;

    protected $fillable = [
        'dni',
        'nombre_completo',
        'correo',
        'telefono',
        'id_categoria_personal',
        'descripcion'
    ];

    public function categoriaPersonal()
    {
        return $this->belongsTo(
            CategoriaPersonal::class,
            'id_categoria_personal',
            'id_categoria_personal'
        );
    }

    public function areas()
    {
        return $this->hasMany(
            Area::class,
            'id_responsable',
            'id_personal'
        );
    }
}