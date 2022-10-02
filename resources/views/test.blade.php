<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script src="{{ mix('js/app.js') }}" defer></script>
    @stack('styles')
    @livewireStyles
</head>
<body>
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <span class="navbar-brand col-md-3 col-lg-2 me-0 px-3">Dashboard</span>
        <button class="navbar-toggler d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu" aria-controls="sidebar-menu" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
        <input type="text" class="form-control form-control-dark w-100" placeholder="Search" aria-label="Search">
        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <a href="#" class="nav-link px-3">{{ __('Logout') }}</a>
            </div>
        </div>
    </header>
    <div class="container-fluid">
        <div class="row">
            <nav id="sidebar-menu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item"><a href="#" class="nav-link active" aria-current="page">Dashboard</a></li>
                    </ul>
                    <ul class="nav flex-column">
                        <li class="nav-item"><a href="#" class="nav-link">Orders</a></li>
                    </ul>
                </div>
                <h6 class="sidebar-heading d-flex justify-content-bettween align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Saved reports</span>
                    <a href="#" class="link-secondary" aria-label="Add a new report">
                        <i class="bi bi-plus"></i>
                    </a>
                </h6>
            </nav>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4"></main>
        </div>
    </div>
    @livewireScripts
    @stack('scripts')
</body>
</html>
