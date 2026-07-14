<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Movimiento;
use App\Models\DetalleMovimiento;
use App\Models\EquipoInventario;
use App\Models\Area;
use App\Models\EstadoEquipo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MovimientoController extends Controller
{
    // =========================
    // LISTAR + FORMULARIO
    // =========================
    public function index(Request $request)
    {
        $areas = Area::all();
        $estados = EstadoEquipo::sinBaja()->get();

        $query = Movimiento::with([
            'usuario',
            'areaAnterior',
            'areaDestino',
            'estadoAnterior',
            'estadoNuevo',
            'detalles.equipo.equipo'
        ]);

        // FILTRO POR CODIGO DE EQUIPO
        if ($request->filled('codigo')) {
            $query->whereHas('detalles.equipo', function ($q) use ($request) {
                $q->where('codigo_inventario', 'LIKE', '%' . $request->codigo . '%');
            });
        }

        // FILTRO POR AREA DESTINO
        if ($request->filled('area')) {
            $query->where('id_area_destino', $request->area);
        }

        // FILTRO POR ESTADO NUEVO
        if ($request->filled('estado')) {
            $query->where('id_estado_nuevo', $request->estado);
        }

        // FILTRO POR FECHA DESDE
        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_movimiento', '>=', $request->fecha_desde);
        }

        // FILTRO POR FECHA HASTA
        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_movimiento', '<=', $request->fecha_hasta);
        }

        $movimientos = $query->orderBy('fecha_movimiento', 'desc')->paginate(10);

        return view('movimientos.index', compact(
            'areas',
            'estados',
            'movimientos'
        ));
    }

    // =========================
    // BUSCAR EQUIPO POR CÓDIGO
    // =========================
    public function buscarEquipo(Request $request)
    {
        $request->validate([
            'codigo' => 'required'
        ]);

        $estadoBaja = EstadoEquipo::baja()->first();
        if (!$estadoBaja) {
            return response()->json([
                'success' => false,
                'message' => 'Estado Baja no encontrado'
            ]);
        }

        $equipo = EquipoInventario::with(['area', 'estado', 'equipo'])
            ->where('codigo_inventario', $request->codigo)
            ->where('id_estado_equipo', '!=', $estadoBaja->id_estado_equipo)
            ->first();

        if (!$equipo) {
            return response()->json([
                'success' => false,
                'message' => 'Equipo no encontrado'
            ]);
        }

        return response()->json([
            'success' => true,
            'equipo' => $equipo
        ]);
    }

    // =========================
    // REGISTRAR MOVIMIENTO
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'id_equipos' => 'required|array|min:1',
            'id_equipos.*' => 'required|integer|exists:equipo_inventario,id_equipo_inventario',
            'id_area_destino' => 'required|exists:area,id_area',
            'id_estado_nuevo' => 'required|exists:estado_equipo,id_estado_equipo',
            'descripcion' => 'nullable|string'
        ]);

        // El paso a "Baja" solo puede hacerse desde el módulo de Bajas (requiere depreciación, valor, motivo)
        $esBaja = EstadoEquipo::whereKey($request->id_estado_nuevo)->baja()->exists();
        if ($esBaja) {
            return back()->withInput()->withErrors([
                'id_estado_nuevo' => 'No se puede cambiar el estado a "Baja" desde Movimientos. Use el módulo de Bajas.'
            ]);
        }

        $equipos = EquipoInventario::whereIn('id_equipo_inventario', array_unique($request->id_equipos))->get();

        // Un movimiento implica cambiar de área; el estado sí puede mantenerse igual
        $yaEnDestino = $equipos->firstWhere('id_area', $request->id_area_destino);
        if ($yaEnDestino) {
            return back()->withInput()->withErrors([
                'id_area_destino' => "El equipo {$yaEnDestino->codigo_inventario} ya está en el área destino."
            ]);
        }

        DB::transaction(function () use ($request, $equipos) {
            // Se agrupan por área/estado de origen: el registro de movimiento solo
            // guarda un área/estado "anterior", así que si el lote mezcla equipos
            // que venían de distintos lugares, se generan varios movimientos (uno
            // por origen) en la misma operación, sin perder precisión en el historial.
            $grupos = $equipos->groupBy(fn ($equipo) => $equipo->id_area . '-' . $equipo->id_estado_equipo);

            foreach ($grupos as $grupo) {
                $origen = $grupo->first();

                // =========================
                // CREAR MOVIMIENTO
                // =========================
                $movimiento = Movimiento::create([
                    'fecha_movimiento' => now(),
                    'id_area_anterior' => $origen->id_area,
                    'id_estado_anterior' => $origen->id_estado_equipo,
                    'id_area_destino' => $request->id_area_destino,
                    'id_estado_nuevo' => $request->id_estado_nuevo,
                    'descripcion' => $request->descripcion,
                    'user_id' => Auth::id()
                ]);

                foreach ($grupo as $equipo) {
                    // =========================
                    // DETALLE MOVIMIENTO
                    // =========================
                    DetalleMovimiento::create([
                        'id_movimiento' => $movimiento->id_movimiento,
                        'id_equipo_inventario' => $equipo->id_equipo_inventario
                    ]);

                    // =========================
                    // ACTUALIZAR EQUIPO
                    // =========================
                    $equipo->update([
                        'id_area' => $request->id_area_destino,
                        'id_estado_equipo' => $request->id_estado_nuevo
                    ]);
                }
            }
        });

        return redirect()->route('movimientos.index')
            ->with('success', 'Movimiento registrado correctamente');
    }
}