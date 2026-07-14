<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Personal;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AreaController extends Controller
{

    public function index()
    {
        $areas = Area::with('responsable')->paginate(10);
        $personales = Personal::all();

        return view('areas.index', compact('areas','personales'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nombre_area' => 'required|unique:area,nombre_area',
            'abreviatura' => 'required|unique:area,abreviatura',
            'id_responsable' => 'required|exists:personal,id_personal'
        ]);

        Area::create($request->all());

        return redirect()->route('areas.index');
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_area' => 'required|unique:area,nombre_area,' . $id . ',id_area',
            'abreviatura' => 'required|unique:area,abreviatura,' . $id . ',id_area',
            'id_responsable' => 'required|exists:personal,id_personal'
        ]);

        $area = Area::findOrFail($id);
        $area->update($request->all());

        return redirect()->route('areas.index');
    }


    public function destroy($id)
    {
        $area = Area::findOrFail($id);
        $area->delete();

        return redirect()->route('areas.index');
    }

    public function exportarPdf()
    {
        $areas = Area::with('responsable')->get();

        $pdf = Pdf::loadView('areas.pdf', compact('areas'));

        $pdf->getDomPDF()->getCanvas()->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
            $text = "Página {$pageNumber} de {$pageCount}";
            $font = $fontMetrics->getFont('DejaVu Sans', 'normal');
            $size = 9;
            $x = $canvas->get_width() - $fontMetrics->get_text_width($text, $font, $size) - 40;
            $y = $canvas->get_height() - 22;
            $canvas->text($x, $y, $text, $font, $size, [0.4, 0.4, 0.4]);
        });

        return $pdf->stream('listado_areas.pdf');
    }

}