@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-12">

        <div class="card">

            <div class="card-body">

                <div class="d-flex justify-content-between mb-3">

                    <h4 class="header-title">Editar Usuario</h4>

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

                <form action="{{ route('users.update',$user->id) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3">
                        <label>Nombre</label>
                        <input type="text"
                               name="name"
                               value="{{ $user->name }}"
                               class="form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label>Email</label>
                        <input type="email"
                               name="email"
                               value="{{ $user->email }}"
                               class="form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label>Password</label>
                        <input type="password"
                               name="password"
                               class="form-control"
                               placeholder="Nueva contraseña (opcional)">
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

                                <option value="{{ $value }}"
                                {{ isset($userRole[$value]) ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    <button type="submit" class="btn btn-success">
                        Actualizar
                    </button>

                </form>

            </div>

        </div>

    </div>
</div>

@endsection