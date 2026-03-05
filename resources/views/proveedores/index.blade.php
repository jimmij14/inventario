@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <h4 class="header-title">Listado de Proveedores</h4>
                    <button class="btn btn-success" onclick="nuevoProveedor()">
                        <i class="mdi mdi-plus"></i> Nuevo proveedor
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-centered table-nowrap mb-0">
                        <thead>
                            <tr>
                                <th>RUC</th>
                                <th>Razón social</th>
                                <th>Nombre comercial</th>
                                <th>Teléfono</th>
                                <th>Correo</th>
                                <th>Dirección</th>
                                <th>Descripción</th>
                                <th width="150">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($proveedores as $proveedor)
                            <tr>
                                <td>{{ $proveedor->ruc }}</td>
                                <td>{{ $proveedor->razon_social }}</td>
                                <td>{{ $proveedor->nombre_comercial }}</td>
                                <td>{{ $proveedor->telefono }}</td>
                                <td>{{ $proveedor->correo }}</td>
                                <td>{{ $proveedor->direccion }}</td>
                                <td style="white-space: normal; word-wrap: break-word;" title="{{ $proveedor->descripcion }}">
                                    {{ $proveedor->descripcion }}
                                </td>
                                <td>
                                    <button class="btn btn-warning btn-sm"
                                        onclick="editarProveedor('{{ $proveedor->id_proveedor }}',
                                        '{{ $proveedor->ruc }}',
                                        '{{ $proveedor->razon_social }}',
                                        '{{ $proveedor->nombre_comercial }}',
                                        '{{ $proveedor->telefono }}',
                                        '{{ $proveedor->correo }}',
                                        '{{ $proveedor->direccion }}',
                                        '{{ $proveedor->descripcion }}')">
                                        <i class="mdi mdi-pencil"></i>
                                    </button>

                                    <form action="{{ route('proveedores.destroy', $proveedor->id_proveedor) }}"
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

<!-- Modal Proveedor -->
<div class="modal fade" id="modalProveedor" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formProveedor" method="POST">
                @csrf
                <input type="hidden" id="metodo">
                <input type="hidden" name="id_proveedor" id="id_proveedor">

                <div class="modal-header">
                    <h5 class="modal-title" id="tituloModal">Nuevo Proveedor</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>RUC</label>
                        <input type="text" name="ruc" id="ruc" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Razón social</label>
                        <input type="text" name="razon_social" id="razon_social" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Nombre comercial</label>
                        <input type="text" name="nombre_comercial" id="nombre_comercial" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Teléfono</label>
                        <input type="text" name="telefono" id="telefono" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Correo</label>
                        <input type="email" name="correo" id="correo" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Dirección</label>
                        <input type="text" name="direccion" id="direccion" class="form-control">
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

<!-- script para nuevo proveedor -->
<script>
function nuevoProveedor() {
    $('#tituloModal').text('Nuevo Proveedor');
    $('#formProveedor').attr('action','/proveedores');
    $('#metodo').html('');
    $('#id_proveedor').val('');
    $('#ruc').val('');
    $('#razon_social').val('');
    $('#nombre_comercial').val('');
    $('#telefono').val('');
    $('#correo').val('');
    $('#direccion').val('');
    $('#descripcion').val('');
    $('#modalProveedor').modal('show');
}
</script>

<!-- script para editar proveedor -->
<script>
function editarProveedor(id, ruc, razon_social, nombre_comercial, telefono, correo, direccion, descripcion){
    $('#tituloModal').text('Editar Proveedor');
    $('#formProveedor').attr('action','/proveedores/'+id);
    $('#metodo').html('@method("PUT")');
    $('#id_proveedor').val(id);
    $('#ruc').val(ruc);
    $('#razon_social').val(razon_social);
    $('#nombre_comercial').val(nombre_comercial);
    $('#telefono').val(telefono);
    $('#correo').val(correo);
    $('#direccion').val(direccion);
    $('#descripcion').val(descripcion);
    $('#modalProveedor').modal('show');
}
</script>

@endsection