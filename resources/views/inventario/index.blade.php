@extends('layouts.admin')

@section('content')

<div class="row">

    <div class="col-12">

        <div class="card">

            <div class="card-body">

                <div class="d-flex justify-content-between mb-3">

                    <h4 class="header-title">Inventario de Equipos</h4>

                    <button class="btn btn-success" onclick="nuevoInventario()">
                        <i class="mdi mdi-plus"></i> Nuevo inventario
                    </button>

                </div>

                <form method="GET" action="{{ route('inventario.index') }}">

                <div class="row mb-3">

                    <div class="col-md-3">
                        <input type="text" name="buscar" class="form-control"
                        placeholder="Buscar código inventario"
                        value="{{ request('buscar') }}">
                    </div>

                    <div class="col-md-3">
                        <select name="area" class="form-control">
                            <option value="">Todas las áreas</option>
                            @foreach($areas as $area)
                                <option value="{{ $area->id_area }}"
                                {{ request('area') == $area->id_area ? 'selected' : '' }}>
                                {{ $area->nombre_area }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select name="estado" class="form-control">
                            <option value="">Todos los estados</option>
                            @foreach($estados as $estado)
                                <option value="{{ $estado->id_estado_equipo }}"
                                {{ request('estado') == $estado->id_estado_equipo ? 'selected' : '' }}>
                                {{ $estado->nombre_estado }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <button class="btn btn-primary">
                             <i class="mdi mdi-magnify"></i>Buscar
                        </button>

                        <a href="{{ route('inventario.codigos', request()->query()) }}"
                            class="btn btn-primary"
                            target="_blank">
                            <i class="mdi mdi-barcode"></i> Imprimir códigos
                         </a>
                    </div>

                </div>

                </form>

                <div class="table-responsive">

                    <table id="tablaInventario" class="table table-centered table-nowrap mb-0">
                            <tr>
                                <th>Código</th>
                                <th>Equipo</th>
                                <th>Área</th>
                                <th>Estado</th>
                                <th>Proveedor</th>
                                <th>Tipo ingreso</th>
                                <th>Precio</th>
                                <TH>Tipo de Documento</TH>
                                <th>Documento</th>
                                <th width="150">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($inventarios as $inv)

                            <tr>

                                <td>{{ $inv->codigo_inventario }}</td>

                                <td>{{ $inv->equipo->nombre_equipo ?? '' }}</td>

                                <td>{{ $inv->area->nombre_area ?? '' }}</td>

                                <td>{{ $inv->estado->nombre_estado ?? '' }}</td>

                                <td>{{ $inv->proveedor->nombre_comercial ?? '' }}</td>

                                <td>{{ $inv->tipoIngreso->nombre_tipo_ingreso ?? '' }}</td>

                                <td>
                                @if($inv->precio_compra)
                                    S/ {{ number_format($inv->precio_compra,2) }}
                                @elseif($inv->tipoIngreso->nombre_tipo_ingreso == 'Donación')
                                    Sin costo
                                @else
                                    —
                                @endif
                                </td>

                                <td>{{ $inv->tipo_documento }}</td>

                                <td>

                                    @if($inv->documento)

                                        <a href="{{ asset('documentos/'.$inv->documento) }}" target="_blank">
                                            <i class="mdi mdi-file-pdf" style="font-size:22px;color:red;"></i> Ver documento
                                        </a>

                                    @else

                                        Sin documento

                                    @endif

                                </td>

                                <td>
                                    <a href="{{ route('inventario.show', $inv->id_equipo_inventario) }}"class="btn btn-info btn-sm">

                                        <i class="mdi mdi-eye"></i>

                                    </a>


                                    <button class="btn btn-warning btn-sm"
                                        onclick="editarInventario(
                                            '{{ $inv->id_equipo_inventario }}',
                                            '{{ $inv->id_equipo }}',
                                            '{{ $inv->id_area }}',
                                            '{{ $inv->id_estado_equipo }}',
                                            '{{ $inv->id_proveedor }}',
                                            '{{ $inv->id_tipo_ingreso }}',
                                            '{{ $inv->precio_compra }}',
                                            '{{ $inv->fecha_compra }}',
                                            '{{ $inv->tipo_documento }}',
                                            '{{ $inv->observaciones }}'
                                        )">
                                        <i class="mdi mdi-pencil"></i>
                                    </button>

                                    <button class="btn btn-dark btn-sm"
                                        onclick="abrirModalBaja('{{ $inv->id_equipo_inventario }}')">
                                        <i class="mdi mdi-close-circle"></i>
                                    </button>


                                    <form action="{{ route('inventario.destroy',$inv->id_equipo_inventario) }}"
                                        method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')

                                        <button type="button"
                                            class="btn btn-danger btn-sm"
                                            onclick="confirmarEliminacion(this)">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    </form>

                                </td>



                            </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>
    ```

    </div>

    <!-- MODAL -->

    <div class="modal fade" id="modalInventario" tabindex="-1">

    ```
    <div class="modal-dialog">

        <div class="modal-content">

            <form id="formInventario" method="POST" enctype="multipart/form-data">

                @csrf

                <input type="hidden" id="metodo">
                <input type="hidden" id="id_equipo_inventario">

                <div class="modal-header">

                    <h5 class="modal-title" id="tituloModal">Nuevo Inventario</h5>

                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>

                </div>


                <div class="modal-body">

                    <div class="form-group">
                        <label>Equipo</label>

                        <select name="id_equipo" id="id_equipo" class="form-control select2" required>

                            <option value="">Seleccione</option>

                            @foreach($equipos as $e)
                                <option value="{{ $e->id_equipo }}">
                                    {{ $e->nombre_equipo }}
                                </option>
                            @endforeach

                        </select>

                    </div>


                    <div class="form-group">

                        <label>Área</label>

                        <select name="id_area" id="id_area" class="form-control select2" required>

                            <option value="">Seleccione</option>

                            @foreach($areas as $a)

                                <option value="{{ $a->id_area }}"
                                    data-abreviatura="{{ $a->abreviatura }}">

                                    {{ $a->nombre_area }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="form-group">

                        <label>Código que se generará</label>

                        <input type="text"
                            id="codigo_preview"
                            class="form-control"
                            readonly>

                    </div>


                    <div class="form-group">

                        <label>Estado</label>

                        <select name="id_estado_equipo"
                                id="id_estado_equipo"
                                class="form-control select2">

                            <option value="">Seleccione</option>

                            @foreach($estados as $es)
                                <option value="{{ $es->id_estado_equipo }}">
                                    {{ $es->nombre_estado }}
                                </option>
                            @endforeach

                        </select>

                    </div>


                    <div class="form-group">

                        <label>Proveedor</label>

                        <select name="id_proveedor"
                                id="id_proveedor"
                                class="form-control select2">

                            <option value="">Seleccione</option>

                            @foreach($proveedores as $p)
                                <option value="{{ $p->id_proveedor }}">
                                    {{ $p->nombre_comercial }}
                                </option>
                            @endforeach

                        </select>

                    </div>


                    <div class="form-group">

                        <label>Tipo ingreso</label>

                        <select name="id_tipo_ingreso"
                                id="id_tipo_ingreso"
                                class="form-control select2">

                            <option value="">Seleccione</option>

                            @foreach($tiposIngreso as $t)
                                <option value="{{ $t->id_tipo_ingreso }}">
                                    {{ $t->nombre_tipo_ingreso }}
                                </option>
                            @endforeach

                        </select>

                    </div>


                    <div class="form-group">

                        <label>Precio compra</label>

                        <input type="number"
                            name="precio_compra"
                            id="precio_compra"
                            class="form-control">

                    </div>


                    <div class="form-group">

                        <label>Fecha compra</label>

                        <input type="date"
                            name="fecha_compra"
                            id="fecha_compra"
                            class="form-control">

                    </div>


                    <div class="form-group">

                        <label>Tipo documento</label>

                        <input type="text"
                            name="tipo_documento"
                            id="tipo_documento"
                            class="form-control">

                    </div>


                    <div class="form-group">

                        <label>Documento</label>

                        <input type="file"
                            name="documento"
                            id="documento"
                            class="form-control">

                    </div>


                    <div class="form-group">

                        <label>Observaciones</label>

                        <textarea name="observaciones"
                                id="observaciones"
                                class="form-control"></textarea>

                    </div>

                </div>


                <div class="modal-footer">

                    <button type="submit" class="btn btn-primary">
                        Guardar
                    </button>

                    <button type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal">
                        Cancelar
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<!-- MODAL BAJA -->

<div class="modal fade" id="modalBaja" tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <form method="POST" action="{{ route('bajas.store') }}">

                @csrf

                <input type="hidden"
                       name="id_equipo_inventario"
                       id="id_equipo_inventario_baja">

                <div class="modal-header">

                    <h5 class="modal-title">Dar de baja al equipo</h5>

                    <button type="button"
                            class="close"
                            data-dismiss="modal">
                        <span>&times;</span>
                    </button>

                </div>

                <div class="modal-body">

                    <div class="form-group">

                        <label>Fecha de baja</label>

                        <input type="date"
                               name="fecha_baja"
                               id="fecha_baja"
                               class="form-control"
                               required>

                    </div>

                    <div class="form-group">

                        <label>Descripción</label>

                        <textarea name="descripcion"
                                  class="form-control"
                                  required></textarea>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="submit" class="btn btn-danger">
                        Confirmar baja
                    </button>

                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">
                        Cancelar
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>



<script>

function abrirModalBaja(id){

    $('#id_equipo_inventario_baja').val(id);

    let hoy = new Date().toISOString().split('T')[0];
    $('#fecha_baja').val(hoy);

    $('#modalBaja').modal('show');

}


function confirmarEliminacion(boton){

    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no se puede deshacer",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar'
    }).then(function(result){

        if(result.value){
            boton.closest('form').submit();
        }

    });

}

