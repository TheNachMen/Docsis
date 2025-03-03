<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    
    <link href='https://framework.laserena.cl/css/frameworkV1.css' rel='stylesheet' />
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css' integrity='sha512-dPXYcDub/aeb08c63jRq/k6GaKccl256JQy/AnOq7CAnEZ9FzSL9wSbcZkMp4R26vBsMLFYH4kQ67/bbV8XaCQ==' crossorigin='anonymous' referrerpolicy='no-referrer' />
    

    <!-- Scripts -->
    @viteReactRefresh
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand d-none d-md-block" href="{{ route('documentos.index') }}"><img src='https://framework.laserena.cl/img/horizontal-blanco.svg'/></a>
        <a class="navbar-brand d-md-none d-block" href="{{ route('documentos.index') }}"><img src='https://framework.laserena.cl/img/escudo-blanco.svg'/></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navImls" aria-controls="navImls" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navImls">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle me-5" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                </a>
                <ul class="dropdown-menu pb-0">
                    @can('users.index')
                    <li class='bg-black'>
                        <a class="dropdown-item text-left" href="{{ route('documentos.index') }}"><i class="bi bi-lock-fill"></i>Admin</a>
                    </liclass>
                    @endcan
                    
                    
                    <li class='bg-danger'>
                        <a class="dropdown-item text-left" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();"><i class="bi bi-x-lg"></i> Cerrar Sesión</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                    </li>
                </ul>
            </li>
        </ul>
        </div>
    </div>
</nav>

        <main class="py-4">
            @yield('content')
        </main>

    </div>
    

</body>

</html>
