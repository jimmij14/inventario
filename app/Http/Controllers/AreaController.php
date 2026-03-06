<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Personal;
use Illuminate\Http\Request;

class AreaController extends Controller
{

    public function index()
    {
        $areas = Area::with('responsable')->get();
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

}