@extends('layouts.admin')

@section('content-admin')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <nav>
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route_query('groups.index') }}">{{ __('Group') }}</a></li>
                            <li class="breadcrumb-item active">{{ $group->name }}</li>
                        </ol>
                    </nav>
                </div>

                <div class="card-body">
                    <x-alert/>
                    <ul class="nav nav-tabs mb-3">
                        <li class="nav-item">
                            <a href="{{ route_query('groups.edit', ['group' => $group])}}" class="nav-link" >{{ __('All') }}</a>
                        </li>
                        @if($group->isGroup(true))
                            <li class="nav-item">
                                <a href="{{ route_query('groups.users', ['group' => $group])}}" class="nav-link active" aria-current="page">{{ __('User') }}</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route_query('groups.projects', ['group' => $group]) }}" class="nav-link">{{ __('Project') }}</a>
                        </li>
                    </ul>
                    @livewire('group-users', ['group'=>$group])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
