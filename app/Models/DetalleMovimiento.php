<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleMovimiento extends Model
{
    protected $table = 'detalle_movimiento';
    public $timestamps = false;

    protected $fillable = [
        'id_movimiento',
        'id_equipo_inventario'
    ];

    public function movimiento()
    {
        return $this->belongsTo(Movimiento::class, 'id_movimiento');
    }

    public function equipo()
    {
        return $this->belongsTo(EquipoInventario::class, 'id_equipo_inventario');
    }
}