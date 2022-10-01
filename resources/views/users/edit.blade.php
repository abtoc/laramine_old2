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
                                    <li class="breadcrumb-item"><a href="{{ route('users.index', request()->query()) }}">{{ __('User') }}</a></li>
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
                    @php
                        $query = array_merge(['user'=>$user], request()->query());
                    @endphp
                    <form method="POST" action="{{ route('users.update', $query) }}">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}<small class="required">*</small></label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="login" class="col-md-4 col-form-label text-md-end">{{ __('Login ID') }}<small class="required">*</small></label>

                            <div class="col-md-6">
                                <input id="login" type="login" class="form-control @error('login') is-invalid @enderror" name="login" value="{{ old('login', $user->login) }}" required autocomplete="on">

                                @error('login')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}<small class="required">*</small></label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <input type="checkbox" class="form-check-input @error('admin') is-invalid @enderror" id="admin" name="admin"  value="1" @checked(old('admin', $user->admin))>
                                <label for="admin" class="form-check-label">{{ __('Administrator') }}</label>
                                @error('admin')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <input type="checkbox" class="form-check-input @error('admin_users') is-invalid @enderror" id="admin-users" name="admin_users"  value="1" @checked(old('admin_users', $user->admin_users))>
                                <label for="admin-users" class="form-check-label">{{ __('User Admin') }}</label>
                                @error('admin_users')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <input type="checkbox" class="form-check-input @error('admin_projects') is-invalid @enderror" id="admin-projects" name="admin_projects"  value="1" @checked(old('admin_projects', $user->admin_projects))>
                                <label for="admin-projects" class="form-check-label">{{ __('Project Admin') }}</label>
                                @error('admin_projects')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <input type="checkbox" class="form-check-input @error('must_change_password') is-invalud @enderror" id="must-change-password" name="must_change_password" value="1" @checked(old('must_change_password', $user->must_change_password))>
                                <label for="must-change-password" class="form-check-label">{{ __('Forces password change at next login') }}</label>
                                @error('must_change_password')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
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
