<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Baja extends Model
{
    protected $table = 'baja';
    protected $primaryKey = 'id_baja';
    public $timestamps = false;

    protected $fillable = [
        'id_equipo_inventario',
        'fecha_baja',
        'descripcion',
        'id_usuario'
    ];

    public function inventario()
    {
        return $this->belongsTo(EquipoInventario::class, 'id_equipo_inventario');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

}
