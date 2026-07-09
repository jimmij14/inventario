<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;
use Illuminate\Support\Facades\Cache;

class ProveedorController extends Controller
{

    public function index()
    {
        $proveedores = Cache::remember('proveedores_listado', 60, fn() => Proveedor::all());
        return view('proveedores.index', compact('proveedores'));
    }


    public function store(Request $request)
    {

        Proveedor::create([
            'ruc' => $request->ruc,
            'razon_social' => $request->razon_social,
            'nombre_comercial' => $request->nombre_comercial,
            'telefono' => $request->telefono,
            'correo' => $request->correo,
            'direccion' => $request->direccion,
            'descripcion' => $request->descripcion
        ]);

        Cache::forget('proveedores_listado');

        return redirect()->route('proveedores.index');
    }


    public function update(Request $request, $id)
    {

        $proveedor = Proveedor::findOrFail($id);

        $proveedor->update([
            'ruc' => $request->ruc,
            'razon_social' => $request->razon_social,
            'nombre_comercial' => $request->nombre_comercial,
            'telefono' => $request->telefono,
            'correo' => $request->correo,
            'direccion' => $request->direccion,
            'descripcion' => $request->descripcion
        ]);

        Cache::forget('proveedores_listado');

        return redirect()->route('proveedores.index');

    }


    public function destroy($id)
    {

        $proveedor = Proveedor::findOrFail($id);
        $proveedor->delete();

        Cache::forget('proveedores_listado');

        return redirect()->route('proveedores.index');

    }

}