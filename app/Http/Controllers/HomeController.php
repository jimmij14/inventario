<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\EquipoInventario; 
use App\Models\Area;
use App\Models\Personal;
use App\Models\Movimiento;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        try {

            $data = Cache::remember('dashboard_data', 60, function () {

                return [
                    'totalEquipos' => EquipoInventario::count(),
                    'totalAreas' => Area::count(),
                    'totalPersonal' => Personal::count(),
                    'totalMovimientos' => Movimiento::count(),

                    'equiposPorEstado' => EquipoInventario::join(
                            'estado_equipo',
                            'equipo_inventario.id_estado_equipo',
                            '=',
                            'estado_equipo.id_estado_equipo'
                        )
                        ->selectRaw('estado_equipo.nombre_estado as estado, COUNT(*) as total')
                        ->groupBy('estado_equipo.nombre_estado')
                        ->get(),

                    'equiposPorArea' => EquipoInventario::join(
                            'area',
                            'equipo_inventario.id_area',
                            '=',
                            'area.id_area'
                        )
                        ->selectRaw('area.nombre_area as area, COUNT(*) as total')
                        ->groupBy('area.nombre_area')
                        ->get()
                ];
            });

        } catch (\Exception $e) {
            $data = [
                'totalEquipos' => 0,
                'totalAreas' => 0,
                'totalPersonal' => 0,
                'totalMovimientos' => 0,
                'equiposPorEstado' => collect(),
                'equiposPorArea' => collect()
            ];
        }

        return view('home', $data);
    }  
}