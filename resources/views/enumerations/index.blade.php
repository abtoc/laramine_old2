@extends('layouts.admin')

@section('content-admin')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Ticket Priority') }}</div>
                <div class="card-body">
                    <x-alert/>
                    <div class="row mb-3">
                        <div class="table-responsive">
                            <table class="table table-hover table-sm text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">{{ __('Name') }}</th>
                                        <th class="text-center">{{ __('Default') }}</th>
                                        <th class="text-center">{{ __('Active') }}</th>
                                        <th class="text-end">
                                            <a class="bi bi-plus-circle link-dark text-decoration-none" href="{{ route('enumerations.create', ['type' => 'IssuePriority']) }}"> {{ __('New Value')}}</a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($issue_priorities as $issue_priority)
                                        <tr id="priority-{{ $issue_priority->id }}" class="dragged-item">
                                            <td class="text-start">
                                                <a href="{{ route('enumerations.edit', ['enumeration' => $issue_priority]) }}">{{ $issue_priority->name }}</a>
                                            </td>
                                            <td class="text-center">@if($issue_priority->is_default)<i class="bi bi-check"></i>@endif</td>
                                            <td class="text-center">@if($issue_priority->active)<i class="bi bi-check"></i>@endif</td>
                                            <td class="text-end">
                                                <span class="dragged-button" style="cursor: move;"><i class="bi bi-arrows-move"></i></span>
                                                <form action="{{ route('enumerations.move') }}" id="dragged-form" method="POST" class="d-none">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" id="from" name="from">
                                                    <input type="hidden" id="to" name="to" value="{{ $issue_priority->id }}">
                                                </form>
                                                <a href="{{ route('enumerations.destroy', ['enumeration' => $issue_priority]) }}" class="link-dark bi bi-trash text-decoration-none"
                                                    data-confirm="{{ __('Can I delete it?') }}" data-confirm-for="#roles-destroy-{{$issue_priority->id}}">
                                                    {{ __('Delete') }}
                                                </a>
                                                <form method="POST" class="d-none" action="{{ route('enumerations.destroy', ['enumeration' => $issue_priority])}}" id="roles-destroy-{{$issue_priority->id}}">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>

                                            </td>
                                        </tr>
                                    @endforeach
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