<?php

namespace App\Http\Controllers;

use App\Models\CategoriaPersonal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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

}