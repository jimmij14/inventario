<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Barryvdh\DomPDF\Facade\Pdf;

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

    public function exportarPdf()
    {
        $categorias = Categoria::all();

        $pdf = Pdf::loadView('categorias.pdf', compact('categorias'));

        $pdf->getDomPDF()->getCanvas()->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
            $text = "Página {$pageNumber} de {$pageCount}";
            $font = $fontMetrics->getFont('DejaVu Sans', 'normal');
            $size = 9;
            $x = $canvas->get_width() - $fontMetrics->get_text_width($text, $font, $size) - 40;
            $y = $canvas->get_height() - 22;
            $canvas->text($x, $y, $text, $font, $size, [0.4, 0.4, 0.4]);
        });

        return $pdf->stream('listado_categorias.pdf');

        // Alternativa: si quieres que se descargue en vez de ver en el navegador:
        // return $pdf->download('listado_categorias.pdf');
    }
}