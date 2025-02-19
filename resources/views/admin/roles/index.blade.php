@extends('adminlte::page')

@section('title', 'Panel de administración')

@section('content_header')
<h1>Administra los roles</h1>
@endsection

@section('content')

<div class="card">
    <div class="card-header">
        <a class="btn btn-primary" href="{{ route('admin.roles.create') }}">Crear rol</a>
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($roles as $role)
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->name }}</td>

                        <td width="10px"><a href="{{ route('admin.role.edit',$role) }}" class="btn btn-primary btn-sm mb-2">Editar</a></td>

                        <td width="10px">
                            <a href="{{ route('admin.role.delete',$role) }}" class="btn btn-danger btn-sm mb-2">Eliminar</a>
                        </td>
                    </tr>
                @endforeach
                
          
            </tbody>
        </table>
    </div>
</div>
@endsection
