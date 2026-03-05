@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between mb-3">
                    <h4 class="header-title">Listado de Tipos de Ingreso</h4>

                    <button class="btn btn-success" onclick="nuevoTipoIngreso()">
                        <i class="mdi mdi-plus"></i> Nuevo tipo ingreso
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

                            @foreach($tipos as $tipo)
                            <tr>

                                <td>{{ $tipo->nombre_tipo_ingreso }}</td>
                                <td>{{ $tipo->descripcion }}</td>

                                <td>

                                    <button class="btn btn-warning btn-sm"
                                        onclick="editarTipoIngreso(
                                            '{{ $tipo->id_tipo_ingreso }}',
                                            '{{ $tipo->nombre_tipo_ingreso }}',
                                            '{{ $tipo->descripcion }}'
                                        )">
                                        <i class="mdi mdi-pencil"></i>
                                    </button>

                                    <form action="{{ route('tipo_ingreso.destroy', $tipo->id_tipo_ingreso) }}"
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
</div>



<!-- Modal -->
<div class="modal fade" id="modalTipoIngreso" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form id="formTipoIngreso" method="POST">
                @csrf

                <input type="hidden" id="metodo">
                <input type="hidden" name="id_tipo_ingreso" id="id_tipo_ingreso">

                <div class="modal-header">
                    <h5 class="modal-title" id="tituloModal">Nuevo Tipo Ingreso</h5>

                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text"
                               name="nombre_tipo_ingreso"
                               id="nombre_tipo_ingreso"
                               class="form-control"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Descripción</label>
                        <textarea name="descripcion"
                                  id="descripcion"
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
        text: 'Esta acción no se puede deshacer',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar'
    }).then(function(result){

        if(result.value){
            boton.closest('form').submit();
        }

    });

}

</script>



<script>

function nuevoTipoIngreso(){

    $('#tituloModal').text('Nuevo Tipo Ingreso');

    $('#formTipoIngreso').attr('action','/tipo_ingreso');

    $('#metodo').html('');

    $('#id_tipo_ingreso').val('');
    $('#nombre_tipo_ingreso').val('');
    $('#descripcion').val('');

    $('#modalTipoIngreso').modal('show');

}

</script>



<script>

function editarTipoIngreso(id,nombre,descripcion){

    $('#tituloModal').text('Editar Tipo Ingreso');

    $('#formTipoIngreso').attr('action','/tipo_ingreso/'+id);

    $('#metodo').html('@method("PUT")');

    $('#id_tipo_ingreso').val(id);
    $('#nombre_tipo_ingreso').val(nombre);
    $('#descripcion').val(descripcion);

    $('#modalTipoIngreso').modal('show');

}

</script>

@endsection