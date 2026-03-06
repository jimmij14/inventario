<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'area';
    protected $primaryKey = 'id_area';
    public $timestamps = false;

    protected $fillable = [
        'nombre_area',
        'abreviatura',
        'id_responsable',
        'descripcion'
    ];

    public function responsable()
    {
        return $this->belongsTo(
            Personal::class,
            'id_responsable',
            'id_personal'
        );
    }
}