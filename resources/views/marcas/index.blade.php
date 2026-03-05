@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <h4 class="header-title">Listado de Marcas</h4>

                    <button class="btn btn-success" onclick="nuevaMarca()">
                    <i class="mdi mdi-plus"></i> Nueva marca
                    </button>
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
                            @foreach($marcas as $marca)
                            <tr>
                                <td>{{ $marca->nombre_marca }}</td>
                                <td>{{ $marca->descripcion }}</td>
                                <td>

                                    <button class="btn btn-warning btn-sm"
                                    onclick="editarMarca('{{ $marca->id_marca }}',
                                    '{{ $marca->nombre_marca }}',
                                    '{{ $marca->descripcion }}')">

                                    <i class="mdi mdi-pencil"></i>
                                    </button>


                                    <form action="{{ route('marcas.destroy', $marca->id_marca) }}"
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



<!-- Modal Marca -->
<div class="modal fade" id="modalMarca" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form id="formMarca" method="POST">
                @csrf
                <input type="hidden" id="metodo">
                <input type="hidden" name="id_marca" id="id_marca">

                <div class="modal-header">
                    <h5 class="modal-title" id="tituloModal">Nueva Marca</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>Nombre marca</label>
                        <input type="text" name="nombre_marca" id="nombre_marca" class="form-control" required>
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

<!-- script para nueva marca -->
<script>
function nuevaMarca() {

    $('#tituloModal').text('Nueva Marca');

    $('#formMarca').attr('action','/marcas');

    $('#metodo').html('');

    $('#id_marca').val('');
    $('#nombre_marca').val('');
    $('#descripcion').val('');

    $('#modalMarca').modal('show');
}
</script>

<!-- script para editar marca -->
<script>
function editarMarca(id,nombre,descripcion){

    $('#tituloModal').text('Editar Marca');

    $('#formMarca').attr('action','/marcas/'+id);

    $('#metodo').html('@method("PUT")');

    $('#id_marca').val(id);
    $('#nombre_marca').val(nombre);
    $('#descripcion').val(descripcion);

    $('#modalMarca').modal('show');

}
</script>

@endsection