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

class EquipoInventarioController extends Controller
{

    public function index()
    {
        $inventarios = EquipoInventario::with([
            'equipo',
            'area',
            'estado',
            'tipoIngreso',
            'proveedor'
        ])->get();

        $equipos = Equipo::all();
        $areas = Area::all();
        $estados = EstadoEquipo::all();
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

        $codigo = $abreviatura.'-'.$numero_formateado;


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

        //$inventario->id_usuario = Auth::id(); 77ORIGIANL-SE USARA CUANDO ESTE LISTO EL LOGIN
        $inventario->id_usuario = 2; //SOLO DE PRUEBA HASTA HACER TABLA USUARIO
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

}