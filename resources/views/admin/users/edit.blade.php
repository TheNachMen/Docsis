@extends('adminlte::page')
@section('title','Panel de administracion')

@section('content_header')
<h1>Establecer roles</h1>
@endsection


@section('content')
@if (session('success-update'))
<div class="alert alert-info">
    {{ session('success-update') }}
</div>
@endif


    <div class="card">
        <div class="card-body">
            <p>Nombre:</p>
            <p class="form-control">{{ $user->name }}</p>

            <h5>Roles</h5>
            <form action="{{ route('admin.user.update',$user->id) }}" method="POST">
                @csrf
                @foreach ($roles as  $role)
                    <div>
                        <label>
                            <input type="radio" name="role" id="role" 
                            value="{{ $role->id }}" {{ $user->roles->contains($role->id) ? 'checked':'' }} 
                            class="mr-1 mb-3" >
                            {{ $role->name }}
                        </label>
                    </div>
                @endforeach
                <input type="submit" value="Establecer rol" class="btn btn-primary">
            </form>
        </div>
    </div>
@endsection



