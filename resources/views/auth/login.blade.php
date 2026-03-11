@extends('layouts.auth')

@section('content')

<div class="container">
    
    <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
        
        <div class="col-md-5 col-lg-5">

            <div class="card card-outline card-primary shadow-sm">

                <div class="card-header text-center">
                    <a href="#" class="h4"><b>Sistema</b> Inventario</a>
                </div>

                <div class="card-body">
                    <p class="login-box-msg text-center">Iniciar sesión</p>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="input-group mb-3">
                            <input type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                name="email"
                                placeholder="Correo"
                                value="{{ old('email') }}"
                                required>

                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>

                            @error('email')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <input type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                name="password"
                                placeholder="Contraseña"
                                required>

                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>

                            @error('password')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="row">

                            <div class="col-7">
                                <div class="form-check">
                                    <input type="checkbox" name="remember" id="remember" class="form-check-input">
                                    <label class="form-check-label" for="remember">
                                        Recordarme
                                    </label>
                                </div>
                            </div>

                            <div class="col-5">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Ingresar
                                </button>
                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection