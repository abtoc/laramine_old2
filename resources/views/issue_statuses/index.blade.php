@extends('layouts.admin')

@section('content-admin')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Ticket Status')}}</div>
                <div class="card-body">
                    <x-alert/>
                    <div class="row mb-3">
                        <div class="table-responsive">
                            <table class="table table-hover table-sm text-nowrap">
                                <thead>
                                    <th class="text-center">{{ __('Status') }}</th>
                                    <th class="text-center">{{ __('Ended Tickets') }}</th>
                                    <th class="text-end">
                                        <a href="{{ route('issue_statuses.create') }}" class="link-dark text-decoration-none"><i class="bi bi-plus-circle"></i> {{ __('New Status') }}</a>
                                    </th>
                                </thead>
                                <tbody>
                                    @forelse($issue_statuses as $issue_status)
                                        <tr id="status-{{ $issue_status->id }}" class="dragged-item">
                                            <td class="text-start">
                                                <a href="{{ route('issue_statuses.edit', ['issue_status' => $issue_status]) }}">
                                                    {{ $issue_status->name }}
                                                </a>
                                            </td>
                                            <td class="text-center">@if($issue_status->is_closed)<i class="bi bi-check"></i>@endif</td>
                                            <td class="text-end">
                                                <span class="dragged-button" style="cursor: move"><i class="bi bi-arrows-move"></i></span>
                                                <form action="{{ route('issue_statuses.move') }}" id="dragged-form" class="d-none" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" id="from" name="from">
                                                    <input type="hidden" id="to" name="to" value="{{ $issue_status->id}}">
                                                </form>
                                                <a href="{{ route('issue_statuses.destroy', ['issue_status' => $issue_status]) }}" class="link-dark text-decoration-none"
                                                    data-confirm="{{ __('Can I delete it?') }}" data-confirm-for="#issue-status-destroy-{{ $issue_status->id }}">
                                                    <i class="bi bi-trash"></i>
                                                    {{ __('Delete') }}
                                                </a>
                                                <form method="POST" class="d-none" action="{{ route('issue_statuses.destroy', ['issue_status' => $issue_status])}}" id="issue-status-destroy-{{ $issue_status->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3">
                                                <div class="alert alert-warning">{{ __('No data to display.') }}</div>
                                            </td>
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
