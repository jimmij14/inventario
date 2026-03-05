<?php

namespace App\Http\Controllers;

use App\Models\EstadoEquipo;
use Illuminate\Http\Request;

class EstadoEquipoController extends Controller
{

    public function index()
    {
        $estados = EstadoEquipo::all();
        return view('estado_equipo.index', compact('estados'));
    }


    public function store(Request $request)
    {
        EstadoEquipo::create($request->all());

        return redirect()->route('estado_equipo.index');
    }


    public function update(Request $request, $id)
    {
        $estado = EstadoEquipo::findOrFail($id);

        $estado->update($request->all());

        return redirect()->route('estado_equipo.index');
    }


    public function destroy($id)
    {
        $estado = EstadoEquipo::findOrFail($id);

        $estado->delete();

        return redirect()->route('estado_equipo.index');
    }

}