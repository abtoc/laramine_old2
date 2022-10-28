@extends('layouts.projects')

@section('content-projects')

<div class="container-fluid py-4">
    <x-alert/>
    <div class="d-flex">
        <div class="flex-grow-1">
            <h2 class="mb-3">{{ __('Issue' )}}</h2>
        </div>
        @can('create', App\Models\Issue::class)
            <div>
                <a class="link-dark text-decoration-none" href="{{ route('issues.create') }}">
                    <i class="bi bi-plus-circle"></i>
                    {{ __('New Issue') }}
                </a>
            </div>
        @endcan
    </div>
    <x-issue-query :project="null"/>   
    <x-issue-list :issues="$issues"/>
</div>

@endsection