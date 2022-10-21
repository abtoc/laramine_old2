@extends('layouts.admin')

@section('content-admin')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <nav>
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route_query('trackers.index') }}">{{ __('Tracker') }}</a></li>
                            <li class="breadcrumb-item active">{{ $tracker->name }}</li>
                        </ol>
                    </nav>
                </div>

                <div class="card-body">
                    <x-alert/>
                    <form method="POST" action="{{ route_query('trackers.update', ['tracker' => $tracker]) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row mb-3">
                                    <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}<small class="required">*</small></label>
        
                                    <div class="col-md-8">
                                        <input id="name" type="text" class="form-control @invalid('name')" name="name" value="{{ old('name', $tracker->name) }}" required autocomplete="name" autofocus>
                                        <x-invalid-feedback name="name"/>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="issue-statu-id" class="col-md-4 col-form-label text-md-end">{{ __('Default Status') }}<small class="required">*</small></label>

                                    <div class="col-md-8">
                                        <select name="issue_status_id" id="issue-status-id" class="form-select" required>
                                            @foreach($issue_statuses as $issue_status)
                                                <option value="{{ $issue_status->id }}" @selected($issue_status->id == old('issue_status_id', $tracker->issue_status_id))>{{ $issue_status->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="description" class="col-md-4 col-form-label text-md-end">{{ __('Description') }}</label>

                                    <div class="col-md-8">
                                        <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $tracker->description) }}</textarea>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="fields-bits" class="col-md-4 col-form-label text-md-end">{{ __('Standard Fields') }}</label>
                                    <div class="col-md-8">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="fields_bits[]" value="1" id="fields-bits-001" @checked(in_array(1, old('fields_bits', [~$tracker->fields_bits & 1])))>
                                            <label for="fields-bits-001" class="form-check-label">{{ __('Assigned') }}</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="fields_bits[]" value="8" id="fields-bits-008" @checked(in_array(8, old('fields_bits', [~$tracker->fields_bits & 8])))>
                                            <label for="fields-bits-001" class="form-check-label">{{ __('Parent Ticket') }}</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="fields_bits[]" value="16" id="fields-bits-010" @checked(in_array(16, old('fields_bits', [~$tracker->fields_bits & 16])))>
                                            <label for="fields-bits-010" class="form-check-label">{{ __('Start Date') }}</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="fields_bits[]" value="32" id="fields-bits-020" @checked(in_array(32, old('fields_bits', [~$tracker->fields_bits & 32])))>
                                            <label for="fields-bits-020" class="form-check-label">{{ __('Due Date') }}</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="fields_bits[]" value="256" id="fields-bits-100" @checked(in_array(256, old('fields_bits', [~$tracker->fields_bits & 256])))>
                                            <label for="fields-bits-100" class="form-check-label">{{ __('Description') }}</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Register') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 overflow-auto" style="height: 360px;">
                                <div class="row">
                                    <label for="projects" class="col-md-4 col-lg-2 col-form-label text-md-end">{{ __('Project') }}</label>
                                    <div class="col-md-8 col-lg-10">
                                        <ul class="projects root">
                                            @foreach($projects as $project)
                                                @include('trackers.edit-projects', ['project' => $project, 'projects_old' => $projects_old])
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
