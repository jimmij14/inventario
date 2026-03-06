@extends('layouts.admin')

@section('content')

<div class="row">

    <div class="col-12">

        <div class="card">

            <div class="card-body">

                <div class="d-flex justify-content-between mb-3">

                    <h4 class="header-title">Listado de Personal</h4>

                    <button class="btn btn-success" onclick="nuevoPersonal()">
                        <i class="mdi mdi-plus"></i> Nuevo personal
                    </button>

                </div>


                <div class="table-responsive">

                    <table class="table table-centered table-nowrap mb-0">

                        <thead>
                            <tr>
                                <th>DNI</th>
                                <th>Nombre completo</th>
                                <th>Categoría</th>
                                <th>Correo</th>
                                <th>Teléfono</th>
                                <th>Descripción</th>
                                <th width="150">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($personales as $personal)

                            <tr>

                                <td>{{ $personal->dni }}</td>

                                <td>{{ $personal->nombre_completo }}</td>

                                <td>{{ $personal->categoriaPersonal->nombre_categoria_personal }}</td>

                                <td>{{ $personal->correo }}</td>

                                <td>{{ $personal->telefono }}</td>

                                <td style="white-space: normal; max-width: 300px;">
                                    {{ $personal->descripcion }}
                                </td>

                                <td>

                                    <button class="btn btn-warning btn-sm"
                                        onclick="editarPersonal(
                                            '{{ $personal->id_personal }}',
                                            '{{ $personal->dni }}',
                                            '{{ $personal->nombre_completo }}',
                                            '{{ $personal->correo }}',
                                            '{{ $personal->telefono }}',
                                            '{{ $personal->id_categoria_personal }}',
                                            '{{ $personal->descripcion }}'
                                        )">

                                        <i class="mdi mdi-pencil"></i>

                                    </button>


                                    <form action="{{ route('personal.destroy',$personal->id_personal) }}"
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



<!-- MODAL -->

<div class="modal fade" id="modalPersonal" tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <form id="formPersonal" method="POST">

                @csrf

                <input type="hidden" id="metodo">
                <input type="hidden" id="id_personal">

                <div class="modal-header">

                    <h5 class="modal-title" id="tituloModal">Nuevo Personal</h5>

                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>

                </div>


                <div class="modal-body">

                    <div class="form-group">
                        <label>DNI</label>
                        <input type="text" name="dni" id="dni" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Nombre completo</label>
                        <input type="text" name="nombre_completo" id="nombre_completo" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Categoría personal</label>

                        <select name="id_categoria_personal" id="id_categoria_personal" class="form-control" required>

                            <option value="">Seleccione</option>

                            @foreach($categorias as $categoria)

                                <option value="{{ $categoria->id_categoria_personal }}">
                                    {{ $categoria->nombre_categoria_personal }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="form-group">
                        <label>Correo</label>
                        <input type="email" name="correo" id="correo" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Teléfono</label>
                        <input type="text" name="telefono" id="telefono" class="form-control">
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

function confirmarEliminacion(boton){

    Swal.fire({
        title:'¿Estás seguro?',
        text:'Esta acción no se puede deshacer',
        type:'warning',
        showCancelButton:true,
        confirmButtonText:'Sí, eliminar'
    }).then(function(result){

        if(result.value){
            boton.closest('form').submit();
        }

    });

}



function nuevoPersonal(){

    $('#tituloModal').text('Nuevo Personal');

    $('#formPersonal').attr('action','/personal');

    $('#metodo').html('');

    $('#dni').val('');
    $('#nombre_completo').val('');
    $('#correo').val('');
    $('#telefono').val('');
    $('#id_categoria_personal').val('');
    $('#descripcion').val('');

    $('#modalPersonal').modal('show');

}



function editarPersonal(id,dni,nombre,correo,telefono,categoria,descripcion){

    $('#tituloModal').text('Editar Personal');

    $('#formPersonal').attr('action','/personal/'+id);

    $('#metodo').html('@method("PUT")');

    $('#dni').val(dni);
    $('#nombre_completo').val(nombre);
    $('#correo').val(correo);
    $('#telefono').val(telefono);
    $('#id_categoria_personal').val(categoria);
    $('#descripcion').val(descripcion);

    $('#modalPersonal').modal('show');

}

</script>

@endsection