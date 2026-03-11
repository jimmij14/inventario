@extends('layouts.admin')

@section('content')

<div class="row">

    <div class="col-12">

        <div class="card">

            <div class="card-body">

                <div class="d-flex justify-content-between mb-3">

                    <h4 class="header-title">Listado de Usuarios</h4>

                    <a href="{{ route('users.create') }}" class="btn btn-success">
                        <i class="mdi mdi-plus"></i> Nuevo usuario
                    </a>

                </div>

                <div class="table-responsive">

                    <table class="table table-centered table-nowrap mb-0">

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th width="150">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($data as $key => $user)

                            <tr>

                                <td>{{ ++$i }}</td>

                                <td>{{ $user->name }}</td>

                                <td>{{ $user->email }}</td>

                                <td>

                                    <a href="{{ route('users.show',$user->id) }}"
                                    class="btn btn-info btn-sm">
                                        <i class="mdi mdi-eye"></i>
                                    </a>

                                    <a href="{{ route('users.edit',$user->id) }}"
                                    class="btn btn-warning btn-sm">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>

                                    <form action="{{ route('users.destroy',$user->id) }}"
                                        method="POST"
                                        style="display:inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="button"
                                                class="btn btn-danger btn-sm"
                                                onclick="confirmarEliminacion(this)">
                                            <i class="mdi mdi-delete"></i>
                                        </button>

                                    </form>

                                </td>

                            </tr>

                            @endforeach

                        </tbody>

                    </table>

                    <div class="mt-3">
                        {!! $data->links() !!}
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<script>



function confirmarEliminacion(boton){

    Swal.fire({
        title:'¿Estás seguro?',
        text:'Esta acción no se puede deshacer',
        type:'warning',
        showCancelButton:true,
        confirmButtonText:'Sí, eliminar'
    }).then(function(result){

        if(result.value){
            boton.closest('form').submit();
        }

    });

}

</script>

@endsection