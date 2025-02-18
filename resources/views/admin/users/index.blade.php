@extends('adminlte::page')

@section('title', 'Panel de administración')

@section('content_header')
<h1>Lista de usuarios</h1>
@endsection

@section('content')
<head>
<link href='https://framework.laserena.cl/css/frameworkV1.css' rel='stylesheet' />
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap.min.css' integrity='sha512-BMbq2It2D3J17/C7aRklzOODG1IQ3+MHw3ifzBHMBwGO/0yUqYmsStgBjI0z5EYlaDEFnvYV7gNYdD3vFLRKsA==' crossorigin='anonymous' referrerpolicy='no-referrer' />
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css' integrity='sha512-dPXYcDub/aeb08c63jRq/k6GaKccl256JQy/AnOq7CAnEZ9FzSL9wSbcZkMp4R26vBsMLFYH4kQ67/bbV8XaCQ==' crossorigin='anonymous' referrerpolicy='no-referrer' />
</head>
<body>
    <div class="card">
    <div class="card-body">
        
        <table id='tabla'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Acciónes</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td data-cell="col-1">{{ $user->id }}</td>
                    <td data-cell="col-2">{{ $user->name }}</td>
                    <td data-cell="col-3">{{ $user->email }}</td>
                    <td class='no-hover'>
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.user.edit',$user->id) }}">
                                <button type="button" class="btn btn-success btn-sm"
                                data-bs-toggle="tooltip" 
                                data-bs-placement="right"
                                data-bs-custom-class="tooltip-success"
                                data-bs-title="EDITAR Registro"><i class="bi bi-pen-fill"></i></button>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                
            </tfoot>
        </table>
  

        <div class="text-center mt-3">
            {{ $users->links() }}
        </div>

    </div>
</div>
</body>

<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js' integrity='sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz' crossorigin='anonymous'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js' integrity='sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg==' crossorigin='anonymous' referrerpolicy='no-referrer'></script>
@endsection



