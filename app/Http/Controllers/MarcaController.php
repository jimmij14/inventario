<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Barryvdh\DomPDF\Facade\Pdf;

class MarcaController extends Controller
{

    // Mostrar marcas
    public function index()
    {
        $marcas = Cache::remember('marcas_listado', 60, fn() => Marca::all());
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

        Cache::forget('marcas_listado');
        Cache::forget('marcas');

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

        Cache::forget('marcas_listado');
        Cache::forget('marcas');

        return redirect()->route('marcas.index');
    }

    // Eliminar marca
    public function destroy($id)
    {
        $marca = Marca::findOrFail($id);
        $marca->delete();

        Cache::forget('marcas_listado');
        Cache::forget('marcas');

        return redirect()->route('marcas.index');
    }

    public function exportarPdf()
    {
        $marcas = Marca::all();

        $pdf = Pdf::loadView('marcas.pdf', compact('marcas'));

        $pdf->getDomPDF()->getCanvas()->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
            $text = "Página {$pageNumber} de {$pageCount}";
            $font = $fontMetrics->getFont('DejaVu Sans', 'normal');
            $size = 9;
            $x = $canvas->get_width() - $fontMetrics->get_text_width($text, $font, $size) - 40;
            $y = $canvas->get_height() - 22;
            $canvas->text($x, $y, $text, $font, $size, [0.4, 0.4, 0.4]);
        });

        return $pdf->stream('listado_marcas.pdf');
    }
}