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
                <div class="bg-primary text-white p-3 rounded">
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
                <div class="bg-success text-white p-3 rounded">
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
                <div class="bg-info text-white p-3 rounded">
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
                <div class="bg-warning text-white p-3 rounded">
                    <i class="mdi mdi-swap-horizontal" style="font-size: 28px;"></i>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection


{{-- 🔥 EFECTO HOVER PRO --}}
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