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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.css">
    <script src="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.js"></script>
    @stack('styles')
    @livewireStyles
</head>
<body>
    <div class="d-flex flex-column h-100">
        <header>
            <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 d-none d-md-block">
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
                        @guest
                            @if(Route::has('login'))
                                <li class="nav-item">
                                    <a href="{{ route('login') }}" class="nav-link p-0 px-1">{{ __('Login') }}</a>
                                </li>
                            @endif
                            @if(Route::has('register'))
                                <li class="nav-item">
                                    <a href="{{ route('register') }}" class="nav-link p-0 px-1">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a href="{{ route('users.show', ['user' => Auth::user()]) }}" class="nav-link p-0 px-1">{{ Auth::user()->name }}</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('my.password.edit') }}" class="nav-link p-0 px-1">{{ __('Change Password') }}</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('logout') }}" class="nav-link p-0 px-1" onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST">@csrf</form>
                            </li>
                        @endguest
                    </ul>
                 </div>
            </nav>
            <nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top">
                <div class="container-fluid">
                    <span class="navbar-brand d-none d-md-block">@yield('title', config('app.name', 'Laravel'))</span>
                    <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#sidebar-menu" aria-controls="sidebar-menu" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="navbar-nav ms-auto">
                        <form action="#" class="px-1 d-none d-md-block">
                            <input type="text" class="form-control" name="search">
                        </form>
                        <form action="#" class="px-1">
                            <select name="" id="" class="form-select">
                                <option value=""></option>
                                <option value="11111111">AAAAAAAA</option>
                                <option value="11111111">BBBBBBBB</option>
                                <option value="11111111">CCCCCCCC</option>
                                <option value="11111111">DDDDDDDD</option>
                            </select>
                        </form>
                    </div>
                </div>
            </nav>
            @yield('navbar')
        </header>
        <div class="flex-grow-1 container-fluid">
            <div class="row">
                <nav id="sidebar-menu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse d-md-none">
                    <form action="">
                        <input type="text" class="form-control" name="searcg">
                    </form>
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
                                <a href="{{ route('my.password.edit') }}" class="nav-link text-secondary p-1">{{ __('Change Password') }}</a>
                            </li>
                            <li class="nav-item mx-3 text-muted">
                                <a href="{{ route('logout') }}" class="nav-link text-secondary p-1" onclick="event.preventDefault();document.getElementById('logout-form-nav').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form action="{{ route('logout') }}" id="logout-form-nav" method="POST">@csrf</form>
                            </li>
                        @endguest
                    </ul>
                </nav>
                <main>@yield('content')</main>
            </div>
        </div>
    <!--    <footer class="footer mt-auto bg-light fixed-bottom"> -->
        <footer class="footer mt-auto">
            <div class="container">
                <div class="text-center text-muted fs-6">Powered by Laramine © 2022-2022 abtoc</div>
            </div>
        </footer>
    </div>
    @livewireScripts
    @stack('scripts')
</body>
</html>
