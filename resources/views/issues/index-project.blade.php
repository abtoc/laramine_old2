@extends('layouts.project')

@section('content-project')

<div class="container-fluid py-4">
    <x-alert/>
    <div class="d-flex">
        <div class="flex-grow-1">
            <h2 class="mb-3">{{ __('Issue' )}}</h2>
        </div>
        @can('create', App\Models\Issue::class)
            <div>
                <a class="link-dark text-decoration-none" href="{{ route('issues.create_project', ['project' => $project]) }}">
                    <i class="bi bi-plus-circle"></i>
                    {{ __('New Issue') }}
                </a>
            </div>
        @endcan
    </div>
    <x-issue-query :project="$project"/>
    <x-issue-list :issues="$issues"/>
</div>

@endsection