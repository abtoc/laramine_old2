@extends('layouts.app')

@section('content')
<div class="container-fuid d-flex align-items-stretch flex-nowrap w-100">
    <div class="d-flex flex-column flex-shrink-0 p-3 bg-white d-none d-md-block" style="width: 280px">
        <ul class="nav nav-pills flex-column mb-auto">
            @can('admin-projects')
                <li class="nav-item">
                    <a href="{{ route('projects.admin') }}" class="nav-link link-dark"><i class="bi bi-x-diamond"></i> {{ __('Project') }}</a>
                </li>
            @endcan
            @can('admin-users')
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link link-dark"><i class="bi bi-person"></i> {{ __('User') }}</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('groups.index') }}" class="nav-link link-dark"><i class="bi bi-people"></i> {{ __('Group') }}</a>
                </li>
            @endcan
            @can('admin')
                <li class="nav-item">
                    <a href="{{ route('roles.index') }}" class="nav-link link-dark"><i class="bi bi-key"></i> {{ __('Role') }}</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link link-dark"><i class="bi bi-sticky"></i> {{ __('Tracker') }}</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('issue_statuses.index') }}" class="nav-link link-dark"><i class="bi bi-pencil-square"></i> {{ __('Ticket Status') }}</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('enumerations.index') }}" class="nav-link link-dark"><i class="bi bi-list-ul"></i> {{ __('Choice Value') }}</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.info') }}" class="nav-link link-dark"><i class="bi bi-question-circle"></i> {{ __('Information') }}</a>
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
        <li class="nav-item mx-3 text-muted"><a href="{{ route('projects.admin') }}" class="nav-link text-secondary p-1"><i class="bi bi-x-diamond"></i> {{ __('Project') }}</a></li>
    @endcan
    @can('admin-users')
        <li class="nav-item mx-3 text-muted"><a href="{{ route('users.index') }}" class="nav-link text-secondary p-1"><i class="bi bi-person"></i> {{ __('User') }}</a></li>
        <li class="nav-item mx-3 text-muted"><a href="{{ route('groups.index') }}" class="nav-link text-secondary p-1"><i class="bi bi-people"></i> {{ __('Group') }}</a></li>
    @endcan
    @can('admin')
        <li class="nav-item mx-3 text-muted"><a href="{{ route('roles.index') }}" class="nav-link text-secondary p-1"><i class="bi bi-key"></i> {{ __('Role') }}</a></li>
        <li class="nav-item mx-3 text-muted"><a href="#" class="nav-link text-secondary p-1"><i class="bi bi-sticky"></i> {{ __('Tracker') }}</a></li>
        <li class="nav-items mx-3 text-muted"><a href="{{ route('issue_statuses.index') }}" class="nav-link text-secondary p-1"><i class="bi bi-pencil-square"></i> {{ __('Ticket Status') }}</a></li>
        <li class="nav-items mx-3 text-muted"><a href="{{ route('enumerations.index') }}" class="nav-link text-secondary p-1"><i class="bi bi-list-ul"></i> {{ __('Choice Value') }}</a></li>
        <li class="nav-items mx-3 text-muted"><a href="{{ route('admin.info') }}" class="nav-link text-secondary p-1"><i class="bi bi-question-circle"></i> {{ __('Information') }}</a></li>
    @endcan
</ul>
@endsection
