<?php

namespace App\Http\Controllers;

use App\Models\Personal;
use App\Models\CategoriaPersonal;
use Illuminate\Http\Request;

class PersonalController extends Controller
{

    public function index()
    {
        $personales = Personal::with('categoriaPersonal')->get();
        $categorias = CategoriaPersonal::all();

        return view('personal.index', compact('personales','categorias'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'dni' => 'required|size:8|unique:personal,dni',
            'nombre_completo' => 'required',
            'id_categoria_personal' => 'required|exists:categoria_personal,id_categoria_personal'
        ]);

        Personal::create($request->all());

        return redirect()->route('personal.index');
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'dni' => 'required|size:8|unique:personal,dni,' . $id . ',id_personal',
            'nombre_completo' => 'required',
            'id_categoria_personal' => 'required|exists:categoria_personal,id_categoria_personal'
        ]);

        $personal = Personal::findOrFail($id);
        $personal->update($request->all());

        return redirect()->route('personal.index');
    }


    public function destroy($id)
    {
        $personal = Personal::findOrFail($id);
        $personal->delete();

        return redirect()->route('personal.index');
    }

}