<?php

namespace App\Http\Controllers;

use App\Models\EstadoEquipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Barryvdh\DomPDF\Facade\Pdf;

class EstadoEquipoController extends Controller
{

    public function index()
    {
        $estados = Cache::remember('estado_equipo_listado', 60, fn() => EstadoEquipo::all());
        return view('estado_equipo.index', compact('estados'));
    }


    public function store(Request $request)
    {
        EstadoEquipo::create($request->all());

        Cache::forget('estado_equipo_listado');

        return redirect()->route('estado_equipo.index');
    }


    public function update(Request $request, $id)
    {
        $estado = EstadoEquipo::findOrFail($id);

        $estado->update($request->all());

        Cache::forget('estado_equipo_listado');

        return redirect()->route('estado_equipo.index');
    }


    public function destroy($id)
    {
        $estado = EstadoEquipo::findOrFail($id);

        $estado->delete();

        Cache::forget('estado_equipo_listado');

        return redirect()->route('estado_equipo.index');
    }

    public function exportarPdf()
    {
        $estados = EstadoEquipo::all();

        $pdf = Pdf::loadView('estado_equipo.pdf', compact('estados'));

        $pdf->getDomPDF()->getCanvas()->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
            $text = "Página {$pageNumber} de {$pageCount}";
            $font = $fontMetrics->getFont('DejaVu Sans', 'normal');
            $size = 9;
            $x = $canvas->get_width() - $fontMetrics->get_text_width($text, $font, $size) - 40;
            $y = $canvas->get_height() - 22;
            $canvas->text($x, $y, $text, $font, $size, [0.4, 0.4, 0.4]);
        });

        return $pdf->stream('listado_estado_equipo.pdf');
    }

}