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
        <div class="row-3">
            <div class="col-md-6">
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
                @if(count($projects) > 0)
                    <div class="card mb-3">
                        <div class="card-header">{{ __('Project') }}</div>
                        <div class="card-body">
                            <table class="table table-sm">
                                <thead>
                                    <th class="text-center">{{ __('Project') }}</th>
                                    <th class="text-center">{{ __('Role') }}</th>
                                    <th class="text-center">{{ __('CreatedAt') }}</th>
                                </thead>
                                <tbody>
                                    @foreach($projects as $project)
                                        <tr>
                                            <td class="text-start">
                                                <a href="{{ route('projects.show', ['project'=>$project]) }}">{{ $project->name }}</a>
                                            </td>
                                            <td class="text-start">{{ $project->getRoleNames($project->member_id) }}</td>
                                            <td class="text-center">{{ $project->created_at->toDateString() }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
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
            <div class="col-md-6">
            </div>            
        </div>
    </div>
</div>

@endsection
