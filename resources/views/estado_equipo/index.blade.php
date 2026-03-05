@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between mb-3">
                    <h4 class="header-title">Listado de Estados de Equipo</h4>

                    <button class="btn btn-success" onclick="nuevoEstado()">
                        <i class="mdi mdi-plus"></i> Nuevo estado
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

                        @foreach($estados as $estado)

                            <tr>

                                <td>{{ $estado->nombre_estado }}</td>

                                <td>{{ $estado->descripcion }}</td>

                                <td>

                                    <button class="btn btn-warning btn-sm"
                                        onclick="editarEstado(
                                        '{{ $estado->id_estado_equipo }}',
                                        '{{ $estado->nombre_estado }}',
                                        '{{ $estado->descripcion }}')">

                                        <i class="mdi mdi-pencil"></i>

                                    </button>


                                    <form action="{{ route('estado_equipo.destroy', $estado->id_estado_equipo) }}"
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

<div class="modal fade" id="modalEstado" tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <form id="formEstado" method="POST">

                @csrf

                <input type="hidden" id="metodo">
                <input type="hidden" name="id_estado_equipo" id="id_estado_equipo">

                <div class="modal-header">

                    <h5 class="modal-title" id="tituloModal">Nuevo Estado</h5>

                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>

                </div>


                <div class="modal-body">

                    <div class="form-group">

                        <label>Nombre del estado</label>

                        <input type="text"
                               name="nombre_estado"
                               id="nombre_estado"
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



<!-- nuevo estado -->

<script>

function nuevoEstado(){

    $('#tituloModal').text('Nuevo Estado')

    $('#formEstado').attr('action','/estado_equipo')

    $('#metodo').html('')

    $('#id_estado_equipo').val('')
    $('#nombre_estado').val('')
    $('#descripcion').val('')

    $('#modalEstado').modal('show')

}

</script>


<!-- editar estado -->

<script>

function editarEstado(id,nombre,descripcion){

    $('#tituloModal').text('Editar Estado')

    $('#formEstado').attr('action','/estado_equipo/'+id)

    $('#metodo').html('@method("PUT")')

    $('#id_estado_equipo').val(id)
    $('#nombre_estado').val(nombre)
    $('#descripcion').val(descripcion)

    $('#modalEstado').modal('show')

}

</script>

@endsection