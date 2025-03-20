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
            @if (session('success-update'))
            <div class="alert alert-info">
                {{ session('success-update') }}
            </div>
            @endif
        <div class="card">
            <h1 class=".tx-10">Editar Documento</h1>
            <form action="{{ route('documentos.update',$documento['documento']['id_documento']) }}" method="POST" id="miFormulario" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="titulo" class="form-label">Titulo</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" value="{{$documento['documento']['titulo'] }}">
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripcion</label>
                    <input type="text" class="form-control" id="descripcion" name="descripcion" value="{{ $documento['documento']['descripcion'] }}">
                </div>
                @if ($documento['documento']['estado'] == 'pendiente')
                <div class="mb-3">
                    <label for="fecha_hora" class="form-label">Fecha Inicio</label>
                    <input type="datetime-local" class="form-control" id="fecha_hora" name="fecha_hora"  min="{{ now()->format('Y-m-d\TH:i') }}" value="{{ $documento['documento']['fecha_inicio'] }}">

                    @error('fecha_hora')
                    <br>
                    <small class="text-danger">Debe seleccion una fecha</small>
                    @enderror
                </div>
                            
                @endif
                <div class="mb-2 col-12">
                                <label class="form-label" for="archivo"><b>Documento</b></label>
                                <input id="archivo" class="form-control" type="file" name="archivo" accept=".pdf" style="display: none;">
                                
                                <!-- Botón para seleccionar archivo -->
                                <button type="button" id="seleccionarArchivo" class="btn btn-secondary">Seleccionar archivo</button>
                                <small class="text-muted">Formato permitido: PDF (Máx. 2MB)</small>
                                @error('archivo')
                                <br>
                                <small class="text-danger">Archivo faltante o formato incorrecto</small>
                                @enderror
                </div>
                <!-- Sección para mostrar el archivo cargado -->
                <div id="listaArchivos" class="mt-3"></div>
                <!-- Campo oculto para enviar el archivo en Base64 -->
                <input type="hidden" name="archivo_base64" id="archivoBase64">
                <a href="{{ asset('storage/'. $documento['documento']['archivo']) }}"><label for="">Archivo Original: {{ Str::afterLast($documento['documento']['archivo'],'/') }}</label></a><br>
                <p class="fs-6 text-secondary">Si no desea actualizar el archivo, deje este campo en blanco</p>
                <hr>
                <button type="submit" class="btn btn-success">ACTUALIZAR</button>
            </form>
            <br>
            <div>
                <a href="{{ route('documentos.index') }}"><button class="btn btn-secondary">VOLVER</button></a>
            </div>
            
         </div>   
    </div>
    
</body>
<script>
    let archivoBase64 = ""; // Variable para almacenar el Base64

    document.getElementById("seleccionarArchivo").addEventListener("click", function() {
        document.getElementById("archivo").click();
    });

    document.getElementById("archivo").addEventListener("change", function(event) {
        const input = event.target;
        const listaArchivos = document.getElementById("listaArchivos");

        if (input.files.length === 0) return;

        const file = input.files[0];

        // Validar tamaño del archivo (máx. 2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert("El archivo supera el tamaño máximo de 2MB.");
            input.value = "";
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            archivoBase64 = e.target.result.split(",")[1]; // Guardar el archivo en Base64
            document.getElementById("archivoBase64").value = archivoBase64;

            // Mostrar el archivo seleccionado
            listaArchivos.innerHTML = `
                <div class="archivo-item">
                    ${file.name}
                    <button type="button" class="btn btn-danger btn-sm ms-2" id="eliminarArchivo">Eliminar</button>
                </div>
            `;


            // Evento para eliminar el archivo
            document.getElementById("eliminarArchivo").addEventListener("click", function() {
                archivoBase64 = "";
                document.getElementById("archivoBase64").value = "";
                listaArchivos.innerHTML = "";
                input.value = "";
                document.getElementById("seleccionarArchivo").disabled = false;
                document.getElementById("enviar").disabled = true;
            });
        };

        reader.readAsDataURL(file);
    });

</script>
</html>
@endsection