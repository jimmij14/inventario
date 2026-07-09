<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Color;
use Illuminate\Support\Facades\Cache;
use Barryvdh\DomPDF\Facade\Pdf;

class ColorController extends Controller
{

    public function index()
    {
        $colores = Cache::remember('colores_listado', 60, fn() => Color::all());
        return view('colores.index', compact('colores'));
    }

    public function store(Request $request)
    {
        Color::create($request->all());

        Cache::forget('colores_listado');
        Cache::forget('colores');

        return redirect()->route('colores.index')
            ->with('success','Color registrado correctamente');
    }

    public function update(Request $request, $id)
    {
        $color = Color::findOrFail($id);
        $color->update($request->all());

        Cache::forget('colores_listado');
        Cache::forget('colores');

        return redirect()->route('colores.index')
            ->with('success','Color actualizado correctamente');
    }

    public function destroy($id)
    {
        $color = Color::findOrFail($id);
        $color->delete();

        Cache::forget('colores_listado');
        Cache::forget('colores');

        return redirect()->route('colores.index')
            ->with('success','Color eliminado correctamente');
    }

    public function exportarPdf()
    {
        $colores = Color::all();

        $pdf = Pdf::loadView('colores.pdf', compact('colores'));

        $pdf->getDomPDF()->getCanvas()->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
            $text = "Página {$pageNumber} de {$pageCount}";
            $font = $fontMetrics->getFont('DejaVu Sans', 'normal');
            $size = 9;
            $x = $canvas->get_width() - $fontMetrics->get_text_width($text, $font, $size) - 40;
            $y = $canvas->get_height() - 22;
            $canvas->text($x, $y, $text, $font, $size, [0.4, 0.4, 0.4]);
        });

        return $pdf->stream('listado_colores.pdf');
    }
}