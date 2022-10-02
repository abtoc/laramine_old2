@extends('layouts.admin')

@section('content-admin')

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Project') }}</div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="table-responsive">
                            <table class="table table-hover table-sm table-responsive">
                                <thead>
                                    <tr>
                                        <th class="text-center" nowrap>{{ __('Project') }}</th>
                                        <th class="text-center" nowrap>{{ __('Public') }}</th>
                                        <th class="text-center" nowrap>{{ __('CreatedAt') }}</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($projects as $project)
                                        <tr @class(['lock' => !$project->isActive()]) nowrap>
                                            <td class="text-start">
                                                {!! str_repeat('&nbsp;&nbsp;&nbsp;', $project->depth) !!}@if($project->depth > 0) > @endif
                                                <a href="{{ route('projects.show', ['project' => $project]) }}">
                                                    {{ __($project->name) }}
                                                </a>
                                            </td>
                                            <td class="text-center" nowrap>@if($project->is_public)<i class="bi bi-check"></i> @endif</td>
                                            <td class="text-center" nowrap>{{ $project->created_at->toDateString() }}</td>
                                            <td></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">
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
