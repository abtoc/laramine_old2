@extends('layouts.project')

@section('content-project')

<div class="container-fuid px-4 py-4">
    <x-alert/>
    <div class="d-flex">
        <div class="flex-grow-1">
            <h2 class="mb-3">{{ __('Summary') }}</h2>
        </div>
        <div>
            @canany(['update','open','close'], $project)
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle link-dark text-decoration-none" role="button" id="project-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="project-dropdown">
                        @can('close', $project)
                            <li>
                                <a href="{{ route('projects.close', ['project' => $project]) }}" class="dropdown-item link-dark text-decoration-none" data-submit-for="#project-close">
                                    <i class="bi bi-stop"></i>
                                    {{ __('End') }}
                                </a>
                                <form action="{{ route('projects.close', ['project' => $project]) }}" id="project-close" method="POST">
                                    @csrf
                                    @method('PUT')
                                </form>
                            </li>
                        @endcan
                        @can('open', $project)
                            <li>
                                <a href="{{ route('projects.open', ['project' => $project])}}" class="dropdown-item link-dark text-decoration-none" data-submit-for="#project-open">
                                    <i class="bi bi-play"></i>
                                    {{ __('Start') }}
                                </a>
                                <form action="{{ route('projects.open', ['project' => $project]) }}" id="project-open" method="POST">
                                    @csrf
                                    @method('PUT')
                                </form>
                            </li>
                        @endcan
                        @can('update', $project)
                            <li>
                                <a href="{{ route('projects.edit.setting', ['project' => $project])}}" class="dropdown-item link-dark text-decoration-none">
                                    <i class="bi bi-gear"></i>
                                    {{ __('Setting') }}
                                </a>
                            </li>              
                        @endcan
                    </ul>
                </div>
            @endcanany
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            @unless(is_null($project->description))
                <div class="markdown-body mb-3">
                    {{ markdown($project->description) }}
                </div>
            @endunless
            @if($project->issue_tracking->count() > 0)
                <div class="card mb-3">
                    <div class="card-header">{{ __('Ticket Tracking') }}</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-sm text-nowrap">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th class="text-center">{{ __('Pending') }}</th>
                                        <th class="text-center">{{ __('Completed') }}</th>
                                        <th class="text-center">{{ __('Total') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($project->issue_tracking as $tracking)
                                        <tr>
                                            <td class="text-start">
                                                {{ $tracking->tracker->name }}
                                            </td>
                                            <td class="text-center">
                                                {{ $tracking->pending }}
                                            </td>
                                            <td class="text-center">
                                                {{ $tracking->completed }}
                                            </td>
                                            <td class="text-center">
                                                {{ $tracking->total }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-lg-6">
            @if(count($users) > 0)
                <div class="card mb-3">
                    <div class="card-header">{{ __('Member') }}</div>
                    <div class="card-body">
                        @foreach($users as $key => $value)
                            <p>
                                <span>{{ preg_replace('/^[0-9]+.(.*)$/','$1', $key) }}:</span>
                                @foreach($value as $user)
                                    @if($user->isUser())
                                        @can('view', $user)
                                            <a href="{{ route('users.show', ['user'=>$user->id]) }}"> {{ $user->name }}</a>
                                        @else
                                            <span>{{ $user->name }}</span>                                            
                                        @endcan
                                    @else
                                        <span>{{ $user->name }}</span>
                                    @endif
                                    @unless($loop->last),@endunless
                                @endforeach
                            </p>
                        @endforeach
                    </div>
                </div>
            @endif
            @if($project->getSubProjects()->count() > 0)
                <div class="card mb-3">
                    <div class="card-header">{{ __('Sub Projects') }}</div>
                    <div class="card-body">
                        @foreach($project->getSubProjects() as $subProject)
                            <a href="{{ route('projects.show', ['project'=>$subProject]) }}" @class(['link-dark' => !$subProject->isActive()])>{{ __($subProject->name) }}</a>
                            @unless($loop->last),@endunless
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection