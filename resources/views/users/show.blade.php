@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-4">
    @include('components.alert')
    <div>
        @include('components.alert')
        <div class="d-flex">
            <div class="flex-grow-1">
                <h2 class="mb-3">{{ $user->name }}</h2>
            </div>
            <div class="div">
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header">{{ __('Information') }}</div>
            <div class="card-body">
                <ul>
                    <li>{{ __('Login ID') }} : {{ $user->login }}</li>
                    <li>{{ __('CreatedAt') }} : {{ $user->created_at->toDateString() }}</li>
                    @unless(is_null($user->last_login_at))
                        <li>{{ __('LastLoginAt') }} : {{ $user->last_login_at->toDateString() }}</li>
                    @endunless
                </ul>
            </div>
        </div>
        @if($user->groups()->count() > 0)
            <div class="card mb-3">
                <div class="card-header">{{ __('Group') }}</div>
                <div class="card-body">
                    <ul>
                        @foreach($user->groups as $group)
                            @can('admin')
                                <li><a href="{{ route('groups.edit', ['group' => $group]) }}">{{ $group->name }}</a></li>
                            @else
                                <li>{{ $group->name }}</li>
                            @endcan
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </div>
</div>

@endsection
