<?php

namespace App\Http\Controllers;

use App\Models\EstadoEquipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class EstadoEquipoController extends Controller
{

    public function index()
    {
        $estados = Cache::remember('estado_equipo_listado', 60, fn() => EstadoEquipo::all());
        return view('estado_equipo.index', compact('estados'));
    }


    public function store(Request $request)
    {
        EstadoEquipo::create($request->all());

        Cache::forget('estado_equipo_listado');

        return redirect()->route('estado_equipo.index');
    }


    public function update(Request $request, $id)
    {
        $estado = EstadoEquipo::findOrFail($id);

        $estado->update($request->all());

        Cache::forget('estado_equipo_listado');

        return redirect()->route('estado_equipo.index');
    }


    public function destroy($id)
    {
        $estado = EstadoEquipo::findOrFail($id);

        $estado->delete();

        Cache::forget('estado_equipo_listado');

        return redirect()->route('estado_equipo.index');
    }

}