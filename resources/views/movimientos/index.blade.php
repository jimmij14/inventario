@extends('layouts.admin')

@section('content')

@if($errors->any())
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        title: 'Revisa los datos ingresados',
        html: @json(implode('<br>', $errors->all())),
        type: 'error'
    });
});
</script>
@endif

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

                {{-- AGREGAR EQUIPO A LA LISTA --}}
                <div class="form-group mb-3">
                    <label>Código del equipo</label>
                    <div class="d-flex">
                        <input type="text" id="codigo" class="form-control">
                        <button type="button" id="btnBuscar" class="btn btn-primary ms-2">
                            Agregar
                        </button>
                    </div>
                    <small class="form-text text-muted">Busca y agrega uno o más equipos; todos se moverán a la misma área y estado.</small>
                </div>

                {{-- LISTA DE EQUIPOS AGREGADOS --}}
                <div class="table-responsive mb-3" id="listaEquiposWrapper" style="display:none;">
                    <table class="table table-sm table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Equipo</th>
                                <th>Área actual</th>
                                <th>Estado actual</th>
                                <th width="50"></th>
                            </tr>
                        </thead>
                        <tbody id="listaEquiposBody"></tbody>
                    </table>
                </div>

                <form method="POST" action="{{ route('movimientos.store') }}" id="formMovimiento">
                    @csrf

                    <div id="hiddenEquiposContainer"></div>

                    <div class="form-group mb-3">
                        <label>Nueva Área</label>
                        <select name="id_area_destino" id="id_area_destino" class="form-control" required>
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

                    <button class="btn btn-success" id="btnRegistrar">
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
let equiposAgregados = [];

document.getElementById('btnBuscar').addEventListener('click', function () {

    let codigoInput = document.getElementById('codigo');
    let codigo = codigoInput.value.trim();

    if (!codigo) {
        return;
    }

    let btnBuscar = document.getElementById('btnBuscar');
    btnBuscar.disabled = true;

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

        if (equiposAgregados.some(function (e) { return e.id === eq.id_equipo_inventario; })) {
            alert('Ese equipo ya fue agregado a la lista.');
            return;
        }

        equiposAgregados.push({
            id: eq.id_equipo_inventario,
            codigo: eq.codigo_inventario,
            nombre: eq.equipo.nombre_equipo,
            area: eq.area.nombre_area,
            areaId: String(eq.area.id_area),
            estado: eq.estado.nombre_estado
        });

        renderLista();
        codigoInput.value = '';
        codigoInput.focus();

    })
    .catch(function () {
        alert('No se pudo conectar con el servidor. Verifica tu conexión e intenta nuevamente.');
    })
    .finally(function () {
        btnBuscar.disabled = false;
    });

});

function escapeHtml(str) {
    let div = document.createElement('div');
    div.textContent = str == null ? '' : str;
    return div.innerHTML;
}

function quitarEquipo(id) {
    equiposAgregados = equiposAgregados.filter(function (e) { return e.id !== id; });
    renderLista();
}

function renderLista() {
    let wrapper = document.getElementById('listaEquiposWrapper');
    let body = document.getElementById('listaEquiposBody');
    let hiddenContainer = document.getElementById('hiddenEquiposContainer');

    body.innerHTML = '';
    hiddenContainer.innerHTML = '';

    if (equiposAgregados.length === 0) {
        wrapper.style.display = 'none';
        return;
    }

    wrapper.style.display = 'block';

    equiposAgregados.forEach(function (eq) {

        let row = document.createElement('tr');
        row.innerHTML =
            '<td>' + escapeHtml(eq.codigo) + '</td>' +
            '<td>' + escapeHtml(eq.nombre) + '</td>' +
            '<td>' + escapeHtml(eq.area) + '</td>' +
            '<td>' + escapeHtml(eq.estado) + '</td>' +
            '<td><button type="button" class="btn btn-danger btn-sm" onclick="quitarEquipo(' + eq.id + ')"><i class="mdi mdi-close"></i></button></td>';
        body.appendChild(row);

        let hidden = document.createElement('input');
        hidden.type = 'hidden';
        hidden.name = 'id_equipos[]';
        hidden.value = eq.id;
        hiddenContainer.appendChild(hidden);

    });
}

document.getElementById('formMovimiento').addEventListener('submit', function (e) {

    if (equiposAgregados.length === 0) {
        e.preventDefault();
        alert('Agrega al menos un equipo a la lista antes de registrar el movimiento.');
        return;
    }

    let areaDestino = document.getElementById('id_area_destino').value;
    let yaEnDestino = equiposAgregados.find(function (eq) { return eq.areaId === areaDestino; });

    if (yaEnDestino) {
        e.preventDefault();
        alert('El equipo ' + yaEnDestino.codigo + ' ya está en el área destino seleccionada.');
        return;
    }

    let btnRegistrar = document.getElementById('btnRegistrar');
    btnRegistrar.disabled = true;
    btnRegistrar.innerText = 'Guardando...';

});
</script>

@endsection