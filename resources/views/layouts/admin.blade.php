@extends('layouts.app')

@section('content')
<div class="container-fuid d-flex flex-nowrap">
    <div class="d-flex flex-column flex-shrink-0 p-3 bg-white" style="width: 280px">
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item" aria-current="page">
                <a href="#" class="nav-link link-dark">
                    {{ __('User') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link link-dark" aria-current="page">
                    {{ __('Group') }}
                </a>
            </li>
        </ul>
    </div>
    @yield('content-admin')
</div>
@endsection