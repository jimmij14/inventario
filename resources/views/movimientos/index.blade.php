@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-12">

        {{-- MENSAJE --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- =========================
            FORMULARIO MOVIMIENTO
        ========================== --}}
        <div class="card">
            <div class="card-body">

                <h4 class="header-title mb-3">Registrar Movimiento</h4>

                {{-- BUSCAR EQUIPO --}}
                <div class="form-group mb-3">
                    <label>Código del equipo</label>
                    <div class="d-flex">
                        <input type="text" id="codigo" class="form-control">
                        <button id="btnBuscar" class="btn btn-primary ms-2">
                            Buscar
                        </button>
                    </div>
                </div>

                {{-- DATOS DEL EQUIPO --}}
                <div id="datosEquipo" style="display:none;">
                    <p><strong>Equipo:</strong> <span id="nombreEquipo"></span></p>
                    <p><strong>Área actual:</strong> <span id="areaActual"></span></p>
                    <p><strong>Estado actual:</strong> <span id="estadoActual"></span></p>
                </div>

                <form method="POST" action="{{ route('movimientos.store') }}">
                    @csrf

                    <input type="hidden" name="id_equipo_inventario" id="id_equipo">

                    <div class="form-group mb-3">
                        <label>Nueva Área</label>
                        <select name="id_area_destino" class="form-control" required>
                            <option value="">Seleccione</option>
                            @foreach($areas as $area)
                                <option value="{{ $area->id_area }}">{{ $area->nombre_area }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>Nuevo Estado</label>
                        <select name="id_estado_nuevo" class="form-control" required>
                            <option value="">Seleccione</option>
                            @foreach($estados as $estado)
                                <option value="{{ $estado->id_estado_equipo }}">{{ $estado->nombre_estado }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>Descripción</label>
                        <textarea name="descripcion" class="form-control"></textarea>
                    </div>

                    <button class="btn btn-success">
                        Registrar Movimiento
                    </button>

                </form>

            </div>
        </div>

        {{-- =========================
            HISTORIAL
        ========================== --}}
        <div class="card mt-3">
            <div class="card-body">

                <h4 class="header-title mb-3">Historial de Movimientos</h4>

                {{-- FILTROS --}}
                <form method="GET" action="{{ route('movimientos.index') }}">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <input type="text" name="codigo" class="form-control" placeholder="Código de equipo" value="{{ request('codigo') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="area" class="form-control">
                                <option value="">Todas las áreas</option>
                                @foreach($areas as $area)
                                    <option value="{{ $area->id_area }}" {{ request('area') == $area->id_area ? 'selected' : '' }}>{{ $area->nombre_area }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="estado" class="form-control">
                                <option value="">Todos los estados</option>
                                @foreach($estados as $estado)
                                    <option value="{{ $estado->id_estado_equipo }}" {{ request('estado') == $estado->id_estado_equipo ? 'selected' : '' }}>{{ $estado->nombre_estado }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="fecha_desde" class="form-control" value="{{ request('fecha_desde') }}">
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="fecha_hasta" class="form-control" value="{{ request('fecha_hasta') }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <button class="btn btn-primary">
                                <i class="mdi mdi-magnify"></i> Buscar
                            </button>
                            <a href="{{ route('movimientos.index') }}" class="btn btn-secondary">Limpiar</a>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-centered table-nowrap mb-0">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Usuario</th>
                                <th>Equipo</th>
                                <th>Área Anterior</th>
                                <th>Área Nueva</th>
                                <th>Estado Anterior</th>
                                <th>Estado Nuevo</th>
                            </tr>
                        </thead>
                        <tbody>

                        @foreach($movimientos as $mov)
                            @foreach($mov->detalles as $det)
                                <tr>
                                    <td>{{ $mov->fecha_movimiento }}</td>
                                    <td>{{ $mov->usuario->name ?? 'N/A' }}</td>
                                    <td>{{ $det->equipo->equipo->nombre_equipo ?? 'N/A' }}</td>
                                    <td>{{ $mov->areaAnterior->nombre_area ?? 'N/A' }}</td>
                                    <td>{{ $mov->areaDestino->nombre_area ?? 'N/A' }}</td>
                                    <td>{{ $mov->estadoAnterior->nombre_estado ?? 'N/A' }}</td>
                                    <td>{{ $mov->estadoNuevo->nombre_estado ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        @endforeach

                        </tbody>
                    </table>

                    {{ $movimientos->links() }}

                </div>

            </div>
        </div>

    </div>
</div>

@endsection


@section('scripts')

<script>
document.getElementById('btnBuscar').addEventListener('click', function () {

    let codigo = document.getElementById('codigo').value;

    fetch("{{ route('movimientos.buscar') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ codigo: codigo })
    })
    .then(res => res.json())
    .then(data => {

        if (!data.success) {
            alert(data.message);
            return;
        }

        let eq = data.equipo;

        document.getElementById('datosEquipo').style.display = 'block';
        document.getElementById('nombreEquipo').innerText = eq.equipo.nombre_equipo;
        document.getElementById('areaActual').innerText = eq.area.nombre_area;
        document.getElementById('estadoActual').innerText = eq.estado.nombre_estado;

        document.getElementById('id_equipo').value = eq.id_equipo_inventario;

    });

});
</script>

@endsection