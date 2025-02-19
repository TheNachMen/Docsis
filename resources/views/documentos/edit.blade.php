@include('layouts.app')
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
            <form action="{{ route('documentos.update',$documento['documento']['id_documento']) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="titulo" class="form-label">Titulo</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" value="{{$documento['documento']['titulo'] }}" required>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripcion</label>
                    <input type="text" class="form-control" id="descripcion" name="descripcion" value="{{ $documento['documento']['descripcion'] }}" required>
                </div>
                <div class="mb-3">
                    <label for="archivo" class="form-label">ArchivoPDF</label>
                    <input type="file" class="form-control" id="archivo" name="archivo" value=""  required>
                    
                    
                </div>
                <button type="submit" class="btn btn-primary">ACTUALIZAR</button>
            </form>
            <br>
            <div>
                <a href="{{ route('documentos.index') }}"><button class="btn btn-secondary">VOLVER</button></a>
            </div>
            
         </div>   
    </div>
    
</body>
</html>