@include('layouts.app')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentos</title>
    <style>
        .sidebar {
            height: 100vh; /* Altura completa de la pantalla */
            overflow-y: auto; /* Scroll vertical si el contenido es mayor que la altura */
            position: fixed; /* Barra lateral fija */
            width: 250px; /* Ancho de la barra lateral */
        }

        .main-content {
            padding: 20px;
            overflow-y: auto; /* Scroll vertical para el contenido principal */
            max-height: 100vh; /* Altura máxima del contenido principal */
        }
    </style>
  </head>
</head>
<body class="bg-muni">
    <div class="container-fluid">
            @if (session('success-create'))
            <div class="alert alert-info">
                {{ session('success-create') }}
            </div><br>
            @endif
            @can('documentos.store')
            <div>
                <a class="text-light" href="{{ route('documentos.create') }}"><button class="btn btn-primary">NUEVO DOCUMENTO</button></a>
            </div>
            @endcan
            <br>
            <table id='tabla'>
                <thead>
                    <tr>
                            <th scope="col" class="fs-4 text">Fecha publicacion</th>
                            <th scope="col" class="fs-4 text">Titulo</th>
                            <th scope="col" class="fs-4 text">Descripcion</th>
                            <th scope="col" class="fs-4 text">Archivo</th>
                            <th scope="col" class="fs-4 text">Estado</th>
                            <th scope="col" class="fs-4 text"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($documentos["estadosActuales"] as $documento)
                        @if ($documento[1]['estado'] == 'cerrado')
                            <tr class="table-secondary">
                                <td class="text-bg-secondary p-3 fs-5 text" data-cell="disabled fecha_modificacion">{{$documento[0]['fecha_modificacion']}}</td>
                                <td class="text-bg-secondary p-3 fs-5 text" data-cell="titulo">{{$documento[1]['titulo']}}</td>
                                <td class="text-bg-secondary p-3 fs-5 text" data-cell="descripcion">{{$documento[1]['descripcion']}}</td>
                                <td class="text-bg-secondary p-3 fs-5 text" data-cell="archivo"></td>
                                <td class="text-bg-secondary p-3" data-cell="estado"><span class="badge text-bg-secondary fs-5 text text-uppercase">{{$documento[1]['estado']}}</span></td>
                                <td class="text-bg-secondary p-3 fs-5 text"></td>
                            </tr>
                        @endif
                        @if ($documento[1]['estado'] == 'abierto')
                            <tr class="disabled table-secondary">
                                    <td data-cell="fecha_modificacion" class="p-3 fs-5 text">{{$documento[0]['fecha_modificacion']}}</td>
                                    <td data-cell="titulo" class="p-3 fs-5 text">{{$documento[1]['titulo']}}</td>
                                    <td data-cell="descripcion" class="p-3 fs-5 text">{{$documento[1]['descripcion']}}</td>
                                    <td data-cell="archivo" class="p-3 fs-5 text"><a href="{{ asset('storage/'.$documento[1]['archivo']) }}"><button>Descargar</button></a></td>
                                    <td data-cell="estado"><span class="badge text-bg-success fs-5 text text-uppercase">{{$documento[1]['estado']}}</span></td>
                                    <td class='no-hover'>
                                        <div class="btn-group" role="group">
                                                @can('documentos.estado')
                                                    <button type="button" class="btn btn-danger" 
                                                    data-bs-toggle="modal"
                                                    data-id="{{$documento[1]['id_documento']}}"
                                                    data-bs-target="#cambiarEstadoModal" 
                                                    data-bs-placement="left"
                                                    data-bs-custom-class="tooltip-danger"
                                                    data-bs-title="CAMBIAR Estado"><i class="bi bi-x-lg"></i></button>
                                                @endcan
                                                
                                                @can('documentos.update')
                                                    <button type="button" id="mod" class="btn btn-success btn-sm"
                                                    data-bs-toggle="tooltip" 
                                                    data-bs-placement="right"
                                                    data-bs-custom-class="tooltip-success"
                                                    data-toggle="modal"
                                                    data-target="#modalDocumento"
                                                    data-bs-title="EDITAR Registro"><a href="/editar/{{$documento[1]['id_documento']}}"><i class="bi bi-pen-fill"></i></a></button>
                                                @endcan
                                                
                                        </div>

                                    </td>
                                    
                        
                                </tr>
                        @endif
                    @endforeach
                </tbody>
                <tfoot>
                    
                </tfoot>
            </table><br>



    </div>
    <!--MODAL-->
    <div class="modal fade" id="cambiarEstadoModal" tabindex="-1" role="dialog" aria-labelledby="cambiarEstadoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                            <h5 class="modal-title" id="cambiarEstadoModalLabel">Confirmar Cambio de Estado</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    <div class="modal-body">
                        ¿Está seguro de que desea cambiar el estado de este documento a cerrado?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button href="" type="button" class="btn btn-primary" id="confirmarCambioEstado" data-id="">Confirmar</button>
                    </div>
                </div>
        </div>
    </div>




</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/app.js') }}" ></script>
</html>