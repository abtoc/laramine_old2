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
                    <a href="#" class="dropdown-toggle link-dark text-decoration-none bi bi-three-dots" role="button" id="project-dropdown" data-bs-toggle="dropdown" aria-expanded="false"></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="project-dropdown">
                        @can('close', $project)
                            <li>
                                <a href="{{ route('projects.close', ['project' => $project]) }}" class="dropdown-item link-dark text-decoration-none bi bi-stop" data-submit-for="#project-close">
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
                                <a href="{{ route('projects.open', ['project' => $project])}}" class="dropdown-item link-dark text-decoration-none bi bi-play" data-submit-for="#project-open">
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
                                <a href="{{ route('projects.edit.setting', ['project' => $project])}}" class="dropdown-item link-dark text-decoration-none bi bi-gear">{{ __('Setting') }}</a>
                            </li>              
                        @endcan
                    </ul>
                </div>
            @endcanany
        </div>
    </div>
    <div class="d-flex flex-column flex-wrap">
        @unless(is_null($project->description))
            <div class="markdown-body mb-3">
                {{ markdown($project->description) }}
            </div>
        @endunless
        @if($project->getSubProjects()->count() > 0)
            <div class="card">
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

@endsection