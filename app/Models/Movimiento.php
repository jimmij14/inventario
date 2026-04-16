<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    protected $table = 'movimiento';
    protected $primaryKey = 'id_movimiento';
    public $timestamps = false;

    protected $fillable = [
        'fecha_movimiento',
        'id_area_anterior',
        'id_estado_anterior',
        'id_area_destino',
        'id_estado_nuevo',
        'descripcion',
        'user_id'
    ];



    public function detalles()
    {
        return $this->hasMany(DetalleMovimiento::class, 'id_movimiento');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function areaAnterior()
    {
        return $this->belongsTo(Area::class, 'id_area_anterior');
    }

    public function areaDestino()
    {
        return $this->belongsTo(Area::class, 'id_area_destino');
    }

    public function estadoAnterior()
    {
        return $this->belongsTo(EstadoEquipo::class, 'id_estado_anterior');
    }

    public function estadoNuevo()
    {
        return $this->belongsTo(EstadoEquipo::class, 'id_estado_nuevo');
    }
}