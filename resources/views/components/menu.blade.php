<nav class="navbar navbar-expand-md navbar-light shadow-sm p-0">
    <div class="container-fluid">
        <div class="navbar-brand p-0"></div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu-navbar" aria-controls="menu-navbar" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menu-navbar">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a href="/" class="nav-link py-0">{{ __('Home') }}</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('projects.index') }}" class="nav-link py-0">{{ __('Project') }}</a>
                </li>
                @if(Gate::check('admin') or Gate::check('admin-users'))
                    <li class="nav-item">
                        <a href="{{ route('admin') }}" class="nav-link py-0">{{ __('Admin') }}</a>
                    </li>
                @endif
            </ul>
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                @guest
                    @if(Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link py-0" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link py-0" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    @env('local')
                        <li class="nav-item">
                            <a href="/telescope" class="nav-link py-0">Telescope</a>
                        </li>
                    @endenv
                    <li class="nav-item drop-down">
                        <a href="#" id="menu-dropdown" class="nav-link dropdown-toggle py-0" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="menu-dropdown">
                            <li>
                                <a href="{{ route('users.show', ['user' => Auth::user()]) }}" class="dropdown-item">
                                    {{ __('User Infomation') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('my.password.edit') }}" class="dropdown-item">
                                    {{ __('Change Password') }}
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a href="{{ route('logout') }}" class="dropdown-item"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit()">
                                    {{ __('Logout') }}
                                </a>
                                <form action="{{ route('logout') }}" id="logout-form" method="POST">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>