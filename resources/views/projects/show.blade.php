@extends('layouts.project')

@section('content-project')

<div class="container-fuid px-4 py-4">
    @include('components.alert')
    <div class="d-flex">
        <div class="flex-grow-1">
            <h2 class="mb-3">{{ __('Summary') }}</h2>
        </div>
        <div>
        </div>
    </div>
    <div class="d-flex flex-column flex-wrap">
        <div>
            {!! Str::markdown($project->description, ['html_input' => 'escape']) !!}
        </div>
        @php
            $subProjects = $project->children()->get()->filter(function($value, $key){
                return Auth::check() or $value->is_public;
            });
        @endphp
        @if($subProjects->count() > 0)
            <div class="card">
                <div class="card-header">{{ __('Sub Projects') }}</div>
                <div class="card-body">
                    @foreach($subProjects as $subProject)
                        <a href="{{ route('projects.show', ['project'=>$subProject]) }}">{{ __($subProject->name) }}</a>
                        @unless($loop->last),@endunless
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

@endsection