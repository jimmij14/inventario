<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipoInventario extends Model
{
    use HasFactory;

    protected $table = 'equipo_inventario';

    protected $primaryKey = 'id_equipo_inventario';

    public $timestamps = false;

    protected $fillable = [
        'codigo_inventario',
        'id_equipo',
        'id_area',
        'id_estado_equipo',
        'id_tipo_ingreso',
        'id_proveedor',
        'user_id',
        'precio_compra',
        'fecha_compra',
        'tipo_documento',
        'documento',
        'fecha_registro',
        'observaciones'
    ];


    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'id_equipo');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'id_area');
    }

    public function estado()
    {
        return $this->belongsTo(EstadoEquipo::class, 'id_estado_equipo');
    }

    public function tipoIngreso()
    {
        return $this->belongsTo(TipoIngreso::class, 'id_tipo_ingreso');
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}