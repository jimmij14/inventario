@extends('layouts.admin')

@section('content')

<h2>Crear Categoría</h2>

<form action="{{ route('categorias.store') }}" method="POST">
    @csrf

    <div>
        <label>Nombre:</label>
        <input type="text" name="nombre_categoria" required>
    </div>

    <div>
        <label>Descripción:</label>
        <textarea name="descripcion"></textarea>
    </div>

    <button type="submit">Guardar</button>
</form>

<a href="{{ route('categorias.index') }}">Volver</a>

@endsection