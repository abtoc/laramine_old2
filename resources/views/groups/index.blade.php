@extends('layouts.admin')

@section('content-admin')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Group') }}</div>
                <div class="card-body">
                    @include('components.alert')
                    <div class="row mb-3">
                        <form action="{{ route('groups.index') }}" method="GET">
                            <div class="row g-1">
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
                                        <th class="text-center">{{ __('Group') }}</th>
                                        <th class="text-center">{{ __('User') }}</th>
                                        <th class="text-end">
                                            <a class="bi bi-plus-circle link-dark text-decoration-none" href="{{ route_query('groups.create') }}"> {{ __('New Group')}}</a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($groups as $group)
                                        <tr>
                                            <td class="text-start">
                                                <a href="{{ route_query('groups.edit', ['group' => $group]) }}">
                                                    {{ $group->name }}
                                                </a>
                                            </td>
                                            <td class="text-center">{{ $group->users->count() }}</td>
                                            <td class="text-end">
                                                @if($group->isDelete())
                                                    <a href="{{ route_query('groups.destroy', ['group' => $group]) }}" class="link-dark bi bi-trash text-decoration-none"
                                                        onclick="event.preventDefault();
                                                        document.getElementById('groups-destroy-{{$group->id}}').submit();">
                                                        {{ __('Delete') }}
                                                        </a>
                                                    <form method="POST" class="d-none" action="{{ route_query('groups.destroy', ['group' => $group])}}" id="groups-destroy-{{$group->id}}">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                @endunless
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3">{{ __('No data to display.') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $groups->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
