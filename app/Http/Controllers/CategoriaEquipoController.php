<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\CategoriaEquipo;
use Illuminate\Http\Request;

class CategoriaEquipoController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all(); // Para mostrar en el select
        $categoriaEquipos = CategoriaEquipo::with('categoria')->get();
        return view('categoria_equipos.index', compact('categoriaEquipos', 'categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_categoria' => 'required|exists:categoria,id_categoria',
            'nombre_categoria_equipo' => 'required|unique:categoria_equipo,nombre_categoria_equipo',
            'descripcion' => 'nullable'
        ]);

        CategoriaEquipo::create($request->all());

        return redirect()->route('categoria_equipos.index')
            ->with('success', 'Categoría de equipo creada correctamente');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_categoria' => 'required|exists:categoria,id_categoria',
            'nombre_categoria_equipo' => 'required|unique:categoria_equipo,nombre_categoria_equipo,' . $id . ',id_categoria_equipo',
            'descripcion' => 'nullable'
        ]);

        $categoriaEquipo = CategoriaEquipo::findOrFail($id);
        $categoriaEquipo->update($request->all());

        return redirect()->route('categoria_equipos.index')
            ->with('success', 'Categoría de equipo actualizada correctamente');
    }

    public function destroy($id)
    {
        $categoriaEquipo = CategoriaEquipo::findOrFail($id);
        $categoriaEquipo->delete();

        return redirect()->route('categoria_equipos.index')
            ->with('success', 'Categoría de equipo eliminada correctamente');
    }
}