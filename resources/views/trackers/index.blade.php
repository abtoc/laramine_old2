@extends('layouts.admin')

@section('content-admin')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">{{ __('Tracker') }}</div>
                <div class="card-body">
                    <x-alert/>
                    <div class="row mb-3">
                        <div class="table-responsive">
                            <table class="table table-hover table-sm text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">{{ __('Tracker') }}</th>
                                        <th class="text-center">{{ __('Default Status') }}</th>
                                        <th class="text-start">{{ __('Description') }}</th>
                                        <th class="text-end">
                                            <a class="link-dark text-decoration-none" href="{{ route('trackers.create') }}">
                                                <i class="bi bi-plus-circle"></i>
                                                {{ __('New Tracker')}}
                                            </a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($trackers as $tracker)
                                        <tr id="tracker-{{ $tracker->id }}" class="dragged-item">
                                            <td class="text-start">
                                                <a href="{{ route('trackers.edit', ['tracker' => $tracker]) }}">
                                                    {{ $tracker->name }}
                                                </a>
                                            </td>
                                            <td class="text-center">{{ $tracker->issue_status->name }}</td>
                                            <td class="text-start">{!! implode('<br>', explode("\n", $tracker->description)) !!}</td>
                                            <td class="text-end">
                                                <span class="dragged-button" style="cursor: move;"><i class="bi bi-arrows-move"></i></span>
                                                <form action="{{ route('trackers.move') }}" id="dragged-form" method="POST" class="d-none">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" id="from" name="from">
                                                    <input type="hidden" id="to" name="to" value="{{ $tracker->id }}">
                                                </form>
                                                <a href="{{ route('trackers.destroy', ['tracker' => $tracker]) }}" class="link-dark text-decoration-none"
                                                    data-confirm="{{ __('Can I delete it?') }}" data-confirm-for="#trackers-destroy-{{$tracker->id}}">
                                                    <i class="bi bi-trash"></i>
                                                    {{ __('Delete') }}
                                                </a>
                                                <form method="POST" class="d-none" action="{{ route('trackers.destroy', ['tracker' => $tracker])}}" id="trackers-destroy-{{$tracker->id}}">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">{{ __('No data to display.') }}</td>
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