function editarInventario(
    id,
    equipo,
    area,
    estado,
    proveedor,
    tipoIngreso,
    precio,
    fecha,
    tipoDocumento,
    observaciones
){

    $('#tituloModal').text('Editar Inventario');

    $('#formInventario').attr('action','/inventario/'+id);

    $('#metodo').html('@method("PUT")');

    $('#id_equipo').val(equipo).trigger('change');
    $('#id_area').val(area).trigger('change');
    $('#id_estado_equipo').val(estado).trigger('change');
    $('#id_proveedor').val(proveedor).trigger('change');
    $('#id_tipo_ingreso').val(tipoIngreso).trigger('change');

    $('#precio_compra').val(precio);
    $('#fecha_compra').val(fecha);
    $('#tipo_documento').val(tipoDocumento);
    $('#observaciones').val(observaciones);

    $('#modalInventario').modal('show');

}


function nuevoInventario(){

    $('#tituloModal').text('Nuevo Inventario');

    $('#formInventario').attr('action','/inventario');

    $('#metodo').html('');

    $('#id_equipo').val('').trigger('change');
    $('#id_area').val('').trigger('change');
    $('#id_estado_equipo').val('').trigger('change');
    $('#id_proveedor').val('').trigger('change');
    $('#id_tipo_ingreso').val('').trigger('change');

    $('#precio_compra').val('');
    $('#fecha_compra').val('');
    $('#tipo_documento').val('');
    $('#documento').val('');
    $('#observaciones').val('');

    $('#codigo_preview').val('');

    $('#modalInventario').modal('show');

}


$('#id_area').on('change', function(){

    let abreviatura = $(this).find(':selected').data('abreviatura');

    if(abreviatura){
        $('#codigo_preview').val(abreviatura + '001');
    }

});

</script>

@endsection

@section('scripts')

<script>

$(document).ready(function(){

    $('#id_equipo,#id_area,#id_estado_equipo,#id_proveedor,#id_tipo_ingreso').select2({
        dropdownParent: $('#modalInventario'),
        width:'100%',
        placeholder:"Seleccione..."
    });

});

</script>

@endsection
