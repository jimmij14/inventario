<?php

namespace App\Http\Controllers;

use App\Models\CategoriaPersonal;
use Illuminate\Http\Request;

class CategoriaPersonalController extends Controller
{

    public function index()
    {
        $categorias_personal = CategoriaPersonal::all();
        return view('categoria_personal.index', compact('categorias_personal'));
    }


    public function store(Request $request)
    {
        CategoriaPersonal::create($request->all());

        return redirect()->route('categoria_personal.index');
    }


    public function update(Request $request, $id)
    {
        $categoria = CategoriaPersonal::findOrFail($id);

        $categoria->update($request->all());

        return redirect()->route('categoria_personal.index');
    }


    public function destroy($id)
    {
        $categoria = CategoriaPersonal::findOrFail($id);

        $categoria->delete();

        return redirect()->route('categoria_personal.index');
    }

}