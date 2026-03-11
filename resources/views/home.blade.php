@extends('layouts.admin')

@section('content')

<div class="row">

    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">Panel principal</h4>
        </div>
    </div>

</div>

<div class="row">

    <div class="col-md-3">
        <div class="card bg-primary">
            <div class="card-body text-white">
                <h3>0</h3>
                <p>Total Equipos</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-success">
            <div class="card-body text-white">
                <h3>0</h3>
                <p>Total Áreas</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-info">
            <div class="card-body text-white">
                <h3>0</h3>
                <p>Total Personal</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-warning">
            <div class="card-body text-white">
                <h3>0</h3>
                <p>Total Movimientos</p>
            </div>
        </div>
    </div>

</div>

@endsection