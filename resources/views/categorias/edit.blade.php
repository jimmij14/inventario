@extends('layouts.admin')

@section('content')

<h2>Editar Categoría</h2>

<form action="{{ route('categorias.update', $categoria->id_categoria) }}" method="POST">
    @csrf
    @method('PUT')

    <div>
        <label>Nombre:</label>
        <input type="text"
               name="nombre_categoria"
               value="{{ $categoria->nombre_categoria }}"
               required>
    </div>

    <div>
        <label>Descripción:</label>
        <textarea name="descripcion">{{ $categoria->descripcion }}</textarea>
    </div>

    <button type="submit">Actualizar</button>
</form>

<a href="{{ route('categorias.index') }}">Volver</a>

@endsection