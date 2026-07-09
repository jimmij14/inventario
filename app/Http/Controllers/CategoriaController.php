<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CategoriaController extends Controller
{
    // Mostrar lista de categorias
    public function index()
    {
        $categorias = Categoria::all();
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

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría actualizada correctamente');
    }

    // Eliminar categoria
    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->delete();

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría eliminada correctamente');
    }

    public function exportarPdf()
{
    $categorias = Categoria::all();

    $pdf = Pdf::loadView('categorias.pdf', compact('categorias'));

    return $pdf->stream('listado_categorias.pdf');


    // Alternativa: si quieres que se descargue en vez de ver en el navegador:
    // return $pdf->download('listado_categorias.pdf');
}
}