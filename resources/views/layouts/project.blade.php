@extends('layouts.app')

@section('content')
@yield('content-project')
@endsection

@section('navbar')
@php
    $name = Route::currentRouteName();
@endphp

<div class="navbar navbar-light sticky-top bg-light flex-md-nowrap p-0 d-none d-md-block">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            @php
                $isShow = ($name === 'projects.show');
            @endphp
            <a href="{{ route('projects.show', ['project'=>$project]) }}" @class(['nav-link', 'active' => $isShow]) @if($isShow) aria-current="page" @endif)>
                {{ __('Summary') }}
            </a>
        </li>
        @can('admin-projects')
            <li class="nav-item">
                @php
                    $isEdit = ($name === 'projects.edit');
                @endphp
                <a href="{{ route('projects.edit', ['project'=>$project]) }}" @class(['nav-link', 'active' => $isEdit]) @if($isEdit) aria-current="page" @endif)>
                    {{ __('Setting') }}
                </a>
            </li>
        @endcan
    </ul>
</div>
@endsection

@section('sidebar')
<h6 class="sidebar-heading justify-content-between align-items-center px-3 mt-3 mb-1 text-muted">{{ __('Project') }}</h6>
<ul class="navbar-nav d-flex">
    <li class="nav-item mx-3 text-muted"><a href="{{ route('projects.show', ['project'=>$project]) }}" class="nav-link text-secondary p-1">{{ __('Summary') }}</a></li>
    @can('admin-projects')
        <li class="nav-item mx-3 text-muted"><a href="{{ route('projects.edit', ['project'=>$project]) }}" class="nav-link text-secondary p-1">{{ __('Setting') }}</a></li>
    @endcan
</ul>
@endsection
