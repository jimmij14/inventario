<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\CategoriaEquipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Barryvdh\DomPDF\Facade\Pdf;

class CategoriaEquipoController extends Controller
{
    public function index()
    {
        $categorias = Cache::remember('categorias_listado', 60, fn() => Categoria::all()); // Para mostrar en el select
        $categoriaEquipos = Cache::remember('categoria_equipos_listado', 60, fn() => CategoriaEquipo::with('categoria')->get());
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

        Cache::forget('categoria_equipos_listado');
        Cache::forget('categorias');

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

        Cache::forget('categoria_equipos_listado');
        Cache::forget('categorias');

        return redirect()->route('categoria_equipos.index')
            ->with('success', 'Categoría de equipo actualizada correctamente');
    }

    public function destroy($id)
    {
        $categoriaEquipo = CategoriaEquipo::findOrFail($id);
        $categoriaEquipo->delete();

        Cache::forget('categoria_equipos_listado');
        Cache::forget('categorias');

        return redirect()->route('categoria_equipos.index')
            ->with('success', 'Categoría de equipo eliminada correctamente');
    }

    public function exportarPdf()
    {
        $categoriaEquipos = CategoriaEquipo::with('categoria')->get();

        $pdf = Pdf::loadView('categoria_equipos.pdf', compact('categoriaEquipos'));

        $pdf->getDomPDF()->getCanvas()->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
            $text = "Página {$pageNumber} de {$pageCount}";
            $font = $fontMetrics->getFont('DejaVu Sans', 'normal');
            $size = 9;
            $x = $canvas->get_width() - $fontMetrics->get_text_width($text, $font, $size) - 40;
            $y = $canvas->get_height() - 22;
            $canvas->text($x, $y, $text, $font, $size, [0.4, 0.4, 0.4]);
        });

        return $pdf->stream('listado_categoria_equipos.pdf');
    }
}