@extends('layouts.project')

@section('title', $project->name)

@section('content-project')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <nav>
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item active">{{ __('Issue Tracking') }}</li>
                        </ol>
                    </nav>
                </div>

                <div class="card-body">
                    <x-alert/>
                    <x-project-edit-tab :project="$project"/>
                    <form method="POST" action="{{ route("projects.update.issues", ['project' => $project]) }}">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <label for="trackers" class="col-md-3 col-lg-2 col-form-label text-md-end">{{ __('Tracker') }}</label>

                            <div class="col-md-9 col-lg-10 d-flex flex-row flex-wrap">
                                @foreach($trackers as $tracker)
                                    <div class="form-check floating">
                                        <input type="checkbox" name="trackers[]" value="{{ $tracker->id }}" class="form-check-input" id="tracker-{{ $tracker->id }}" @checked(in_array($tracker->id, $selected))>
                                        <label for="tracker-{{ $tracker->id }}" class="form-check-label">{{ $tracker->name }}</label>
                                    </div>                                    
                                @endforeach
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 col-lg-6 offset-md-3 offset-lg-2">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection