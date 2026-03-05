<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{

    // Mostrar marcas
    public function index()
    {
        $marcas = Marca::all();
        return view('marcas.index', compact('marcas'));
    }

    // Guardar marca
    public function store(Request $request)
    {
        $request->validate([
            'nombre_marca' => 'required|unique:marca,nombre_marca',
            'descripcion' => 'nullable'
        ]);

        Marca::create($request->all());

        return redirect()->route('marcas.index');
    }

    // Actualizar marca
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_marca' => 'required|unique:marca,nombre_marca,' . $id . ',id_marca',
            'descripcion' => 'nullable'
        ]);

        $marca = Marca::findOrFail($id);
        $marca->update($request->all());

        return redirect()->route('marcas.index');
    }

    // Eliminar marca
    public function destroy($id)
    {
        $marca = Marca::findOrFail($id);
        $marca->delete();

        return redirect()->route('marcas.index');
    }
}