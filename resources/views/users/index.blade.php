@extends('layouts.admin')

@section('content-admin')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('User') }}</div>
                <div class="card-body">
                    <div class="row mb-3">
                        <form action="{{ route('users.index') }}" method="GET">
                            <div class="row g-1">
                                <label for="status" class="col-auto col-form-label text-md-end">{{ __('Status') }}:</label>
                                <div class="col-auto">
                                    <select name="status" id="status" class="form-select">
                                        @foreach(App\Enums\UserStatus::cases() as $status)
                                            <option value="{{ $status->value }}" @if(request()->query('status', 1) == $status->value) selected @endif>{{ $status->string() }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="name" class="col-auto col-form-label text-md-end">{{ __('Name') }}:</label>
                                <div class="col-auto">
                                    <input type="text" id="name" name="name" class="form-control">
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-primary" type="submit">{{ __('Apply')}}</button>
                                </div>
                            </div>
                        </form>                        
                    </div>
                    <div class="row mb-3">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">@sortablelink('login', __('Login ID'))</th>
                                    <th class="text-center">@sortablelink('name',  __('Name'))</th>
                                    <th class="text-center">{{ __('Email') }}</th>
                                    <th class="text-center">{{ __('Admin') }}</th>
                                    <th class="text-center">@sortablelink('created_at', __('CreatedAt'))</th>
                                    <th class="text-center">@sortablelink('last_login_at', __('LastLoginAt'))</th>
                                    <th class="text-end">
                                        <a class="bi bi-plus-circle link-dark text-decoration-none" href=""> {{ __('Create User')}}</a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td class="text-start">
                                            <a href="#">
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
                                        <td class="text-center">{{ $user->created_at->toDateTimeString('minute') }}</td>
                                        <td class="text-center">{{ $user->last_login_at ? $user->last_login_at->toDateTimeString('minute') : '' }}</td>
                                        <td class="text-end">
                                            @if(Auth::id() !== $user->id)
                                                @if($user->isActive())
                                                    <a href="#" class="link-dark bi bi-lock text-decoration-none"
                                                        onclick="event.preventDefault();
                                                        document.getElementById('users-lock-{{$user->id}}').submit();">
                                                        {{ __('Lock') }}
                                                        </a>
                                                    <form method="POST" class="d-none" action="#" id="users-lock-{{$user->id}}">
                                                        @csrf
                                                    </form>
                                                @else
                                                    <a href="#" class="link-dark bi bi-unlock text-decoration-none"
                                                        onclick="event.preventDefault();
                                                        document.getElementById('users-unlock-{{$user->id}}').submit();">
                                                    {{ __('Unlock') }}
                                                    </a>
                                                    <form method="POST" class="d-none" action="#" id="users-unlock-{{$user->id}}">
                                                        @csrf
                                                    </form>
                                                @endif
                                                <a href="#" class="link-dark bi bi-trash text-decoration-none"
                                                    onclick="event.preventDefault();
                                                    document.getElementById('users-destroy-{{$user->id}}').submit();">
                                                    {{ __('Delete') }}
                                                    </a>
                                                <form method="POST" class="d-none" action="#" id="users-destroy-{{$user->id}}">
                                                    @csrf
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $users->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
