<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoIngreso;

class TipoIngresoController extends Controller
{
    public function index()
    {
        $tipos = TipoIngreso::all();
        return view('tipo_ingreso.index', compact('tipos'));
    }

    public function store(Request $request)
    {
        TipoIngreso::create([
            'nombre_tipo_ingreso' => $request->nombre_tipo_ingreso,
            'descripcion' => $request->descripcion
        ]);

        return redirect()->route('tipo_ingreso.index');
    }

    public function update(Request $request, $id)
    {
        $tipo = TipoIngreso::findOrFail($id);

        $tipo->update([
            'nombre_tipo_ingreso' => $request->nombre_tipo_ingreso,
            'descripcion' => $request->descripcion
        ]);

        return redirect()->route('tipo_ingreso.index');
    }

    public function destroy($id)
    {
        $tipo = TipoIngreso::findOrFail($id);
        $tipo->delete();

        return redirect()->route('tipo_ingreso.index');
    }
}