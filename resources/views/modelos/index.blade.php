@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between mb-3">
                    <h4 class="header-title">Listado de Modelos</h4>

                    <button class="btn btn-success" onclick="nuevoModelo()">
                        <i class="mdi mdi-plus"></i> Nuevo modelo
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

                            @foreach($modelos as $modelo)
                            <tr>

                                <td>{{ $modelo->nombre_modelo }}</td>
                                <td>{{ $modelo->descripcion }}</td>

                                <td>

                                    <button class="btn btn-warning btn-sm"
                                        onclick="editarModelo(
                                            '{{ $modelo->id_modelo }}',
                                            '{{ $modelo->nombre_modelo }}',
                                            '{{ $modelo->descripcion }}'
                                        )">

                                        <i class="mdi mdi-pencil"></i>
                                    </button>


                                    <form action="{{ route('modelos.destroy',$modelo->id_modelo) }}"
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



<!-- Modal Modelo -->
<div class="modal fade" id="modalModelo" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form id="formModelo" method="POST">

                @csrf
                <input type="hidden" id="metodo">
                <input type="hidden" name="id_modelo" id="id_modelo">

                <div class="modal-header">
                    <h5 class="modal-title" id="tituloModal">Nuevo Modelo</h5>

                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>Nombre modelo</label>

                        <input type="text"
                            name="nombre_modelo"
                            id="nombre_modelo"
                            class="form-control"
                            required>
                    </div>

                    <div class="form-group">
                        <label>Descripción</label>

                        <textarea
                            name="descripcion"
                            id="descripcion"
                            class="form-control">
                        </textarea>
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



<!-- Script confirmar eliminación -->
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


<!-- Script nuevo modelo -->
<script>
function nuevoModelo() {

    $('#tituloModal').text('Nuevo Modelo');

    $('#formModelo').attr('action','/modelos');

    $('#metodo').html('');

    $('#id_modelo').val('');
    $('#nombre_modelo').val('');
    $('#descripcion').val('');

    $('#modalModelo').modal('show');

}
</script>



<!-- Script editar modelo -->
<script>
function editarModelo(id,nombre,descripcion){

    $('#tituloModal').text('Editar Modelo');

    $('#formModelo').attr('action','/modelos/'+id);

    $('#metodo').html('@method("PUT")');

    $('#id_modelo').val(id);
    $('#nombre_modelo').val(nombre);
    $('#descripcion').val(descripcion);

    $('#modalModelo').modal('show');

}
</script>

@endsection