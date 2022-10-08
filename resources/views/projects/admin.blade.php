@extends('layouts.admin')

@section('content-admin')

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Project') }}</div>
                <div class="card-body">
                    <x-alert/>
                    <div class="row mb-3">
                        <form id="search-project" action="{{ route('projects.admin') }}" method="GET">
                            <div class="row g-1">
                                <label for="status" class="col-auto col-form-label text-md-end">{{ __('Status') }}:</label>
                                <div class="col-auto">
                                    <select name="status" id="status" class="form-select" onchange="document.getElementById('search-project').submit();">
                                        @foreach(App\Enums\ProjectStatus::cases() as $status)
                                            <option value="{{ $status->value }}" @selected(request()->query('status', 1) == $status->value)>{{ $status->string() }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="name" class="col-auto col-form-label text-md-end">{{ __('Name') }}:</label>
                                <div class="col-auto">
                                    <input type="text" id="name" name="name" class="form-control" value="{{ request()->query('name', '') }}">
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-primary" type="submit">{{ __('Apply')}}</button>
                                </div>
                            </div>
                        </form>                        

                    </div>
                    <div class="row mb-3">
                        <div class="table-responsive">
                            <table class="table table-hover table-sm text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">{{ __('Project') }}</th>
                                        <th class="text-center">{{ __('Public') }}</th>
                                        <th class="text-center">{{ __('CreatedAt') }}</th>
                                        <th class="text-end">
                                            <a class="bi bi-plus-circle link-dark text-decoration-none" href="{{ route('projects.create') }}"> {{ __('Create Project')}}</a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($projects as $project)
                                        <tr @class(['lock' => !$project->isActive()])>
                                            <td class="text-start">
                                                {!! str_repeat('&nbsp;&nbsp;&nbsp;', $project->depth) !!}@if($project->depth > 0) > @endif
                                                @if($project->isArchive())
                                                    <span>{{ $project->name }}</span>
                                                @else
                                                    <a href="{{ route('projects.edit.setting', ['project' => $project]) }}">
                                                        {{ $project->name }}
                                                    </a>
                                                @endif
                                            </td>
                                            <td class="text-center">@if($project->is_public)<i class="bi bi-check"></i> @endif</td>
                                            <td class="text-center">{{ $project->created_at->toDateString() }}</td>
                                            <td class="text-end">
                                                @if($project->isArchive())
                                                    <a href="{{ route_query('projects.open', ['project' => $project]) }}" class="link-dark bi bi-unlock text-decoration-none"
                                                        onclick="event.preventDefault();
                                                        document.getElementById('projects-unlock-{{$project->id}}').submit();">
                                                        {{ __('ArchiveRelese') }}
                                                    </a>
                                                    <form method="POST" class="d-none" action="{{ route_query('projects.open', ['project'=>$project])}}" id="projects-unlock-{{$project->id}}">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="_previous" value="{{ route_query('projects.admin') }}">
                                                    </form>
                                                @else
                                                    <a href="{{ route_query('projects.archive', ['project' => $project]) }}" class="link-dark bi bi-lock text-decoration-none"
                                                        onclick="event.preventDefault();
                                                        document.getElementById('projects-lock-{{$project->id}}').submit();">
                                                        {{ __('Archive') }}
                                                    </a>
                                                    <form method="POST" class="d-none" action="{{ route_query('projects.archive', ['project'=>$project])}}" id="projects-lock-{{$project->id}}">
                                                        @csrf
                                                        @method('PUT')
                                                    </form>
                                                @endif
                                                <a href="{{ route_query('projects.destroy', ['project' => $project]) }}" class="link-dark bi bi-trash text-decoration-none"
                                                    onclick="event.preventDefault();
                                                    document.getElementById('projects-destroy-{{$project->id}}').submit();">
                                                    {{ __('Delete') }}
                                                </a>
                                                <form method="POST" class="d-none" action="{{ route_query('projects.destroy', ['project'=>$project])}}" id="projects-destroy-{{$project->id}}">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">
                                                <div class="alert alert-warning">{{ __('No data to display.') }}</div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
