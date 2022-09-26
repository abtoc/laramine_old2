@extends('layouts.admin')

@section('content-admin')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <nav>
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('groups.index', request()->query()) }}">{{ __('Group') }}</a></li>
                            <li class="breadcrumb-item active">{{ $group->name }}</li>
                        </ol>
                    </nav>
                </div>

                <div class="card-body">
                    <ul class="nav nav-tabs mb-3">
                        <li class="nav-item">
                            <a href="{{ route('groups.edit', ['group' => $group])}}" class="nav-link"  href="#">{{ __('All') }}</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('groups.users', ['group' => $group])}}" class="nav-link" >{{ __('User') }}</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('groups.projects', ['group' => $group]) }}" class="nav-link active" aria-current="page">{{ __('Project') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
