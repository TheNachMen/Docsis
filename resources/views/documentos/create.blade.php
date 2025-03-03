@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    

    <title>Document</title>
</head>
<body class="bg-muni">
    <div class="container">
        <div class="card">
                    <h1 class=".tx-10">Nuevo Documento</h1>
                    <form action="{{ route('documentos.store') }}" method="POST" enctype="multipart/form-data" >
                        @csrf
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Titulo</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" value="{{ old('titulo') }}" >

                            @error('titulo')
                            <br>
                            <small class="text-danger">Debe llenar el campo Titulo</small>
                            @enderror

                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripcion</label>
                            <input type="text" class="form-control" id="descripcion" name="descripcion" value="{{ old('descripcion') }}" >

                            @error('descripcion')
                            <br>
                            <small class="text-danger">Debe llenar el campo Descripcion</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="archivo" class="form-label">ArchivoPDF</label>
                            <input type="file" class="form-control" id="archivo" name="archivo" >

                            @error('archivo')
                            <br>
                            <small class="text-danger">Archivo faltante o formato incorrecto</small>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-success">CREAR DOCUMENTO</button>
                    </form>
                    <br>
                    <div>
                        <a href="{{ route('documentos.index') }}"><button type="submit" class="btn btn-secondary">VOLVER</button></a>
                    </div>
            
            
            
         </>   
    </div>
    
</body>
</html>
@endsection