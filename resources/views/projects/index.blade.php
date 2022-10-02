@extends('layouts.projects')

@section('content-projects')

<div class="container-fluid py-4">
    <div id="projects-index">
        <ul class="projects root">
            @each('components.project-item', $projects, 'project')
        </ul>
    </div>
</div>

@endsection
