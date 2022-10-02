<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laramine') }}</title>

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
    <header>
        <div class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 d-none d-md-block">
            <div class="container-fluid">
                <ul class="navbar-nav me-auto flex-row">
                    <li class="nav-item">
                        <a href="/" class="nav-link p-0">{{ __('Home')}}</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link p-0 px-1">{{ __('MyPage')}}</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('projects.index') }}" class="nav-link p-0 px-1">{{ __('Project')}}</a>
                    </li>
                    @can('admin-all')
                        <li class="nav-item">
                            <a href="{{ route('admin') }}" class="nav-link p-0 px-1">{{ __('Admin') }}</a>
                        </li>
                    @endcan
                </ul>
                <ul class="navbar-nav ms-auto flex-row">
                    @auth
                        <li class="nav-item">
                            <a href="{{ route('users.show', ['user' => Auth::user()]) }}" class="nav-link p-0 px-1">{{ Auth::user()->name }}</a>
                        </li>
                    @endauth
                </ul>
             </div>
        </div>
        <div class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
            <a href="/" class="navbar-brand col-md-3 col-lg-2 me-0 px-3 d-none d-md-block">@yield('title', config('app.name', 'Laravel'))</a>
            <div class="input-group w-100">
                <button class="navbar-toggler d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu" aria-controls="sidebar-menu" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <input type="text" class="form-control form-control-dark" placeholder="Search" aria-label="Search">
            </div>
            <div class="navbar-nav d-none d-md-block">
                <div class="nav-item text-nowrap">
                    @guest
                        @if(Route::has('login'))
                            <a href="{{ route('login') }}" class="nav-link d-inline px-1">{{ __('Login') }}</a>
                        @endif
                        @if(Route::has('register'))
                            <a href="{{ route('register') }}" class="nav-link d-inline px-1">{{ __('Register') }}</a>
                        @endif
                    @else    
                        <a href="{{ route('logout') }}" class="nav-link px-1" onclick="event.preventDefault();document.getElementById('logout-form-nav').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form action="{{ route('logout') }}" id="logout-form-nav" method="POST">@csrf</form>
                    @endguest
                </div>
            </div>
        </div>
        @yield('navbar')
    </header>
    <div class="container-fluid">
        <div class="row">
            <nav id="sidebar-menu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse d-md-none">
                @auth
                    <ul class="navbar-nav d-flex mt-3">
                        <li class="nav-item mx-3 text-muted">{{ Auth::user()->name }}</li>
                    </ul>
                @endauth
                <h6 class="sidebar-heading justify-content-between align-items-center px-3 mt-3 mb-1 text-muted">{{ __('All') }}</h6>
                <ul class="navbar-nav d-flex">
                    <li class="nav-item mx-3 text-muted"><a href="/" class="nav-link text-secondary p-1">{{ __('Home') }}</a></li>
                    <li class="nav-item mx-3 text-muted"><a href="{{ route('home') }}" class="nav-link text-secondary p-1">{{ __('MyPage') }}</a></li>
                    <li class="nav-item mx-3 text-muted"><a href="{{ route('projects.index') }}" class="nav-link text-secondary p-1">{{ __('Project') }}</a></li>
                    @can('admin-all')
                        <li class="nav-item mx-3 text-muted"><a href="{{ route('admin') }}" class="nav-link text-secondary p-1">{{ __('Admin') }}</a></li>
                    @endcan
                    </ul>
                @yield('sidebar')
                <h6 class="sidebar-heading justify-content-between align-items-center px-3 mt-3 mb-1 text-muted">{{ __('Profile') }}</h6>
                <ul class="navbar-nav d-flex">
                    @guest
                        @if(Route::has('login'))
                            <li class="nav-item mx-3 text-muted">
                                <a href="{{ route('login') }}" class="nav-link text-secondary p-1">{{ __('Login') }}</a>
                            </li>
                        @endif
                        @if(Route::has('register'))
                            <li class="nav-item mx-3 text-muted">
                                <a href="{{ route('register') }}" class="nav-link text-secondary p-1">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item mx-3 text-muted">
                            <a href="{{ route('logout') }}" class="nav-link text-secondary p-1" onclick="event.preventDefault();document.getElementById('logout-form-nav').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form action="{{ route('logout') }}" id="logout-form-sidebar" method="POST">@csrf</form>
                        </li>
                    @endguest
                </ul>
            </nav>
            <main>@yield('content')</main>
        </div>
    </div>
    <footer class="footer mt-auto bg-light fixed-bottom">
        <div class="container">
            <div class="text-center text-muted fs-6">Powered by Laramine © 2022-2022 abtoc</div>
        </div>
    </footer>
    @livewireScripts
    @stack('scripts')
</body>
</html>
