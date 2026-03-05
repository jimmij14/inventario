<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Color;

class ColorController extends Controller
{

    public function index()
    {
        $colores = Color::all();
        return view('colores.index', compact('colores'));
    }

    public function store(Request $request)
    {
        Color::create($request->all());

        return redirect()->route('colores.index')
            ->with('success','Color registrado correctamente');
    }

    public function update(Request $request, $id)
    {
        $color = Color::findOrFail($id);
        $color->update($request->all());

        return redirect()->route('colores.index')
            ->with('success','Color actualizado correctamente');
    }

    public function destroy($id)
    {
        $color = Color::findOrFail($id);
        $color->delete();

        return redirect()->route('colores.index')
            ->with('success','Color eliminado correctamente');
    }
}