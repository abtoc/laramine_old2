@extends('layouts.admin')

@section('content-admin')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <nav>
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('groups.index', request()->query()) }}">{{ __('Group') }}</a></li>
                            <li class="breadcrumb-item active">{{ $group->name }}</li>
                        </ol>
                    </nav>
                </div>

                <div class="card-body">
                    @include('components.alert')
                    @php
                        $query = array_merge(['group'=>$group], request()->query());
                    @endphp
                    <ul class="nav nav-tabs mb-3">
                        <li class="nav-item">
                            <a href="{{ route('groups.edit', ['group' => $group])}}" class="nav-link active" aria-current="page"  href="#">{{ __('All') }}</a>
                        </li>
                        @if($group->isGroup(true))
                            <li class="nav-item">
                                <a href="{{ route('groups.users', ['group' => $group])}}" class="nav-link">{{ __('User') }}</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('groups.projects', ['group' => $group]) }}" class="nav-link">{{ __('Project') }}</a>
                        </li>
                    </ul>
                    <form method="POST" action="{{ route('groups.update', $query) }}">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" @unless($group->isGroup(true)) disabled @endunless name="name" value="{{ old('name', $group->name) }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
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
