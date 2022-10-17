@extends('layouts.admin')

@section('content-admin')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <nav>
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('enumerations.index') }}">
                                    @switch($enumeration->type->value)
                                        @case('IssuePriority')
                                            {{ __('Ticket Priority') }}
                                            @break
                                        @default
                                            {{ __('Ticket Priority') }}
                                    @endswitch
                                </a>
                            </li>
                            <li class="breadcrumb-item active">{{ $enumeration->name }}</li>
                        </ol>
                    </nav>
                </div>

                <div class="card-body">
                    @include('components.alert')
                    <form method="POST" action="{{ route('enumerations.update', ['enumeration' => $enumeration]) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}<small class="required">*</small></label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @invalid('name')" name="name" value="{{ old('name', $enumeration->name) }}" required autocomplete="name" autofocus>
                                <x-invalid-feedback name="name"/>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <input type="checkbox" class="form-check-input @invalid('active')" id="active" name="active" value="1" @checked(old('active', $enumeration->active))>
                                <label for="active" class="form-check-label">{{ __('Active') }}</label>
                                <x-invalid-feedback name="active"/>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <input type="checkbox" class="form-check-input @invalid('is_default')" id="is_default" name="is_default" value="1" @checked(old('is_default', $enumeration->is_default))>
                                <label for="is_default" class="form-check-label">{{ __('Default') }}</label>
                                <x-invalid-feedback name="is_default"/>
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
