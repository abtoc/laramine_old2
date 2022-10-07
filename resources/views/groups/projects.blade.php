@extends('layouts.admin')

@section('content-admin')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <nav>
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route_query('groups.index') }}">{{ __('Group') }}</a></li>
                            <li class="breadcrumb-item active">{{ $group->name }}</li>
                        </ol>
                    </nav>
                </div>

                <div class="card-body">
                    <x-alert/>
                    <x-group-edit-tab :group="$group"/>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
