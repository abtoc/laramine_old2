@extends('layouts.admin')

@section('content-admin')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <nav>
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route_query('roles.index') }}">{{ __('Role') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('New Role') }}</li>
                        </ol>
                    </nav>
                </div>

                <div class="card-body">
                    <x-alert/>
                    <form method="POST" action="{{ route_query('roles.store') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-3 col-lg-2 col-form-label text-md-end">{{ __('Name') }}<small class="required">*</small></label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @invalid('name')" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                <x-invalid-feedback name="name"/>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="permission-project" class="col-md-3 col-lg-2 col-form-label text-md-end">{{ __('Project') }}</label>

                            <div id="permission-project" class="col-md-9 col-lg-10 d-flex flex-row flex-wrap">
                                @foreach($permissions_project as $permission)
                                    <div class="form-check floating">
                                        <input type="checkbox" class="form-check-input" name="permissions[]" value="{{ $permission->value }}" id="permissions-{{ $permission->value }}">
                                        <label class="form-check-label" for="permissions-{{ $permission->value }}">{{ $permission->string() }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="permission-issue" class="col-md-3 col-lg-2 col-form-label text-md-end">{{ __('Issue Tracking') }}</label>

                            <div id="permission-issue" class="col-md-9 col-lg-10 d-flex flex-row flex-wrap">
                                @foreach($permissions_issue as $permission)
                                    <div class="form-check floating">
                                        <input type="checkbox" class="form-check-input" name="permissions[]" value="{{ $permission->value }}" id="permissions-{{ $permission->value }}">
                                        <label class="form-check-label" for="permissions-{{ $permission->value }}">{{ $permission->string() }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-3 offset-lg-2">
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
