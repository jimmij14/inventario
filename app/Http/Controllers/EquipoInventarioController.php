<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EquipoInventario;
use App\Models\Equipo;
use App\Models\Area;
use App\Models\EstadoEquipo;
use App\Models\TipoIngreso;
use App\Models\Proveedor;
use Illuminate\Support\Facades\Auth;

use Barryvdh\DomPDF\Facade\Pdf;


class EquipoInventarioController extends Controller
{
    

    public function index(Request $request)
    {
        $estadoBaja = EstadoEquipo::where('nombre_estado','Baja')->first();

        $inventarios = EquipoInventario::with([
            'equipo',
            'area',
            'estado',
            'tipoIngreso',
            'proveedor',
            'user'
        ])->where('id_estado_equipo','!=',$estadoBaja->id_estado_equipo);

        // BUSCAR POR CODIGO INVENTARIO
        if($request->filled('buscar')){
            $inventarios->where('codigo_inventario','LIKE','%'.$request->buscar.'%');
        }

        // FILTRO POR AREA
        if($request->filled('area')){
            $inventarios->where('id_area',$request->area);
        }

        // FILTRO POR ESTADO
        if($request->filled('estado')){
            $inventarios->where('id_estado_equipo',$request->estado);
        }

        // EJECUTAR CONSULTA
        $inventarios = $inventarios->paginate(10);


        $equipos = Equipo::all();
        $areas = Area::all();
        //$estados = EstadoEquipo::all();//estados normales
        $estados = EstadoEquipo::where('nombre_estado','!=','Baja')->get();//excluye estado baja
        $tiposIngreso = TipoIngreso::all();
        $proveedores = Proveedor::all();

        return view('inventario.index', compact(
            'inventarios',
            'equipos',
            'areas',
            'estados',
            'tiposIngreso',
            'proveedores'
        ));
    }
        

    public function store(Request $request)
    {

        
        //GENERAR CODIGO INVENTARIO
       

        $area = Area::find($request->id_area);

        $abreviatura = $area->abreviatura;

        $ultimo = EquipoInventario::where('id_area',$request->id_area)
                    ->latest('id_equipo_inventario')
                    ->first();

        if($ultimo){

            $numero = intval(substr($ultimo->codigo_inventario,-3)) + 1;

        }else{

            $numero = 1;

        }

        $numero_formateado = str_pad($numero,3,"0",STR_PAD_LEFT);

        $codigo = $abreviatura.$numero_formateado;


        //SUBIR DOCUMENTO
        

        $nombre_documento = null;

        if($request->hasFile('documento')){

            $archivo = $request->file('documento');

            $nombre_documento = time().'_'.$archivo->getClientOriginalName();

            $archivo->move(public_path('documentos'), $nombre_documento);

        }


   
        //GUARDAR INVENTARIO

        $inventario = new EquipoInventario();

        $inventario->codigo_inventario = $codigo;
        $inventario->id_equipo = $request->id_equipo;
        $inventario->id_area = $request->id_area;
        $inventario->id_estado_equipo = $request->id_estado_equipo;
        $inventario->id_tipo_ingreso = $request->id_tipo_ingreso;
        $inventario->id_proveedor = $request->id_proveedor;
        $inventario->precio_compra = $request->precio_compra;
        $inventario->fecha_compra = $request->fecha_compra;
        $inventario->tipo_documento = $request->tipo_documento;
        $inventario->documento = $nombre_documento;
        $inventario->observaciones = $request->observaciones;

        $inventario->user_id = Auth::id();

        $inventario->fecha_registro = now();

        $inventario->save();

        return redirect()->back()->with('success','Equipo registrado correctamente');


    }



    public function update(Request $request, $id)
    {

        $inventario = EquipoInventario::find($id);

        
        //SI SUBEN NUEVO DOCUMENTO
       

        if($request->hasFile('documento')){

            $archivo = $request->file('documento');

            $nombre_documento = time().'_'.$archivo->getClientOriginalName();

            $archivo->move(public_path('documentos'), $nombre_documento);

            $inventario->documento = $nombre_documento;

        }

        $inventario->id_equipo = $request->id_equipo;
        $inventario->id_area = $request->id_area;
        $inventario->id_estado_equipo = $request->id_estado_equipo;
        $inventario->id_tipo_ingreso = $request->id_tipo_ingreso;
        $inventario->id_proveedor = $request->id_proveedor;
        $inventario->precio_compra = $request->precio_compra;
        $inventario->fecha_compra = $request->fecha_compra;
        $inventario->tipo_documento = $request->tipo_documento;
        $inventario->observaciones = $request->observaciones;

        $inventario->save();

        return redirect()->back()->with('success','Inventario actualizado');

    }



    public function destroy($id)
    {

        $inventario = EquipoInventario::find($id);

        $inventario->delete();

        return redirect()->back()->with('success','Equipo eliminado');

    }





    public function imprimirCodigos(Request $request)
    {

        // OBTENER ID DEL ESTADO BAJA
        $estadoBaja = EstadoEquipo::where('nombre_estado','Baja')->first();

        $inventarios = EquipoInventario::query()
            ->where('id_estado_equipo','!=',$estadoBaja->id_estado_equipo);

        // FILTRO BUSCAR
        if($request->filled('buscar')){
            $inventarios->where('codigo_inventario','LIKE','%'.$request->buscar.'%');
        }

        // FILTRO AREA
        if($request->filled('area')){
            $inventarios->where('id_area',$request->area);
        }

        // FILTRO ESTADO
        if($request->filled('estado')){
            $inventarios->where('id_estado_equipo',$request->estado);
        }

        $inventarios = $inventarios->get();

        $pdf = Pdf::loadView('inventario.codigos', compact('inventarios'));

        return $pdf->stream('codigos_inventario.pdf');
    }


    public function show($id)
    {

        $inventario = EquipoInventario::with([
            'equipo',
            'area',
            'estado',
            'tipoIngreso',
            'proveedor',
            'user'
        ])->findOrFail($id);

        return view('inventario.show', compact('inventario'));

    }


}