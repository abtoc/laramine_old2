@extends('layouts.app')

@section('title', $project->name)

@section('content')
@yield('content-project')
@endsection

@section('navbar')

<nav class="navbar navbar-light bg-light flex-md-nowrap p-0 d-none d-md-block">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <x-nav-link href="{{ route('projects.show', ['project' => $project]) }}" active="{{ is_route_named('projects.show') }}">
                {{ __('Summary') }}
            </x-nav-link>
        </li>
        @can('update', $project)
            <li class="nav-item">
                <x-nav-link href="{{ route('projects.edit.setting', ['project'=>$project]) }}" active="{{ is_route_named('projects.edit.*') }}">
                    {{ __('Setting') }}
                </x-nav-link>
            </li>
        @endcan
    </ul>
</nav>

@endsection

@section('sidebar')
<h6 class="sidebar-heading justify-content-between align-items-center px-3 mt-3 mb-1 text-muted">{{ __('Project') }}</h6>
<ul class="navbar-nav d-flex">
    <li class="nav-item mx-3 text-muted"><a href="{{ route('projects.show', ['project'=>$project]) }}" class="nav-link text-secondary p-1">{{ __('Summary') }}</a></li>
    @can('update', $project)
        <li class="nav-item mx-3 text-muted"><a href="{{ route('projects.edit.setting', ['project'=>$project]) }}" class="nav-link text-secondary p-1">{{ __('Setting') }}</a></li>
    @endcan
</ul>
@endsection
