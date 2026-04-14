@extends('layouts.admin')

@section('content')

<div class="row g-3 align-items-center">

    {{-- Equipos --}}
    <div class="col-md-3">
        <div class="card shadow-sm border-0 hover-card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Equipos</h6>
                    <h2 class="mb-0 fw-bold">{{ $totalEquipos }}</h2>
                </div>
                <div class="bg-primary text-white p-4 rounded">
                    <i class="mdi mdi-laptop" style="font-size: 28px;"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Áreas --}}
    <div class="col-md-3">
        <div class="card shadow-sm border-0 hover-card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Áreas</h6>
                    <h2 class="mb-0 fw-bold">{{ $totalAreas }}</h2>
                </div>
                <div class="bg-success text-white p-4 rounded">
                    <i class="mdi mdi-office-building" style="font-size: 28px;"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Personal --}}
    <div class="col-md-3">
        <div class="card shadow-sm border-0 hover-card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Personal</h6>
                    <h2 class="mb-0 fw-bold">{{ $totalPersonal }}</h2>
                </div>
                <div class="bg-info text-white p-4 rounded">
                    <i class="mdi mdi-account-group" style="font-size: 28px;"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Movimientos --}}
    <div class="col-md-3">
        <div class="card shadow-sm border-0 hover-card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Movimientos</h6>
                    <h2 class="mb-0 fw-bold">{{ $totalMovimientos }}</h2>
                </div>
                <div class="bg-warning text-white p-4 rounded">
                    <i class="mdi mdi-swap-horizontal" style="font-size: 28px;"></i>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row mt-4">

    {{-- 📊 Equipos por Estado --}}
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5>Equipos por Estado</h5>
                <canvas id="chartEstado"></canvas>
            </div>
        </div>
    </div>

    {{-- 📊 Equipos por Área --}}
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5>Equipos por Área</h5>
                <canvas id="chartArea"></canvas>
            </div>
        </div>
    </div>

</div>

@endsection

@push('styles')
<style>
.hover-card {
    transition: all 0.3s ease;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}
</style>
@endpush

{{-- 📊 CHART.JS --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    // 📊 ESTADO
    const estadoLabels = @json($equiposPorEstado->pluck('estado'));
    const estadoData = @json($equiposPorEstado->pluck('total'));

    if (estadoLabels.length > 0) {
        new Chart(document.getElementById('chartEstado'), {
            type: 'doughnut',
            data: {
                labels: estadoLabels,
                datasets: [{
                    data: estadoData,
                    backgroundColor: [
                        '#0d6efd', '#198754', '#ffc107', '#dc3545', '#6f42c1'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    }

    // 📊 AREA
    const areaLabels = @json($equiposPorArea->pluck('area'));
    const areaData = @json($equiposPorArea->pluck('total'));

    if (areaLabels.length > 0) {
        new Chart(document.getElementById('chartArea'), {
            type: 'bar',
            data: {
                labels: areaLabels,
                datasets: [{
                    label: 'Equipos',
                    data: areaData,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

});
</script>
@endpush