@extends('layouts.project')

@section('title', $project->name)

@section('content-project')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <nav>
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item active">{{ __('Edit Project') }}</li>
                        </ol>
                    </nav>
                </div>

                <div class="card-body">
                    <x-alert/>
                    <x-project-edit-tab :project="$project"/>
                    @livewire('project-users', ['project'=>$project])
                </div>
            </div>
        </div>
    </div>
</div>

@endsection