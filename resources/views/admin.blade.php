@extends('layouts.admin')

@section('content-admin')
<div class="py-4 px-4">
    Admin
    <div>
        {{ request()->header('User-Agent') }}
    </div>
    @if(Agent::isMobile())
        <div>Mobile</div>
    @endif
    @if(Agent::isDesktop())
        <div>Desktop</div>
    @endif
</div>
@endsection