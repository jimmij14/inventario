<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CategoriaController extends Controller
{
    // Mostrar lista de categorias
    public function index()
    {
        $categorias = Cache::remember('categorias_listado', 60, fn() => Categoria::all());
        return view('categorias.index', compact('categorias'));
    }

    // Guardar nueva categoria
    public function store(Request $request)
    {
        $request->validate([
            'nombre_categoria' => 'required|unique:categoria,nombre_categoria',
            'descripcion' => 'nullable'
        ]);

        Categoria::create($request->all());

        Cache::forget('categorias_listado');

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría creada correctamente');
    }

    // Actualizar categoria
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_categoria' => 'required|unique:categoria,nombre_categoria,' . $id . ',id_categoria',
            'descripcion' => 'nullable'
        ]);

        $categoria = Categoria::findOrFail($id);
        $categoria->update($request->all());

        Cache::forget('categorias_listado');

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría actualizada correctamente');
    }

    // Eliminar categoria
    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->delete();

        Cache::forget('categorias_listado');

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría eliminada correctamente');
    }
}