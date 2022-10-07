@extends('layouts.admin')

@section('content-admin')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <nav>
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route_query('users.index') }}">{{ __('User') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('New User') }}</li>
                        </ol>
                    </nav>
                </div>

                <div class="card-body">
                    @include('components.alert')
                    <form method="POST" action="{{ route_query('users.store') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}<small class="required">*</small></label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @invalid('name')" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                <x-invalid-feedback name="name"/>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="login" class="col-md-4 col-form-label text-md-end">{{ __('Login ID') }}<small class="required">*</small></label>

                            <div class="col-md-6">
                                <input id="login" type="login" class="form-control @invalid('login')" name="login" value="{{ old('login') }}" required autocomplete="on">
                                <x-invalid-feedback name="login"/>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}<small class="required">*</small></label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @invalid('email')" name="email" value="{{ old('email') }}" required autocomplete="email">
                                <x-invalid-feedback name="email"/>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}<small class="required">*</small></label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @invalid('password')" name="password" required autocomplete="new-password">
                                <x-invalid-feedback name="password"/>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}<small class="required">*</small></label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <input type="checkbox" class="form-check-input @invalid('admin')" id="admin" name="admin"  value="1" @checked(old('admin'))>
                                <label for="admin" class="form-check-label">{{ __('Administrator') }}</label>
                                <x-invalid-feedback name="admin"/>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <input type="checkbox" class="form-check-input @invalid('admin_users')" id="admin-users" name="admin_users" value="1" @checked(old('admin_users'))>
                                <label for="admin-users" class="form-check-label">{{ __('User Admin') }}</label>
                                <x-invalid-feedback name="admin_users"/>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <input type="checkbox" class="form-check-input @invalid('admin_projects')" id="admin-projects" name="admin_projects" value="1" @checked(old('admin_projects'))>
                                <label for="admin-projects" class="form-check-label">{{ __('Project Admin') }}</label>
                                <x-invalid-feedback name="admin_projects"/>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <input type="checkbox" class="form-check-input @invalid('must_change_password')" id="must-change-password" name="must_change_password" value="1" @checked(old('must_change_password', 1))>
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
