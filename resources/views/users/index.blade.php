@extends('layouts.admin')

@section('content-admin')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">{{ __('User') }}</div>
                <div class="card-body">
                    @include('components.alert')
                    <div class="row mb-3">
                        <form id="search-user" action="{{ route('users.index') }}" method="GET">
                            <div class="row g-1">
                                <label for="status" class="col-auto col-form-label text-md-end">{{ __('Status') }}:</label>
                                <div class="col-auto">
                                    <select name="status" id="status" class="form-select" onchange="document.getElementById('search-user').submit();">
                                        @foreach(App\Enums\UserStatus::cases() as $status)
                                            <option value="{{ $status->value }}" @selected(request()->query('status', 1) == $status->value)>{{ $status->string() }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="name" class="col-auto col-form-label text-md-end">{{ __('Name') }}:</label>
                                <div class="col-auto">
                                    <input type="text" id="name" name="name" class="form-control" value="{{ request()->query('name', '') }}">
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-primary" type="submit">{{ __('Apply')}}</button>
                                </div>
                            </div>
                        </form>                        
                    </div>
                    <div class="row mb-3">
                        <div class="table-responsive">
                            <table class="table table-hover table-sm text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">@sortablelink('login', __('Login ID'))</th>
                                        <th class="text-center">@sortablelink('name',  __('Name'))</th>
                                        <th class="text-center">{{ __('Email') }}</th>
                                        <th class="text-center">{{ __('Admin') }}</th>
                                        <th class="text-center">{{ __('User Admin') }}</th>
                                        <th class="text-center">{{ __('Project Admin') }}</th>
                                        <th class="text-center">@sortablelink('created_at', __('CreatedAt'))</th>
                                        <th class="text-center">@sortablelink('last_login_at', __('LastLoginAt'))</th>
                                        <th class="text-end">
                                            <a class="link-dark text-decoration-none" href="{{ route_query('users.create') }}">
                                                <i class="bi bi-plus-circle"></i>
                                                {{ __('Create User')}}
                                            </a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $user)
                                        <tr @class(['lock' => !$user->isActive()])>
                                            <td class="text-start">
                                                <a href="{{ route_query('users.edit', ['user' => $user]) }}">
                                                    {{ $user->login }}
                                                </a>
                                            </td>
                                            <td class="text-start">{{ $user->name }}</td>
                                            <td class="text-start">
                                                <a href="mailto:{{$user->email}}">
                                                    {{ $user->email }}
                                                </a>
                                            </td>
                                            <td class="text-center">@if($user->admin)<i class="bi bi-check"></i> @endif</td>
                                            <td class="text-center">@if($user->admin_users)<i class="bi bi-check"></i> @endif</td>
                                            <td class="text-center">@if($user->admin_projects)<i class="bi bi-check"></i> @endif</td>
                                            <td class="text-center">{{ $user->created_at->toDateTimeString('minute') }}</td>
                                            <td class="text-center">@unless(is_null($user->last_login_at)){{ $user->last_login_at->toDateTimeString('minute') }}@endunless</td>
                                            <td class="text-end">
                                                @if(Auth::id() !== $user->id)
                                                    @if($user->isActive())
                                                        <a href="{{ route_query('users.lock', ['user' => $user]) }}" class="link-dark text-decoration-none" data-submit-for="#users-lock-{{$user->id}}">
                                                            <i class="bi bi-lock"></i>
                                                            {{ __('Lock') }}
                                                        </a>
                                                        <form method="POST" class="d-none" action="{{ route_query('users.lock', ['user' => $user]) }}" id="users-lock-{{$user->id}}">
                                                            @csrf
                                                            @method('PUT')
                                                        </form>
                                                    @else
                                                        <a href="{{ route_query('users.unlock', ['user' => $user]) }}" class="link-dark text-decoration-none" data-submit-for="#users-unlock-{{$user->id}}">
                                                            <i class="bi bi-unlock"></i>
                                                            {{ __('Unlock') }}
                                                        </a>
                                                        <form method="POST" class="d-none" action="{{ route_query('users.unlock', ['user' => $user]) }}" id="users-unlock-{{$user->id}}">
                                                            @csrf
                                                            @method('PUT')
                                                        </form>
                                                    @endif
                                                        <a href="{{ route_query('users.destroy', ['user' => $user]) }}" class="link-dark text-decoration-none"
                                                           data-confirm="{{ __('Can I delete it?') }}" data-confirm-for="#users-destroy-{{$user->id}}">
                                                            <i class="bi bi-trash"></i>
                                                           {{ __('Delete') }}
                                                        </a>
                                                    <form method="POST" class="d-none" action="{{ route_query('users.destroy', ['user' => $user])}}" id="users-destroy-{{$user->id}}">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10">
                                                <div class="alert alert-warning">{{ __('No data to display.') }}</div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $users->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
