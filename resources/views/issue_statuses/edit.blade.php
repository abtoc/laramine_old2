@extends('layouts.admin')

@section('content-admin')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <nav>
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{ route_query('issue_statuses.index') }}">{{ __('Issue Status') }}</a></li>
                                    <li class="breadcrumb-item active">{{ $issue_status->name }}</li>
                                </ol>
                            </nav>
                        </div>
                        <div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @include('components.alert')
                    <form method="POST" action="{{ route_query('issue_statuses.update', ['issue_status' => $issue_status]) }}">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}<small class="required">*</small></label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @invalid('name')" name="name" value="{{ old('name', $issue_status->name) }}" required autocomplete="name" autofocus>
                                <x-invalid-feedback name="name"/>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <input type="checkbox" class="form-check-input @invalid('is_closed')" id="is-closed" name="is_closed" value="1" @checked(old('is_closed', $issue_status->is_closed))>
                                <label for="is-closed" class="form-check-label">{{ __('Ended Issue') }}</label>
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
