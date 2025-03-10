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
                    <form action="{{ route('documentos.store') }}" id="miFormulario" method="POST" enctype="multipart/form-data" >
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
                         <hr>
                        <button type="submit" class="btn btn-success">CREAR DOCUMENTO</button>
                    </form>
                    <br>
                    <div>
                        <a href="{{ route('documentos.index') }}"><button type="submit" class="btn btn-secondary">VOLVER</button></a>
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

    document.getElementById("miFormulario").addEventListener("submit", function(event) {
        if (!archivoBase64) {
            event.preventDefault(); // Evita el envío si no hay archivo cargado
            alert("Debes seleccionar un archivo antes de enviar.");
        }
    });
</script>
</html>
@endsection