@extends('layouts.admin')

@section('content')

<div class="row">

    <div class="col-12">

        <div class="card">

            <div class="card-body">

                <div class="d-flex justify-content-between mb-3">

                    <h4 class="header-title">
                        Equipos dados de baja
                    </h4>

                </div>

                <form method="GET" action="{{ route('bajas.index') }}">

                <div class="row mb-3">

                    <div class="col-md-4">
                        <input type="text"
                        name="buscar"
                        class="form-control"
                        placeholder="Buscar código inventario"
                        value="{{ request('buscar') }}">
                    </div>

                    <div class="col-md-4">
                        <select name="area" class="form-control">

                            <option value="">Todas las áreas</option>

                            @foreach($areas as $area)

                                <option value="{{ $area->id_area }}"
                                {{ request('area') == $area->id_area ? 'selected' : '' }}>

                                    {{ $area->nombre_area }}

                                </option>

                            @endforeach

                        </select>
                    </div>

                    <div class="col-md-4">

                        <button class="btn btn-primary">
                            <i class="mdi mdi-magnify"></i> Buscar
                        </button>

                        <a href="{{ route('bajas.index') }}" class="btn btn-secondary">
                            Limpiar
                        </a>

                    </div>

                </div>

                </form>







                <div class="table-responsive">

                    <table class="table table-centered table-nowrap mb-0">

                        <thead>

                            <tr>
                                <th>Código</th>
                                <th>Equipo</th>
                                <th>Área</th>
                                <th>Fecha de baja</th>
                                <th>Depreciación</th>
                                <th>Valor Baja</th>
                                <th>Motivo</th>
                                <th>Descripción</th>
                                <th>Usuario</th>
                                <th>Responsable Área</th>
                                <th>Acciones</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($bajas as $baja)

                            <tr>

                                <td>
                                    {{ $baja->inventario->codigo_inventario ?? '' }}
                                </td>

                                <td>
                                    {{ $baja->inventario->equipo->nombre_equipo ?? '' }}
                                </td>

                                <td>
                                    {{ $baja->inventario->area->nombre_area ?? '' }}
                                </td>

                                <td>
                                    {{ $baja->fecha_baja }}
                                </td>

                                <td>
                                    {{ $baja->depreciacion }}
                                </td>

                                <td>
                                    {{ $baja->valor_baja }}
                                </td>

                                <td>
                                    {{ $baja->motivo }}
                                </td>

                                <td>
                                    {{ $baja->descripcion }}
                                </td>

                                <td>
                                    {{ $baja->usuario->name ?? '' }}
                                </td>

                                <td>
                                    {{ $baja->inventario->area->responsable->nombre_completo ?? '' }}
                                </td>

                                <td>

                                    <form action="{{ route('bajas.restaurar', $baja->id_baja) }}"
                                        method="POST"
                                        style="display:inline;">

                                        @csrf
                                        @method('PUT')

                                        <button type="button"
                                                class="btn btn-success btn-sm"
                                                onclick="confirmarRestauracion(this)">Restaurar

                                            <i class="mdi mdi-backup-restore"></i>

                                        </button>

                                    </form>

                                </td>



                            </tr>

                            @empty

                            <tr>
                                <td colspan="11" class="text-center">
                                    No hay equipos dados de baja
                                </td>
                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                    {{ $bajas->links() }}

                </div>

            </div>

        </div>

    </div>

</div>

<script>

function confirmarRestauracion(boton) {
    Swal.fire({
        title: '¿Restaurar equipo?',
        text: "El equipo volverá al inventario activo",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, restaurar'
    }).then(function(result) {
        if (result.value) {
            boton.closest('form').submit();
        }
    });
}


</script>


@endsection
