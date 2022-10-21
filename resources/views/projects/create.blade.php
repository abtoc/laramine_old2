@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <nav>
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item active">{{ __('New Project') }}</li>
                        </ol>
                    </nav>
                </div>

                <div class="card-body">
                    <x-alert/>
                    <form method="POST" action="{{ route('projects.store') }}">
                        @csrf

                        <input type="hidden" name="_previous" value="{{ old('_previous',url()->previous()) }}">

                        <div class="row mb-3">
                            <label for="name" class="col-md-2 col-form-label text-md-end">{{ __('Name') }}<small class="required">*</small></label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @invalid('name')" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                <x-invalid-feedback name="name"/>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="description" class="col-md-2 col-form-label text-md-end">{{ __('Description') }}</label>
                            <div class="col-md-10">
                                <x-editor name="description">{{ old('description') }}</x-editor>
                                <x-invalid-feedback name="description"/>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="parent-id" class="col-md-2 col-form-label text-md-end">{{ __('ParentProjectID') }}</label>

                            <div class="col-md-6">
                                <select name="parent_id" id="parent-id" class="form-select @invalid('parent_id')">
                                    <option value="" @selected(is_null(old('parent_id', request()->query('parent_id', null))))></option>
                                    @foreach($parents as $parent)
                                        <option value="{{ $parent->id }}" @selected(old('parent_id', request()->query('parent_id', null)) == $parent->id)>{!! str_repeat('&nbsp;&nbsp;', $parent->depth).$parent->name !!}</option>
                                    @endforeach
                                </select>
                                <x-invalid-feedback name="parent_id"/>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-2">
                                <input type="checkbox" class="form-check-input @invalid('is_public')" id="is-public" name="is_public"  value="1" @checked(old('is_public'))>
                                <label for="is-public" class="form-check-label">{{ __('Public') }}</label>
                                <x-invalid-feedback name="is_public"/>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-2">
                                <input type="checkbox" class="form-check-input @invalid('inherit_members')" id="inherit-members" name="inherit_members"  value="1" @checked(old('is_public'))>
                                <label for="inherit-members" class="form-check-label">{{ __('Inherit members') }}</label>
                                <x-invalid-feedback name="inherit_members"/>
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

@endsection
