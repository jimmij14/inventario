<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    protected $table = 'equipo';
    protected $primaryKey = 'id_equipo';

    protected $fillable = [
        'nombre_equipo',
        'serie',
        'imagen',
        'id_categoria_equipo',
        'id_marca',
        'id_modelo',
        'id_color',
        'descripcion'
    ];

    public $timestamps = false;

    public function categoriaEquipo()
    {
        return $this->belongsTo(CategoriaEquipo::class,'id_categoria_equipo');
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class,'id_marca');
    }

    public function modelo()
    {
        return $this->belongsTo(Modelo::class,'id_modelo');
    }

    public function color()
    {
        return $this->belongsTo(Color::class,'id_color');
    }

}


