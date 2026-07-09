<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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
}