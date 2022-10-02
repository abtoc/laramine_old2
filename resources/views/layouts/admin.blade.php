@extends('layouts.app')

@section('content')
<div class="container-fuid d-flex align-items-stretch flex-nowrap w-100">
    <div class="d-flex flex-column flex-shrink-0 p-3 bg-white d-none d-md-block" style="width: 280px">
        <ul class="nav nav-pills flex-column mb-auto">
            @can('admin-projects')
                <li class="nav-item">
                    <a href="{{ route('projects.admin') }}" class="nav-link link-dark bi bi-x-diamond"> {{ __('Project') }}</a>
                </li>
            @endcan
            @can('admin-users')
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link link-dark bi bi-person"> {{ __('User') }}</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('groups.index') }}" class="nav-link link-dark bi bi-people"> {{ __('Group') }}</a>
                </li>
            @endcan
        </ul>
    </div>
    <div class="align-items-stretch flex-glow-1 w-100">
        @yield('content-admin')
    </div>
</div>
@endsection

@section('sidebar')
<h6 class="sidebar-heading justify-content-between align-items-center px-3 mt-3 mb-1 text-muted">{{ __('Admin') }}</h6>
<ul class="navbar-nav d-flex">
    @can('admin-projects')
        <li class="nav-item mx-3 text-muted"><a href="{{ route('projects.admin') }}" class="nav-link text-secondary p-1 bi bi-x-diamond">{{ __('Project') }}</a></li>
    @endcan
    @can('admin-users')
        <li class="nav-item mx-3 text-muted"><a href="{{ route('users.index') }}" class="nav-link text-secondary p-1 bi bi-person">{{ __('User') }}</a></li>
        <li class="nav-item mx-3 text-muted"><a href="{{ route('groups.index') }}" class="nav-link text-secondary p-1 bi bi-people">{{ __('Group') }}</a></li>
    @endcan
</ul>
@endsection
