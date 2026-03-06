@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <h4 class="header-title">Listado de Categorías de Equipo</h4>
                    <button class="btn btn-success" onclick="nuevaCategoriaEquipo()">
                        <i class="mdi mdi-plus"></i> Nueva categoría equipo
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-centered table-nowrap mb-0">
                        <thead>
                            <tr>
                                <th>Categoría principal</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th width="150">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($categoriaEquipos as $catEq)
                            <tr>
                                <td>{{ $catEq->categoria->nombre_categoria }}</td>
                                <td>{{ $catEq->nombre_categoria_equipo }}</td>
                                <td>{{ $catEq->descripcion }}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm"
                                        onclick="editarCategoriaEquipo(
                                            '{{ $catEq->id_categoria_equipo }}',
                                            '{{ $catEq->id_categoria }}',
                                            '{{ $catEq->nombre_categoria_equipo }}',
                                            '{{ $catEq->descripcion }}')">
                                        <i class="mdi mdi-pencil"></i>
                                    </button>

                                    <form action="{{ route('categoria_equipos.destroy', $catEq->id_categoria_equipo) }}"
                                        method="POST"
                                        class="form-eliminar"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm"
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
</div>

<!-- Modal Categoria Equipo -->
<div class="modal fade" id="modalCategoriaEquipo" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form id="formCategoriaEquipo" method="POST">
                @csrf
                <input type="hidden" id="metodo">
                <input type="hidden" name="id_categoria_equipo" id="id_categoria_equipo">

                <div class="modal-header">
                    <h5 class="modal-title" id="tituloModal">Nueva Categoría de Equipo</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>Categoría principal</label>
                        <select name="id_categoria" id="id_categoria" class="form-control" required>
                            <option value="">-- Seleccionar categoría --</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre_categoria }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Nombre categoría equipo</label>
                        <input type="text" name="nombre_categoria_equipo" id="nombre_categoria_equipo" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Descripción</label>
                        <textarea name="descripcion" id="descripcion" class="form-control"></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        Guardar
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cancelar
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<script>
function confirmarEliminacion(boton) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no se puede deshacer",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar'
    }).then(function(result) {
        if (result.value) {
            boton.closest('form').submit();
        }
    });
}

function nuevaCategoriaEquipo() {
    $('#tituloModal').text('Nueva Categoría de Equipo');
    $('#formCategoriaEquipo').attr('action','/categoria_equipos');
    $('#metodo').html('');
    $('#id_categoria_equipo').val('');
    $('#id_categoria').val('');
    $('#nombre_categoria_equipo').val('');
    $('#descripcion').val('');
    $('#modalCategoriaEquipo').modal('show');
}

function editarCategoriaEquipo(id, idCategoria, nombre, descripcion){
    $('#tituloModal').text('Editar Categoría de Equipo');
    $('#formCategoriaEquipo').attr('action','/categoria_equipos/'+id);
    $('#metodo').html('@method("PUT")');
    $('#id_categoria_equipo').val(id);
    $('#id_categoria').val(idCategoria);
    $('#nombre_categoria_equipo').val(nombre);
    $('#descripcion').val(descripcion);
    $('#modalCategoriaEquipo').modal('show');
}
</script>

@endsection