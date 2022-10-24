@extends('layouts.projects')

@section('content-projects')

<div class="container-fluid py-4">
    <x-alert/>
    <div id="projects-index">
        <ul class="projects root">
            @each('projects.index-item', $projects, 'project')
        </ul>
    </div>
</div>

@endsection
