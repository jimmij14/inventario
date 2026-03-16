@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-4">
                        Detalle del equipo inventariado
                    </h4>

                    <table class="table table-bordered">
                        <tr>
                            <th>Código inventario</th>
                            <td>{{ $inventario->codigo_inventario }}</td>
                        </tr>
                        <tr>
                            <th>Equipo</th>
                            <td>{{ $inventario->equipo->nombre_equipo }}</td>
                        </tr>
                        <tr>
                            <th>Área</th>
                            <td>{{ $inventario->area->nombre_area }}</td>
                        </tr>
                        <tr>
                            <th>Estado</th>
                            <td>{{ $inventario->estado->nombre_estado }}</td>
                        </tr>
                        <tr>
                            <th>Tipo ingreso</th>
                            <td>{{ $inventario->tipoIngreso->nombre_tipo_ingreso ?? '' }}</td>
                        </tr>
                        <tr>
                            <th>Proveedor</th>
                            <td>{{ $inventario->proveedor->nombre_comercial ?? '' }}</td>
                        </tr>
                        <tr>
                            <th>Precio compra</th>
                            <td>
                                @if($inventario->precio_compra)
                                    S/ {{ number_format($inventario->precio_compra,2) }}
                                @elseif($inventario->tipoIngreso->nombre_tipo_ingreso == 'Donación')
                                    Sin costo
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Fecha compra</th>
                            <td>
                                @if($inventario->fecha_compra)
                                    {{ $inventario->fecha_compra }}
                                @else
                                    Sin fecha
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Tipo documento</th>
                            <td>{{ $inventario->tipo_documento }}</td>
                        </tr>
                        <tr>
                            <th>Documento</th>
                            <td>
                                @if($inventario->documento)
                                    <iframe src="{{ asset('documentos/'.$inventario->documento) }}" width="100%" height="500px" style="border: none;"></iframe>
                                @else
                                    Sin documento
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Fecha registro</th>
                            <td>{{ $inventario->fecha_registro }}</td>
                        </tr>
                        <tr>
                            <th>Registrado por</th>
                            <td>{{ $inventario->user->name ?? '' }}</td>
                        </tr>
                        <tr>
                            <th>Observaciones</th>
                            <td>{{ $inventario->observaciones }}</td>
                        </tr>
                    </table>

                    <a href="{{ route('inventario.index') }}" class="btn btn-secondary">
                        Volver
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection