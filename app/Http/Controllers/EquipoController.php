<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Marca;
use App\Models\Modelo;
use App\Models\Color;
use App\Models\CategoriaEquipo;
use Illuminate\Http\Request;

class EquipoController extends Controller
{

    public function index()
    {
        $equipos = Equipo::with([
            'marca',
            'modelo',
            'color',
            'categoriaEquipo'
        ])->get();

        $marcas = Marca::all();
        $modelos = Modelo::all();
        $colores = Color::all();
        $categorias = CategoriaEquipo::all();

        return view('equipos.index',compact(
            'equipos',
            'marcas',
            'modelos',
            'colores',
            'categorias'
        ));
    }

    public function store(Request $request)
    {

        $rutaImagen = null;

        if($request->hasFile('imagen')){

            $imagen = $request->file('imagen');

            $nombre = $request->nombre_equipo;

            $nombreImagen = $nombre.'_'.time().'.'.$imagen->getClientOriginalExtension();

            $imagen->storeAs('equipos',$nombreImagen,'public');

            $rutaImagen = 'equipos/'.$nombreImagen;
        }

        Equipo::create([
            'nombre_equipo'=>$request->nombre_equipo,
            'serie'=>$request->serie,
            'imagen'=>$rutaImagen,
            'id_categoria_equipo'=>$request->id_categoria_equipo,
            'id_marca'=>$request->id_marca,
            'id_modelo'=>$request->id_modelo,
            'id_color'=>$request->id_color,
            'descripcion'=>$request->descripcion
        ]);

        return redirect()->route('equipos.index');
    }

    public function update(Request $request,$id)
    {

        $equipo = Equipo::findOrFail($id);

        if($request->hasFile('imagen')){

            $imagen = $request->file('imagen');

            $nombre = $request->nombre_equipo;

            $nombreImagen = $nombre.'_'.time().'.'.$imagen->getClientOriginalExtension();

            $imagen->storeAs('equipos',$nombreImagen,'public');

            $equipo->imagen = 'equipos/'.$nombreImagen;
        }

        $equipo->update([
            'nombre_equipo'=>$request->nombre_equipo,
            'serie'=>$request->serie,
            'id_categoria_equipo'=>$request->id_categoria_equipo,
            'id_marca'=>$request->id_marca,
            'id_modelo'=>$request->id_modelo,
            'id_color'=>$request->id_color,
            'descripcion'=>$request->descripcion
        ]);

        return redirect()->route('equipos.index');
    }

    public function destroy($id)
    {
        $equipo = Equipo::findOrFail($id);
        $equipo->delete();

        return redirect()->route('equipos.index');
    }

}