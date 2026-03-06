@extends('layouts.admin')

@section('content')

<div class="row">

    <div class="col-12">

        <div class="card">

            <div class="card-body">

                <div class="d-flex justify-content-between mb-3">

                    <h4 class="header-title">Listado de Áreas</h4>

                    <button class="btn btn-success" onclick="nuevaArea()">
                        <i class="mdi mdi-plus"></i> Nueva área
                    </button>

                </div>


                <div class="table-responsive">

                    <table class="table table-centered table-nowrap mb-0">

                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Abreviatura</th>
                                <th>Responsable</th>
                                <th>Descripción</th>
                                <th width="150">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($areas as $area)

                            <tr>

                                <td>{{ $area->nombre_area }}</td>

                                <td>{{ $area->abreviatura }}</td>

                                <td>
                                    {{ $area->responsable->dni }} - 
                                    {{ $area->responsable->nombre_completo }}
                                </td>

                                <td style="white-space: normal; max-width: 300px;">
                                    {{ $area->descripcion }}
                                </td>

                                <td>

                                    <button class="btn btn-warning btn-sm"
                                        onclick="editarArea(
                                            '{{ $area->id_area }}',
                                            '{{ $area->nombre_area }}',
                                            '{{ $area->abreviatura }}',
                                            '{{ $area->id_responsable }}',
                                            '{{ $area->descripcion }}'
                                        )">

                                        <i class="mdi mdi-pencil"></i>

                                    </button>


                                    <form action="{{ route('areas.destroy',$area->id_area) }}"
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

<div class="modal fade" id="modalArea" tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <form id="formArea" method="POST">

                @csrf

                <input type="hidden" id="metodo">
                <input type="hidden" id="id_area">

                <div class="modal-header">

                    <h5 class="modal-title" id="tituloModal">Nueva Área</h5>

                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>

                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>Nombre del área</label>
                        <input type="text" name="nombre_area" id="nombre_area" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Abreviatura</label>
                        <input type="text" name="abreviatura" id="abreviatura" class="form-control" required>
                    </div>

                    <div class="form-group">

                        <label>Responsable</label>

                        <select name="id_responsable" id="id_responsable" class="form-control select2" required>

                            <option value="">Seleccione</option>

                            @foreach($personales as $p)

                                <option value="{{ $p->id_personal }}">
                                    {{ $p->dni }} - {{ $p->nombre_completo }}
                                </option>

                            @endforeach

                        </select>

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



function nuevaArea(){

    $('#tituloModal').text('Nueva Área');

    $('#formArea').attr('action','/areas');

    $('#metodo').html('');

    $('#nombre_area').val('');
    $('#abreviatura').val('');
    $('#id_responsable').val('');
    $('#descripcion').val('');

    $('#modalArea').modal('show');

}



function editarArea(id,nombre,abreviatura,responsable,descripcion){

    $('#tituloModal').text('Editar Área');

    $('#formArea').attr('action','/areas/'+id);

    $('#metodo').html('@method("PUT")');

    $('#nombre_area').val(nombre);
    $('#abreviatura').val(abreviatura);
    $('#id_responsable').val(responsable);
    $('#descripcion').val(descripcion);

    $('#modalArea').modal('show');

}

</script>

@endsection





@section('scripts')

<script>

$(document).ready(function(){

    $('#id_responsable').select2({
        dropdownParent: $('#modalArea'),
        width: '100%',
        placeholder: "Buscar responsable..."
    });

});

</script>

@endsection