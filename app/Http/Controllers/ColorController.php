<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Color;
use Illuminate\Support\Facades\Cache;

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
}