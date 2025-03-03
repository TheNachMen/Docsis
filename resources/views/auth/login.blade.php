<head>
    <link href='https://framework.laserena.cl/css/frameworkV1.css' rel='stylesheet' />
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH' crossorigin='anonymous'>
</head>
<body>
    <section class='h-100'>
    <body class="bg-muni">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-md-6 offset-md-3 col-12">
                    <div class="card shadow">
                        <div class="card-header bg-muni">
                            <div class="row align-items-center">
                                <div class="col-md-4 col-6">
                                    <div class="p-2 text-center border-end border-light">
                                        <img class='img-fluid' src="https://framework.laserena.cl/img/horizontal-blanco.svg" alt="" />
                                    </div>
                                </div>
                                <div class="col-md-8 col-6">
                                    <div class="tx-5 fw-bold text-light">
                                        Login Municipal
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <p>
                                <label class="form-label">Usuario</label>
                                <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Ingrese su usuario" value="{{ old('email') }}" required/>
                                @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </p>
                            <p>
                                <label class="form-label">Clave</label>
                                <input type="password" id="password" class="form-control  @error('password') is-invalid @enderror" placeholder="Ingrese su clave" name="password" required autocomplete="current-password" required/>
                                @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </p>
                            <div class="row">
                                    <div class="col-md-7 col-12 text-end order-md-2 order-1 mb-2 text-md-end text-center">
                                    <button type="submit" class='btn btn-success'>Ingresar</button>
                                    </div>
                            </div>
                            </form>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div> 
    </body>
    
</section>
</body>
<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js' integrity='sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz' crossorigin='anonymous'></script>




