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

                <div class="table-responsive">

                    <table class="table table-centered table-nowrap mb-0">

                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Equipo</th>
                                <th>Área</th>
                                <th>Estado</th>
                                <th>Proveedor</th>
                                <th>Precio</th>
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

                                <td>{{ $inv->precio_compra }}</td>

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

<script>

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
        $('#codigo_preview').val(abreviatura + '-001');
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
