<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Marca;
use App\Models\Modelo;
use App\Models\Color;
use App\Models\CategoriaEquipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Request as RequestFacade; // 👈 para página

class EquipoController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->get('search'); // 👈 input del buscador

        $query = Equipo::with([
            'marca:id_marca,nombre_marca',
            'modelo:id_modelo,nombre_modelo',
            'color:id_color,nombre_color',
            'categoriaEquipo:id_categoria_equipo,nombre_categoria_equipo'
        ])
        ->select(
            'id_equipo',
            'nombre_equipo',
            'serie',
            'imagen',
            'descripcion',
            'id_marca',
            'id_modelo',
            'id_color',
            'id_categoria_equipo'
        );

        // 🔎 FILTRO DE BÚSQUEDA
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre_equipo', 'like', "%{$search}%")
                ->orWhereHas('marca', function ($q2) use ($search) {
                    $q2->where('nombre_marca', 'like', "%{$search}%");
                })
                ->orWhereHas('modelo', function ($q3) use ($search) {
                    $q3->where('nombre_modelo', 'like', "%{$search}%");
                });
            });
        }

        $equipos = $query->paginate(10);

        // ⚡ catálogos (igual)
        $marcas = Cache::remember('marcas', 60, fn() =>
            Marca::select('id_marca','nombre_marca')->get()
        );

        $modelos = Cache::remember('modelos', 60, fn() =>
            Modelo::select('id_modelo','nombre_modelo')->get()
        );

        $colores = Cache::remember('colores', 60, fn() =>
            Color::select('id_color','nombre_color')->get()
        );

        $categorias = Cache::remember('categorias', 60, fn() =>
            CategoriaEquipo::select('id_categoria_equipo','nombre_categoria_equipo')->get()
        );

        return view('equipos.index', compact(
            'equipos','marcas','modelos','colores','categorias','search'
        ));
    }

    public function store(Request $request)
    {
        $rutaImagen = null;

        if($request->hasFile('imagen')){
            $imagen = $request->file('imagen');
            $nombre = Str::slug($request->nombre_equipo) ?: 'equipo';
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

        // 🔥 limpiar catálogos
        Cache::forget('marcas');
        Cache::forget('modelos');
        Cache::forget('colores');
        Cache::forget('categorias');

        return redirect()->route('equipos.index');
        
    }

    public function update(Request $request,$id)
    {
        $equipo = Equipo::findOrFail($id);

        if($request->hasFile('imagen')){
            $imagen = $request->file('imagen');
            $nombre = Str::slug($request->nombre_equipo) ?: 'equipo';
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
