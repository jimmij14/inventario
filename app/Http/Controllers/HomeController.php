<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
            // 🔹 CONTADORES PRINCIPALES
            $totalEquipos = EquipoInventario::count();
            $totalAreas = Area::count();
            $totalPersonal = Personal::count();
            $totalMovimientos = Movimiento::count();

        } catch (\Exception $e) {
            $totalEquipos = 0;
            $totalAreas = 0;
            $totalPersonal = 0;
            $totalMovimientos = 0;
        }

        return view('home', compact(
            'totalEquipos',
            'totalAreas',
            'totalPersonal',
            'totalMovimientos'
        ));

        
    }   
}