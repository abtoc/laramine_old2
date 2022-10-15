@extends('layouts.admin')

@section('content-admin')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Role') }}</div>
                <div class="card-body">
                    <x-alert/>
                    <div class="row mb-3">
                        <div class="table-responsive">
                            <table class="table table-hover table-sm text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">{{ __('Role') }}</th>
                                        <th class="text-end">
                                            <a class="bi bi-plus-circle link-dark text-decoration-none" href="{{ route('roles.create') }}"> {{ __('New Role')}}</a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($roles as $role)
                                        <tr id="{{ $role->id }}" @class(['dragged-item' => $role->isOther()])>
                                            <td class="text-start">
                                                <a href="{{ route('roles.edit', ['role' => $role]) }}">
                                                    {{ $role->name }}
                                                </a>
                                            </td>
                                            <td class="text-end">
                                                <span class="dragged-button" style="cursor: move;"><i class="bi bi-arrows-move"></i></span>
                                                <form action="{{ route('roles.move') }}" id="dragged-form" method="POST" class="d-none">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" id="from" name="from">
                                                    <input type="hidden" id="to" name="to" value="{{ $role->id }}">
                                                </form>
                                                <a href="{{ route('roles.destroy', ['role' => $role]) }}" class="link-dark bi bi-trash text-decoration-none"
                                                    data-confirm="{{ __('Can I delete it?') }}" data-confirm-for="#roles-destroy-{{$role->id}}">
                                                    {{ __('Delete') }}
                                                </a>
                                                <form method="POST" class="d-none" action="{{ route('roles.destroy', ['role' => $role])}}" id="roles-destroy-{{$role->id}}">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
