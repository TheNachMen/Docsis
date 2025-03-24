@extends('layouts.app')


@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Documentos</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap.min.css' integrity='sha512-BMbq2It2D3J17/C7aRklzOODG1IQ3+MHw3ifzBHMBwGO/0yUqYmsStgBjI0z5EYlaDEFnvYV7gNYdD3vFLRKsA==' crossorigin='anonymous' referrerpolicy='no-referrer' />
    
</head>

<body class="bg-muni">
    <div class="container-fluid">
            @if (session('success-create'))
            <div class="alert alert-info">
                {{ session('success-create') }}
            </div><br>
            @endif
            @if (session('success-estado'))
            <div class="alert alert-info">
                {{ session('success-estado') }}
            </div><br>
            @endif
            @can('documentos.store')
            <div>
                <a class="text-light" href="{{ route('documentos.create') }}"><button class="btn btn-primary">CREAR NUEVO DOCUMENTO</button></a>
            </div>
            @endcan
            <br>

            <div class="card">
                <div class="card-body bg-gris-10">
                    <label>Mostrar documentos del mes:
                        <select id="mesSelect">
                            <option value="">Selecciona un mes</option>
                            @foreach ($meses as $numeroMes => $nombreMes)
                                <option value="{{ $numeroMes }}" {{ request('mes') == $numeroMes ? 'selected' : '' }} >
                                    {{ $nombreMes }}
                                </option>
                            @endforeach
                        </select><br>
                    </label>
                    
                        <table id='tabla'>
                            <thead>
                                <tr>
                                        <th scope="col" class="fs-4 text">Fecha modificacion</th>
                                        <th scope="col" class="fs-4 text">Titulo</th>
                                        <th scope="col" class="fs-4 text">Descripcion</th>
                                        <th scope="col" class="fs-4 text">fecha inicio</th>
                                        <th scope="col" class="fs-4 text">Archivo</th>
                                        <th scope="col" class="fs-4 text">Estado</th>
                                        <th scope="col" class="fs-4 text"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($documentos["estadosActuales"] as $documento)
                                    @if ($documento[0]['mes'] == request('mes'))
                                        @can('documentos.cerrado')
                                            @if ($documento[1]['estado'] == 'cerrado')
                                                <tr class="table-secondary">
                                                    <td class="text-bg-secondary p-3 fs-5 text" data-cell="disabled fecha_modificacion">{{date('d-m-Y',strtotime($documento[0]['fecha_modificacion']))}}</td>
                                                    <td class="text-bg-secondary p-3 fs-5 text" data-cell="titulo">{{$documento[1]['titulo']}}</td>
                                                    <td class="text-bg-secondary p-3 fs-5 text" data-cell="descripcion">{{$documento[1]['descripcion']}}</td>
                                                    <td class="text-bg-secondary p-3 fs-5 text" data-cell="fecha_inicio">{{date('d-m-Y H:i:s',strtotime($documento[1]['fecha_inicio']))}}</td>
                                                    <td class="text-bg-secondary p-3 fs-5 text" data-cell="archivo"></td>
                                                    <td class="text-bg-secondary p-3" data-cell="estado"><span class="badge text-bg-secondary fs-5 text text-uppercase">{{$documento[1]['estado']}}</span></td>
                                                    <td class="text-bg-secondary p-3 fs-5 text"></td>
                                                </tr>
                                            @endif
                                        @endcan
                                        
                                        @if ($documento[1]['estado'] == 'abierto')
                                            <tr class="disabled table-secondary">
                                                    @if ($documento[0]['estado_actual'] == 'a')
                                                        <td data-cell="fecha_modificacion" class="p-3 fs-5 text">
                                                        {{date('d-m-Y',strtotime($documento[0]['fecha_modificacion']))}}<br>
                                                        (ACTUALIZADO)
                                                        </td>
                                                    @endif
                                                    @if ($documento[0]['estado_actual'] == 'o')
                                                        <td data-cell="fecha_modificacion" class="p-3 fs-5 text">{{date('d-m-Y',strtotime($documento[0]['fecha_modificacion']))}}</td>
                                                    @endif
                                                    <td data-cell="titulo" class="p-3 fs-5 text">{{$documento[1]['titulo']}}</td>
                                                    <td data-cell="descripcion" class="p-3 fs-5 text">{{$documento[1]['descripcion']}}</td>
                                                    <td data-cell="fecha_inicio" class="p-3 fs-5 text">{{date('d-m-Y H:i:s',strtotime($documento[1]['fecha_inicio']))}}</td>
                                                    <td data-cell="archivo" class="p-3 fs-5 text"><a type="button" class="btn btn-success" href="{{ $documento[1]['archivo'] }}">Descargar</a></td>
                                                    <td data-cell="estado"><span class="badge text-bg-success fs-5 text text-uppercase">{{$documento[1]['estado']}}</span></td>
                                                    <td class='no-hover'>
                                                        <div class="btn-group" role="group">
                                                                @can('documentos.estado')  
                                                                    <button type="button" class="btn btn-secondary" 
                                                                    data-bs-toggle="modal"
                                                                    data-id="{{$documento[1]['id_documento']}}"
                                                                    data-bs-target="#cambiarEstadoModal" 
                                                                    data-bs-placement="left"
                                                                    data-bs-custom-class="tooltip-danger"
                                                                    data-bs-title="CAMBIAR Estado"><i class="bi bi-x-lg"></i></button>
                                                                @endcan
                                                                
                                                                @can('documentos.update')
                                                                    <a  href="/editar/{{$documento[1]['id_documento']}}">
                                                                    <button type="button" id="mod" class="btn btn-success "
                                                                    data-bs-toggle="tooltip" 
                                                                    data-bs-placement="right"
                                                                    data-bs-custom-class="tooltip-success"
                                                                    data-toggle="modal"
                                                                    data-target="#modalDocumento"
                                                                    data-bs-title="EDITAR Registro"><i class="bi bi-pen-fill"></i></button></a>
                                                                @endcan
                                                                
                                                        </div>

                                                    </td>
                                                    
                                        
                                                </tr>
                                        @endif
                                        <!-- final de if abiertos -->
                                        @if ($documento[1]['estado'] == 'pendiente')
                                        <tr class="table-secondary">
                                                    <td class="text-bg-info p-3 fs-5 text" data-cell="disabled fecha_modificacion">{{date('d-m-Y',strtotime($documento[0]['fecha_modificacion']))}}</td>
                                                    <td class="text-bg-info p-3 fs-5 text" data-cell="titulo">{{$documento[1]['titulo']}}</td>
                                                    <td class="text-bg-info p-3 fs-5 text" data-cell="descripcion">{{$documento[1]['descripcion']}}</td>
                                                    <td class="text-bg-info p-3 fs-5 text" data-cell="fecha_inicio">{{date('d-m-Y H:i:s',strtotime($documento[1]['fecha_inicio']))}}</td>
                                                    <td data-cell="archivo" class="text-bg-info p-3 fs-5 text"><a type="button" class="btn btn-success" href="{{ $documento[1]['archivo'] }}">Descargar</a></td>
                                                    <td class="text-bg-info p-3" data-cell="estado"><span class="badge text-bg-info fs-5 text text-uppercase">{{$documento[1]['estado']}}</span></td>
                                                    <td class='no-hover text-bg-info'>
                                                        <div class="btn-group" role="group">
                                                                @can('documentos.update')
                                                                    <a  href="/editar/{{$documento[1]['id_documento']}}">
                                                                    <button type="button" id="mod" class="btn btn-success "
                                                                    data-bs-toggle="tooltip" 
                                                                    data-bs-placement="right"
                                                                    data-bs-custom-class="tooltip-success"
                                                                    data-toggle="modal"
                                                                    data-target="#modalDocumento"
                                                                    data-bs-title="EDITAR Registro"><i class="bi bi-pen-fill"></i></button></a>
                                                                @endcan
                                                                
                                                        </div>

                                                    </td>
                                                </tr>
                                        @endif
                                        <!-- final de if de pendientes -->
                                    @endif    
                                     
                                @endforeach
                            </tbody>
                            <tfoot>
                                
                            </tfoot>
                        </table><br>
                </div>
            </div><br>
            <!-- fin de card con table -->
            
             
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



<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js' integrity='sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg==' crossorigin='anonymous' referrerpolicy='no-referrer'></script>
<script>
    $(document).ready(function () {
        // Inicializa DataTable
        $('#tabla').DataTable({
            "language": {
                "url": "/i18n/Spanish.json"
            }    
        });
    });
</script>
<script>
    document.getElementById('mesSelect').addEventListener('change', function() {
        const mesSeleccionado = this.value;
        window.location.href = window.location.pathname + '?mes=' + mesSeleccionado;
    });
   
</script>
<script>
    $('#cambiarEstadoModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    $('#confirmarCambioEstado').data('id', id);
  });

  $('#confirmarCambioEstado').click(function() {
    var id = $(this).data('id');
    $.ajax({
        url: '/cambiarestado/' + id,
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            $('#cambiarEstadoModal').modal('hide');
            window.location.reload();
        },
        
        error: function(error) {
           alert('Error al cambiar el estado del documento');
        }
           
    });
});
</script>
</body>


</html>
@endsection
