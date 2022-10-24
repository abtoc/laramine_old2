@extends('layouts.app')

@section('content')
@yield('content-projects')
@endsection

@section('navbar')

<nav class="navbar navbar-light bg-light flex-md-nowrap p-0 d-none d-md-block">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <x-nav-link href="{{ route('projects.index') }}" active="{{ is_route_named('projects.index') }}">
                {{ __('Project') }}
            </x-nav-link>
        </li>
        <li class="nav-item">
            <x-nav-link href="{{ route('issues.index') }}" active="{{ is_route_named('issues.*') }}">
                {{ __('Issue') }}
            </x-nav-link>
        </li>
    </ul>
</nav>
@endsection

@section('sidebar')
<h6 class="sidebar-heading justify-content-between align-items-center px-3 mt-3 mb-1 text-muted">{{ __('Project') }}</h6>
<ul class="navbar-nav d-flex">
    <li class="nav-item mx-3 text-muted"><a href="{{ route('projects.index') }}" class="nav-link text-secondary p-1">{{ __('Project') }}</a></li>
    <li class="nav-item mx-3 text-muted"><a href="{{ route('issues.index') }}" class="nav-link text-secondary p-1">{{ __('Issue') }}</a></li>
</ul>
@endsection
