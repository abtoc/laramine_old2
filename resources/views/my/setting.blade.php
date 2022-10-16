@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            {{ __('Personalization') }}
                        </div>
                        <div>
                            <a href="{{ route('my.password.edit') }}" class="ms-2 text-reset text-decoration-none bi bi-key">
                                {{ __('Change Password') }}
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <x-alert/>
                    <form method="POST" action="{{ route_query('my.setting.update') }}">
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
