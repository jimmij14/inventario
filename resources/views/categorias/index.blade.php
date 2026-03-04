@extends('layouts.admin')

@section('content')

<h2>Listado de Categorías</h2>

<a href="{{ route('categorias.create') }}">Nueva Categoría</a>

<table border="1" width="100%">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Acciones</th>
    </tr>

    @foreach($categorias as $categoria)
    <tr>
        <td>{{ $categoria->id_categoria }}</td>
        <td>{{ $categoria->nombre_categoria }}</td>
        <td>{{ $categoria->descripcion }}</td>
        <td>
            <a href="{{ route('categorias.edit', $categoria->id_categoria) }}">Editar</a>

            <form action="{{ route('categorias.destroy', $categoria->id_categoria) }}" 
                  method="POST" 
                  style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">Eliminar</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

@endsection