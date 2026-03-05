@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between mb-3">
                    <h4 class="header-title">Listado de Categorías de Personal</h4>

                    <button class="btn btn-success" onclick="nuevaCategoriaPersonal()">
                        <i class="mdi mdi-plus"></i> Nueva categoría
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

                        @foreach($categorias_personal as $categoria)

                            <tr>

                                <td>{{ $categoria->nombre_categoria_personal }}</td>
                                <td>{{ $categoria->descripcion }}</td>

                                <td>

                                    <button class="btn btn-warning btn-sm"
                                        onclick="editarCategoriaPersonal(
                                        '{{ $categoria->id_categoria_personal }}',
                                        '{{ $categoria->nombre_categoria_personal }}',
                                        '{{ $categoria->descripcion }}')">

                                        <i class="mdi mdi-pencil"></i>
                                    </button>


                                    <form action="{{ route('categoria_personal.destroy',$categoria->id_categoria_personal) }}"
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

<div class="modal fade" id="modalCategoriaPersonal" tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <form id="formCategoriaPersonal" method="POST">

                @csrf

                <input type="hidden" id="metodo">
                <input type="hidden" name="id_categoria_personal" id="id_categoria_personal">

                <div class="modal-header">

                    <h5 class="modal-title" id="tituloModal">Nueva Categoría</h5>

                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>

                </div>

                <div class="modal-body">

                    <div class="form-group">

                        <label>Nombre categoría</label>

                        <input type="text"
                               name="nombre_categoria_personal"
                               id="nombre_categoria_personal"
                               class="form-control"
                               required>

                    </div>

                    <div class="form-group">

                        <label>Descripción</label>

                        <textarea
                            name="descripcion"
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



<!-- script eliminar -->

<script>

function confirmarEliminacion(boton){

    Swal.fire({
        title:'¿Estás seguro?',
        text:"Esta acción no se puede deshacer",
        type:'warning',
        showCancelButton:true,
        confirmButtonText:'Sí, eliminar'
    }).then(function(result){

        if(result.value){

            boton.closest('form').submit()

        }

    })

}

</script>



<!-- nueva categoria -->

<script>

function nuevaCategoriaPersonal(){

    $('#tituloModal').text('Nueva Categoría de Personal')

    $('#formCategoriaPersonal').attr('action','/categoria_personal')

    $('#metodo').html('')

    $('#id_categoria_personal').val('')
    $('#nombre_categoria_personal').val('')
    $('#descripcion').val('')

    $('#modalCategoriaPersonal').modal('show')

}

</script>


<!-- editar categoria -->

<script>

function editarCategoriaPersonal(id,nombre,descripcion){

    $('#tituloModal').text('Editar Categoría de Personal')

    $('#formCategoriaPersonal').attr('action','/categoria_personal/'+id)

    $('#metodo').html('@method("PUT")')

    $('#id_categoria_personal').val(id)
    $('#nombre_categoria_personal').val(nombre)
    $('#descripcion').val(descripcion)

    $('#modalCategoriaPersonal').modal('show')

}

</script>

@endsection