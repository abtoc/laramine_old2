@extends('layouts.app')

@section('content')
<div class="container-fuid d-flex align-items-stretch flex-nowrap w-100">
    <div class="d-flex flex-column flex-shrink-0 p-3 bg-white" style="width: 280px">
        <ul class="nav nav-pills flex-column mb-auto">
            @can('admin')
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link link-dark bi bi-person"> {{ __('User') }}</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('groups.index') }}" class="nav-link link-dark bi bi-people"> {{ __('Group') }}</a>
                </li>
            @elsecan('admin-users')
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