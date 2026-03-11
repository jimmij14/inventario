@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-12">

        <div class="card">

            <div class="card-body">

                <div class="d-flex justify-content-between mb-3">

                    <h4 class="header-title">Crear Usuario</h4>

                    <a class="btn btn-secondary"
                       href="{{ route('users.index') }}">
                       Volver
                    </a>

                </div>

                @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Error.</strong> Revisa los campos.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('users.store') }}" method="POST">
                    @csrf

                    <div class="form-group mb-3">
                        <label>Nombre</label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               placeholder="Nombre del usuario">
                    </div>

                    <div class="form-group mb-3">
                        <label>Email</label>
                        <input type="email"
                               name="email"
                               class="form-control"
                               placeholder="Correo electrónico">
                    </div>

                    <div class="form-group mb-3">
                        <label>Password</label>
                        <input type="password"
                               name="password"
                               class="form-control"
                               placeholder="Contraseña">
                    </div>

                    <div class="form-group mb-3">
                        <label>Confirmar Password</label>
                        <input type="password"
                               name="confirm-password"
                               class="form-control"
                               placeholder="Confirmar contraseña">
                    </div>

                    <div class="form-group mb-3">
                        <label>Rol</label>
                        <select name="roles[]" class="form-control">
                            @foreach($roles as $value => $label)
                                <option value="{{ $value }}">
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit"
                            class="btn btn-success">
                        Guardar
                    </button>

                </form>

            </div>

        </div>

    </div>
</div>

@endsection