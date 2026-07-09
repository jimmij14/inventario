@extends('layouts.admin')

@section('content')

<div class="row">

    <div class="col-12">

        <div class="card">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">

                    <h4 class="header-title mb-2">Listado de Equipos</h4>

                    <div class="d-flex gap-2">

                        <form method="GET" action="{{ route('equipos.index') }}" class="d-flex">
                            <input type="text" 
                                name="search" 
                                value="{{ request('search') }}"
                                class="form-control mr-2" 
                                placeholder="Buscar equipo, marca o modelo...">

                            <button class="btn btn-primary mr-2">
                                Buscar
                            </button>
                        </form>

                        <button class="btn btn-success" onclick="nuevoEquipo()">
                            <i class="mdi mdi-plus"></i> Nuevo equipo
                        </button>

                    </div>

                </div>

                @if(request('search'))
                    <div class="mb-2">
                        Resultados para: <strong>{{ request('search') }}</strong>
                    </div>
                @endif

                <div class="table-responsive">

                    <table class="table table-centered table-nowrap mb-0">

                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Serie</th>
                                <th>Categoría</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Color</th>
                                <th>Imagen</th>
                                <th>Descripción</th>
                                <th width="150">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($equipos as $equipo)
                            <tr>
                                <td>{{ $equipo->nombre_equipo }}</td>
                                <td>{{ $equipo->serie }}</td>
                                <td>{{ $equipo->categoriaEquipo->nombre_categoria_equipo ?? '' }}</td>
                                <td>{{ $equipo->marca->nombre_marca ?? '' }}</td>
                                <td>{{ $equipo->modelo->nombre_modelo ?? '' }}</td>
                                <td>{{ $equipo->color->nombre_color ?? '' }}</td>
                                <td>

                                    @if($equipo->imagen)
                                        <a href="{{ asset('storage/'.$equipo->imagen) }}" target="_blank">
                                        <img
                                        src="{{ asset('storage/'.$equipo->imagen) }}"
                                        alt="{{ $equipo->nombre_equipo }}"
                                        loading="lazy"
                                        style="width:120px;height:90px;object-fit:cover;border-radius:5px;">
                                        </a>
                                    @endif
                                </td>
                                <td style="white-space: normal; max-width: 300px;">
                                    {{ $equipo->descripcion }}
                                </td>
                                <td>
                                    <button class="btn btn-warning btn-sm"
                                        onclick="editarEquipo(
                                            '{{ $equipo->id_equipo }}',
                                            '{{ $equipo->nombre_equipo }}',
                                            '{{ $equipo->serie }}',
                                            '{{ $equipo->id_categoria_equipo }}',
                                            '{{ $equipo->id_marca }}',
                                            '{{ $equipo->id_modelo }}',
                                            '{{ $equipo->id_color }}',
                                            '{{ $equipo->descripcion }}'
                                        )">
                                        <i class="mdi mdi-pencil"></i>
                                    </button>

                                    <form action="{{ route('equipos.destroy',$equipo->id_equipo) }}"
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


                    <div class="mt-3">
                        {{ $equipos->appends(request()->query())->links() }}
                    </div>

                </div>  

                

            </div>

        </div>

    </div>

</div>

<!-- MODAL -->

<div class="modal fade" id="modalEquipo" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formEquipo" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="metodo">
                <input type="hidden" id="id_equipo">

                <div class="modal-header">
                    <h5 class="modal-title" id="tituloModal">Nuevo Equipo</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>Nombre del equipo</label>
                        <input type="text" name="nombre_equipo" id="nombre_equipo" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Serie</label>
                        <input type="text" name="serie" id="serie" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Categoría</label>
                        <select name="id_categoria_equipo" id="id_categoria_equipo" class="form-control select2" required>
                            <option value="">Seleccione</option>
                            @foreach($categorias as $c)
                                <option value="{{ $c->id_categoria_equipo }}">{{ $c->nombre_categoria_equipo }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Marca</label>
                        <select name="id_marca" id="id_marca" class="form-control select2" required>
                            <option value="">Seleccione</option>
                            @foreach($marcas as $m)
                                <option value="{{ $m->id_marca }}">{{ $m->nombre_marca }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Modelo</label>
                        <select name="id_modelo" id="id_modelo" class="form-control select2" required>
                            <option value="">Seleccione</option>
                            @foreach($modelos as $mo)
                                <option value="{{ $mo->id_modelo }}">{{ $mo->nombre_modelo }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Color</label>
                        <select name="id_color" id="id_color" class="form-control select2" required>
                            <option value="">Seleccione</option>
                            @foreach($colores as $co)
                                <option value="{{ $co->id_color }}">{{ $co->nombre_color }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Imagen</label>
                        <input type="file" name="imagen" id="imagen" class="form-control">
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

function nuevoEquipo(){
    $('#tituloModal').text('Nuevo Equipo');
    $('#formEquipo').attr('action','/equipos');
    $('#metodo').html('');
    $('#id_equipo').val('');
    $('#nombre_equipo').val('');
    $('#serie').val('');
    $('#id_categoria_equipo').val('').trigger('change');
    $('#id_marca').val('').trigger('change');
    $('#id_modelo').val('').trigger('change');
    $('#id_color').val('').trigger('change');
    $('#imagen').val('');
    $('#descripcion').val('');
    $('#modalEquipo').modal('show');
}

function editarEquipo(id,nombre,serie,categoria,marca,modelo,color,descripcion){
    $('#tituloModal').text('Editar Equipo');
    $('#formEquipo').attr('action','/equipos/'+id);
    $('#metodo').html('@method("PUT")');
    $('#id_equipo').val(id);
    $('#nombre_equipo').val(nombre);
    $('#serie').val(serie);
    $('#id_categoria_equipo').val(categoria).trigger('change');
    $('#id_marca').val(marca).trigger('change');
    $('#id_modelo').val(modelo).trigger('change');
    $('#id_color').val(color).trigger('change');
    $('#descripcion').val(descripcion);
    $('#modalEquipo').modal('show');
}
</script>

@endsection

@section('scripts')
<script>
$(document).ready(function(){
    $('#id_categoria_equipo, #id_marca, #id_modelo, #id_color').select2({
        dropdownParent: $('#modalEquipo'),
        width: '100%',
        placeholder: "Seleccione..."
    });
});
</script>
@endsection