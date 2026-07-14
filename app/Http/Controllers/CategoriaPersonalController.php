<?php

namespace App\Http\Controllers;

use App\Models\CategoriaPersonal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Barryvdh\DomPDF\Facade\Pdf;

class CategoriaPersonalController extends Controller
{

    public function index()
    {
        $categorias_personal = Cache::remember('categoria_personal_listado', 60, fn() => CategoriaPersonal::all());
        return view('categoria_personal.index', compact('categorias_personal'));
    }


    public function store(Request $request)
    {
        CategoriaPersonal::create($request->all());

        Cache::forget('categoria_personal_listado');

        return redirect()->route('categoria_personal.index');
    }


    public function update(Request $request, $id)
    {
        $categoria = CategoriaPersonal::findOrFail($id);

        $categoria->update($request->all());

        Cache::forget('categoria_personal_listado');

        return redirect()->route('categoria_personal.index');
    }


    public function destroy($id)
    {
        $categoria = CategoriaPersonal::findOrFail($id);

        $categoria->delete();

        Cache::forget('categoria_personal_listado');

        return redirect()->route('categoria_personal.index');
    }

    public function exportarPdf()
    {
        $categorias_personal = CategoriaPersonal::all();

        $pdf = Pdf::loadView('categoria_personal.pdf', compact('categorias_personal'));

        $pdf->getDomPDF()->getCanvas()->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
            $text = "Página {$pageNumber} de {$pageCount}";
            $font = $fontMetrics->getFont('DejaVu Sans', 'normal');
            $size = 9;
            $x = $canvas->get_width() - $fontMetrics->get_text_width($text, $font, $size) - 40;
            $y = $canvas->get_height() - 22;
            $canvas->text($x, $y, $text, $font, $size, [0.4, 0.4, 0.4]);
        });

        return $pdf->stream('listado_categoria_personal.pdf');
    }

}