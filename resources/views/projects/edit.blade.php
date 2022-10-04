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
                    @include('components.alert')
                    <form method="POST" action="{{ route('projects.update', ['project' => $project]) }}">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <label for="name" class="col-md-2 col-form-label text-md-end">{{ __('Name') }}<small class="required">*</small></label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $project->name) }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="description" class="col-md-2 col-form-label text-md-end">{{ __('Description') }}</label>
                            <div class="col-md-10">
                                <textarea id="markdown-edit" name="description" id="description" rows="8" class="form-control @error('description') is-invalid @enderror">{{ old('description', $project->description) }}</textarea>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        @php
                            $parents = App\Models\Project::whereStatus(App\Enums\ProjectStatus::ACTIVE)->withDepth()->get()->toFlatTree();   
                        @endphp

                        <div class="row mb-3">
                            <label for="parent-id" class="col-md-2 col-form-label text-md-end">{{ __('ParentProjectID') }}</label>

                            <div class="col-md-6">
                                <select name="parent_id" id="parent-id" class="form-select @error('parent_id') is_invalid @enderror">
                                    <option value="" @selected(is_null(old('parent_id', $project->parent_id)))></option>
                                    @foreach($parents as $parent)
                                        <option value="{{ $parent->id }}" @selected(old('parent_id', $project->parent_id) == $parent->id)>{!! str_repeat('&nbsp;&nbsp;', $parent->depth).$parent->name !!}</option>
                                    @endforeach
                                </select>

                                @error('parent_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-2">
                                <input type="checkbox" class="form-check-input @error('is_public') is-invalid @enderror" id="is-public" name="is_public"  value="1" @checked(old('is_public', $project->is_public))>
                                <label for="is-public" class="form-check-label">{{ __('Public') }}</label>
                                @error('is_public')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-2">
                                <input type="checkbox" class="form-check-input @error('inherit_members') is-invalid @enderror" id="inherit-members" name="inherit_members"  value="1" @checked(old('is_public', $project->inherit_members))>
                                <label for="inherit-members" class="form-check-label">{{ __('Inherit members') }}</label>
                                @error('inherit_members')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-2">
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

@push('scripts')
<script>
    new EasyMDE({element: document.getElementById('markdown-edit')});
</script>
@endpush

@endsection