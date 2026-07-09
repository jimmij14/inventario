<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Barryvdh\DomPDF\Facade\Pdf;

class ModeloController extends Controller
{
    // Mostrar lista
    public function index()
    {
        $modelos = Cache::remember('modelos_listado', 60, fn() => Modelo::all());
        return view('modelos.index', compact('modelos'));
    }

    // Guardar nuevo
    public function store(Request $request)
    {
        $request->validate([
            'nombre_modelo' => 'required|unique:modelo,nombre_modelo',
            'descripcion' => 'nullable'
        ]);

        Modelo::create($request->all());

        Cache::forget('modelos_listado');
        Cache::forget('modelos');

        return redirect()->route('modelos.index')
            ->with('success', 'Modelo creado correctamente');
    }

    // Actualizar
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_modelo' => 'required|unique:modelo,nombre_modelo,' . $id . ',id_modelo',
            'descripcion' => 'nullable'
        ]);

        $modelo = Modelo::findOrFail($id);
        $modelo->update($request->all());

        Cache::forget('modelos_listado');
        Cache::forget('modelos');

        return redirect()->route('modelos.index')
            ->with('success', 'Modelo actualizado correctamente');
    }

    // Eliminar
    public function destroy($id)
    {
        $modelo = Modelo::findOrFail($id);
        $modelo->delete();

        Cache::forget('modelos_listado');
        Cache::forget('modelos');

        return redirect()->route('modelos.index')
            ->with('success', 'Modelo eliminado correctamente');
    }

    public function exportarPdf()
    {
        $modelos = Modelo::all();

        $pdf = Pdf::loadView('modelos.pdf', compact('modelos'));

        $pdf->getDomPDF()->getCanvas()->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
            $text = "Página {$pageNumber} de {$pageCount}";
            $font = $fontMetrics->getFont('DejaVu Sans', 'normal');
            $size = 9;
            $x = $canvas->get_width() - $fontMetrics->get_text_width($text, $font, $size) - 40;
            $y = $canvas->get_height() - 22;
            $canvas->text($x, $y, $text, $font, $size, [0.4, 0.4, 0.4]);
        });

        return $pdf->stream('listado_modelos.pdf');
    }
}