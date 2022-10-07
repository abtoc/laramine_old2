@extends('layouts.admin')

@section('content-admin')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <nav>
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{ route_query('users.index') }}">{{ __('User') }}</a></li>
                                    <li class="breadcrumb-item active">{{ $user->login }}</li>
                                </ol>
                            </nav>
                        </div>
                        <div>
                            <a href="{{ route('users.show', ['user' => $user]) }}" class="ms-2 text-reset text-decoration-none bi bi-person">
                                {{ __('Profile') }}
                            </a>
                            <a href="{{ route('users.destroy', ['user' => $user]) }}" class="ms-2 text-reset text-decoration-none bi bi-trash">
                                {{ __('Delete') }}
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @include('components.alert')
                    <form method="POST" action="{{ route_query('users.update', ['user' => $user]) }}">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}<small class="required">*</small></label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @invalid('name')" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus>
                                <x-invalid-feedback name="name"/>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="login" class="col-md-4 col-form-label text-md-end">{{ __('Login ID') }}<small class="required">*</small></label>

                            <div class="col-md-6">
                                <input id="login" type="login" class="form-control @invalid('login')" name="login" value="{{ old('login', $user->login) }}" required autocomplete="on">
                                <x-invalid-feedback name="login"/>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}<small class="required">*</small></label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @invalid('email')" name="email" value="{{ old('email', $user->email) }}" required autocomplete="email">
                                <x-invalid-feedback name="email"/>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <input type="checkbox" class="form-check-input @invalid('admin')" id="admin" name="admin"  value="1" @checked(old('admin', $user->admin))>
                                <label for="admin" class="form-check-label">{{ __('Administrator') }}</label>
                                <x-invalid-feedback name="admin"/>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <input type="checkbox" class="form-check-input @invalid('admin-users')" id="admin-users" name="admin_users"  value="1" @checked(old('admin_users', $user->admin_users))>
                                <label for="admin-users" class="form-check-label">{{ __('User Admin') }}</label>
                                <x-invalid-feedback name="admin-users"/>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <input type="checkbox" class="form-check-input @invalid('admin-projects')" id="admin-projects" name="admin_projects"  value="1" @checked(old('admin_projects', $user->admin_projects))>
                                <label for="admin-projects" class="form-check-label">{{ __('Project Admin') }}</label>
                                <x-invalid-feedback name="admin-projects"/>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <input type="checkbox" class="form-check-input @invalid('must_change_password')" id="must-change-password" name="must_change_password" value="1" @checked(old('must_change_password', $user->must_change_password))>
                                <label for="must-change-password" class="form-check-label">{{ __('Forces password change at next login') }}</label>
                                <x-invalid-feedback name="must_change_password"/>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
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
