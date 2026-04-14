<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Baja;
use App\Models\EquipoInventario;
use App\Models\EstadoEquipo;
use Illuminate\Support\Facades\Auth;


class BajaController extends Controller
{
    public function index(Request $request)
    {

        $query = Baja::with([
            'inventario.equipo',
            'inventario.area',
            'inventario.area.responsable',
            'usuario'
        ]);

        // BUSCAR POR CODIGO
        if ($request->buscar) {
            $query->whereHas('inventario', function ($q) use ($request) {
                $q->where('codigo_inventario', 'LIKE', '%' . $request->buscar . '%');
            });
        }

        // FILTRAR POR AREA
        if ($request->area) {
            $query->whereHas('inventario', function ($q) use ($request) {
                $q->where('id_area', $request->area);
            });
        }

        $bajas = $query->paginate(10);

        // AREAS PARA EL FILTRO
        $areas = \App\Models\Area::all();

        return view('bajas.index', compact('bajas','areas'));

    }


    public function store(Request $request)
    {

        // buscar el inventario para obtener id_area
        $inventario = EquipoInventario::find($request->id_equipo_inventario);

        // registrar la baja
        Baja::create([
            'id_equipo_inventario' => $request->id_equipo_inventario,
            'depreciacion' => $request->depreciacion,
            'valor_baja' => $request->valor_baja,
            'fecha_baja' => $request->fecha_baja,
            'motivo' => $request->motivo,
            'descripcion' => $request->descripcion,
            'id_area' => $inventario->id_area,
            'id_usuario' => Auth::id()
        ]);

        // buscar estado "Baja"
        $estadoBaja = EstadoEquipo::where('nombre_estado', 'Baja')->first();

        // actualizar estado del equipo en inventario
        $inventario->id_estado_equipo = $estadoBaja->id_estado_equipo;
        $inventario->save();

        return redirect()->back()->with('success','Equipo dado de baja correctamente');

    }

    public function restaurar($id)
    {

        $baja = Baja::findOrFail($id);

        $inventario = $baja->inventario;

        // buscar estado ACTIVO
        $estadoActivo = EstadoEquipo::where('nombre_estado', 'ACTIVO')->first();

        // cambiar estado del equipo
        $inventario->id_estado_equipo = $estadoActivo->id_estado_equipo;
        $inventario->save();

        // eliminar registro de baja
        $baja->delete();

        return redirect()->route('bajas.index')
            ->with('success', 'Equipo restaurado correctamente');

    }


}

