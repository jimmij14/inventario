@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-12">

        <div class="card">

            <div class="card-body">

                <div class="d-flex justify-content-between mb-3">

                    <h4 class="header-title">Detalle del Usuario</h4>

                    <a class="btn btn-secondary"
                       href="{{ route('users.index') }}">
                        Volver
                    </a>

                </div>

                <div class="form-group mb-3">
                    <strong>Nombre:</strong>
                    <p class="form-control">{{ $user->name }}</p>
                </div>

                <div class="form-group mb-3">
                    <strong>Email:</strong>
                    <p class="form-control">{{ $user->email }}</p>
                </div>

                <div class="form-group mb-3">
                    <strong>Rol:</strong>

                    @if(!empty($user->getRoleNames()))
                        @foreach($user->getRoleNames() as $v)
                            <span class="badge badge-info">{{ $v }}</span>
                        @endforeach
                    @endif

                </div>

            </div>

        </div>

    </div>
</div>

@endsection