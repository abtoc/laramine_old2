@extends('layouts.admin')

@section('content-admin')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Workflow') }}</div>

                <div class="card-body">
                    <x-alert/>
                    <div class="row mb-3">
                        <form action="{{ route_query('workflows.edit') }}" id="choice-tracker" method="GET">
                            <div class="row g-1">
                                <label for="tracker-id" class="col-auto col-form-label text-md-end">{{ __('Tracker') }}</label>
                                <div class="col-auto">
                                    <select id="tracker-id" name="tracker_id" class="form-select">
                                        @foreach($trackers as $tracker)
                                            <option value="{{ $tracker->id }}" @selected(request()->query('tracker_id') == $tracker->id)>{{ $tracker->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-primary" type="submit">{{ __('Apply') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    @if(isset($workflows))
                        <div class="row mb-3">
                            <form action="{{ route_query('workflows.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="table-responsive">
                                    <table class="table table-hover table-sm text-nowrap">
                                        <thead>
                                            <tr>
                                                <th class="texst-start">{{ __('Current Status') }}</th>
                                                <th class="text-center" colspan="{{ $issue_statuses->count() }}">{{ __('Transitional status') }}</th>
                                            </tr>
                                            <tr>
                                            <td style="width: 30%;"></td>
                                            @foreach($issue_statuses as $status_new)
                                                    <td class="text-center" style="width: {{ (int)(70 / $issue_statuses->count()) }}%">{{ $status_new->name }}</td>
                                            @endforeach 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($issue_statuses as $status_old)
                                                <tr>
                                                    <td class="text-start">{{ $status_old->name }}</td>
                                                    @foreach($issue_statuses as $status_new)
                                                        <td class="text-center">
                                                            @if($status_old->id === $status_new->id)
                                                                <input type="checkbox" class="form-checkbox-input" checked disabled>
                                                            @else
                                                                <input type="checkbox" class="form-checkbox-input" name="workflows[{{ $status_old->id }}][{{ $status_new->id }}]" value="1"
                                                                    @checked(array_key_exists($status_old->id, $workflows) and (array_key_exists($status_new->id, $workflows[$status_old->id])))>
                                                                @endif
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row mb-0">
                                    <div class="col-md-6 offset-md-2">
                                        <button type="submit" class="btn btn-primary">{{ __('Register') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection