@extends('layouts.admin')

@section('content')

@if($errors->any())
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        title: 'Revisa los datos ingresados',
        html: @json(implode('<br>', $errors->all())),
        type: 'error'
    });
});
</script>
@endif

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <h4 class="header-title">Listado de Categorías</h4>

                    <div class="d-flex" style="gap: 8px;">
                        <button class="btn btn-success" onclick="nuevaCategoria()">
                        <i class="mdi mdi-plus"></i> Nueva categoría
                        </button>
                        <a href="{{ route('categorias.pdf') }}" class="btn btn-danger" target="_blank"><i class="mdi mdi-file-pdf-box"></i> Exportar a PDF</a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-centered table-nowrap mb-0">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th width="150">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($categorias as $categoria)
                            <tr>
                                <td>{{ $categoria->nombre_categoria }}</td>
                                <td>{{ $categoria->descripcion }}</td>
                                <td>

                                    <button class="btn btn-warning btn-sm"
                                    onclick="editarCategoria('{{ $categoria->id_categoria }}',
                                    '{{ $categoria->nombre_categoria }}',
                                    '{{ $categoria->descripcion }}')">

                                    <i class="mdi mdi-pencil"></i>
                                    </button>


                                    <form action="{{ route('categorias.destroy', $categoria->id_categoria) }}"
                                        method="POST"
                                        class="form-eliminar"
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
</div>



<!-- Modal Categoria -->
<div class="modal fade" id="modalCategoria" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form id="formCategoria" method="POST">
                @csrf
                <input type="hidden" id="metodo">
                <input type="hidden" name="id_categoria" id="id_categoria">

                <div class="modal-header">
                    <h5 class="modal-title" id="tituloModal">Nueva Categoría</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>Nombre categoría</label>
                        <input type="text" name="nombre_categoria" id="nombre_categoria" class="form-control" required>
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



<!-- script para confirmar eliminacion -->
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
</script>

<!-- script para nueva categoria -->
<script>
function nuevaCategoria() {

    $('#tituloModal').text('Nueva Categoría');

    $('#formCategoria').attr('action','/categorias');

    $('#metodo').html('');

    $('#id_categoria').val('');
    $('#nombre_categoria').val('');
    $('#descripcion').val('');

    $('#modalCategoria').modal('show');
}
</script>

<!-- script para editar categoria -->
<script>
function editarCategoria(id,nombre,descripcion){

    $('#tituloModal').text('Editar Categoría');

    $('#formCategoria').attr('action','/categorias/'+id);

    $('#metodo').html('@method("PUT")');

    $('#id_categoria').val(id);
    $('#nombre_categoria').val(nombre);
    $('#descripcion').val(descripcion);

    $('#modalCategoria').modal('show');

}
</script>

@endsection