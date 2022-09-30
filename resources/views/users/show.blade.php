@extends('layouts.app')

@section('content')
<div class="content px-4 py-4">
    @include('components.alert')
    <h2>{{ $user->name }}</h2>
    <ul>
        <li>{{ __('Login ID') }}:{{ $user->login }}</li>
    </ul>
</div>

@endsection
