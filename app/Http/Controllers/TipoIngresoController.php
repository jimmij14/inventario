<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoIngreso;
use Illuminate\Support\Facades\Cache;
use Barryvdh\DomPDF\Facade\Pdf;

class TipoIngresoController extends Controller
{
    public function index()
    {
        $tipos = Cache::remember('tipo_ingreso_listado', 60, fn() => TipoIngreso::all());
        return view('tipo_ingreso.index', compact('tipos'));
    }

    public function store(Request $request)
    {
        TipoIngreso::create([
            'nombre_tipo_ingreso' => $request->nombre_tipo_ingreso,
            'descripcion' => $request->descripcion
        ]);

        Cache::forget('tipo_ingreso_listado');

        return redirect()->route('tipo_ingreso.index');
    }

    public function update(Request $request, $id)
    {
        $tipo = TipoIngreso::findOrFail($id);

        $tipo->update([
            'nombre_tipo_ingreso' => $request->nombre_tipo_ingreso,
            'descripcion' => $request->descripcion
        ]);

        Cache::forget('tipo_ingreso_listado');

        return redirect()->route('tipo_ingreso.index');
    }

    public function destroy($id)
    {
        $tipo = TipoIngreso::findOrFail($id);
        $tipo->delete();

        Cache::forget('tipo_ingreso_listado');

        return redirect()->route('tipo_ingreso.index');
    }

    public function exportarPdf()
    {
        $tipos = TipoIngreso::all();

        $pdf = Pdf::loadView('tipo_ingreso.pdf', compact('tipos'));

        $pdf->getDomPDF()->getCanvas()->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
            $text = "Página {$pageNumber} de {$pageCount}";
            $font = $fontMetrics->getFont('DejaVu Sans', 'normal');
            $size = 9;
            $x = $canvas->get_width() - $fontMetrics->get_text_width($text, $font, $size) - 40;
            $y = $canvas->get_height() - 22;
            $canvas->text($x, $y, $text, $font, $size, [0.4, 0.4, 0.4]);
        });

        return $pdf->stream('listado_tipo_ingreso.pdf');
    }
}