@extends('layouts.admin')

@section('content-admin')

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Project') }}</div>
                <div class="card-body">
                    @include('components.alert')
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
                                                <a href="{{ route('projects.edit', ['project' => $project]) }}">
                                                    {{ __($project->name) }}
                                                </a>
                                            </td>
                                            <td class="text-center">@if($project->is_public)<i class="bi bi-check"></i> @endif</td>
                                            <td class="text-center">{{ $project->created_at->toDateString() }}</td>
                                            <td class="text-end">
                                                <a href="{{ route('projects.destroy', ['project' => $project]) }}" class="link-dark bi bi-trash text-decoration-none"
                                                    onclick="event.preventDefault();
                                                    document.getElementById('projects-destroy-{{$project->id}}').submit();">
                                                    {{ __('Delete') }}
                                                </a>
                                                <form method="POST" class="d-none" action="{{ route('projects.destroy', ['project'=>$project])}}" id="projects-destroy-{{$project->id}}">
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
