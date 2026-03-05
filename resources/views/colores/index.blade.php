@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between mb-3">
                    <h4 class="header-title">Listado de Colores</h4>

                    <button class="btn btn-success" onclick="nuevoColor()">
                        <i class="mdi mdi-plus"></i> Nuevo color
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

                            @foreach($colores as $color)

                            <tr>

                                <td>{{ $color->nombre_color }}</td>
                                <td>{{ $color->descripcion }}</td>

                                <td>

                                    <button class="btn btn-warning btn-sm"
                                        onclick="editarColor(
                                        '{{ $color->id_color }}',
                                        '{{ $color->nombre_color }}',
                                        '{{ $color->descripcion }}')">

                                        <i class="mdi mdi-pencil"></i>
                                    </button>

                                    <form action="{{ route('colores.destroy',$color->id_color) }}"
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


<!-- Modal Color -->

<div class="modal fade" id="modalColor" tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <form id="formColor" method="POST">

                @csrf

                <input type="hidden" id="metodo">
                <input type="hidden" name="id_color" id="id_color">

                <div class="modal-header">

                    <h5 class="modal-title" id="tituloModal">Nuevo Color</h5>

                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>

                </div>

                <div class="modal-body">

                    <div class="form-group">

                        <label>Nombre color</label>

                        <input type="text"
                            name="nombre_color"
                            id="nombre_color"
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

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
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



<!-- script nuevo -->

<script>

function nuevoColor(){

    $('#tituloModal').text('Nuevo Color')

    $('#formColor').attr('action','/colores')

    $('#metodo').html('')

    $('#id_color').val('')
    $('#nombre_color').val('')
    $('#descripcion').val('')

    $('#modalColor').modal('show')

}

</script>



<!-- script editar -->

<script>

function editarColor(id,nombre,descripcion){

    $('#tituloModal').text('Editar Color')

    $('#formColor').attr('action','/colores/'+id)

    $('#metodo').html('@method("PUT")')

    $('#id_color').val(id)
    $('#nombre_color').val(nombre)
    $('#descripcion').val(descripcion)

    $('#modalColor').modal('show')

}

</script>

@endsection