<div>
    <div class="table-responsive">
        <table class="table table-hover table-sm text-nowrap">
            <thead>
                <tr>
                    <th class="text-center">@sortablelink('id', '#')</th>
                    @foreach(request()->input('q') as $column)
                        @switch($column)
                            @case('project')
                                <th class="text-center">@sortablelink('project_id', __('project'))</th>
                                @break
                            @case('tracker')
                                <th class="text-center">@sortablelink('tracker_id', __('tracker'))</th>
                                @break
                            @case('status')
                                <th class="text-center">@sortablelink('status_id', __('status'))</th>
                                @break
                            @case('priority')
                                <th class="text-center">@sortablelink('priority_id', __('priority'))</th>
                                @break
                            @case('subject')
                                <th class="text-center">@sortablelink('subject', __('subject'))</th>
                                @break
                            @case('author')
                                <th class="text-center">@sortablelink('author_id', __('author'))</th>
                                @break
                            @case('assigned_to')
                                <th class="text-center">@sortablelink('assigned_tp', __('assigned_to'))</th>
                                @break
                            @case('is_private')
                                <th class="text-center">@sortablelink('is_private', __('is_private'))</th>
                                @break
                            @case('done_raito')
                                <th class="text-center">@sortablelink('done_raito', __('done_raito'))</th>
                                @break
                            @case('start_date')
                                <th class="text-center">@sortablelink('start_date', __('start_date'))</th>
                                @break
                            @case('due_date')
                                <th class="text-center">@sortablelink('due_date', __('due_date'))</th>
                                @break
                            @case('closed_at')
                                <th class="text-center">@sortablelink('created_at', __('closed_at'))</th>
                                @break
                            @case('created_at')
                                <th class="text-center">@sortablelink('created_at', __('created_at'))</th>
                                @break
                            @case('updated_at')
                                <th class="text-center">@sortablelink('updated_at', __('updated_at'))</th>
                                @break
                        @endswitch
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($issues as $issue)
                    <tr>
                        <td class="text-center">
                            <a href="{{ route('issues.show', ['project' => $issue->project, 'issue' => $issue]) }}")>
                                {{ $issue->id }}
                            </a>
                        </td>
                            @foreach(request()->input('q') as $column)
                            @switch($column)
                                @case('project')
                                    <td class="text-center">
                                        <a href="{{ route('projects.show', ['project' => $issue->project]) }}">
                                            {{ $issue->project->name }}
                                        </a>
                                    </td>
                                    @break
                                @case('tracker')
                                    <td class="text-center">{{ $issue->tracker->name }}</td>
                                    @break
                                @case('status')
                                    <td class="text-center">{{ $issue->status->name }}</td>
                                    @break
                                @case('priority')
                                    <td class="text-center">{{ $issue->priority->name }}</td>
                                    @break
                                @case('subject')
                                    <td class="text-start">
                                        <a href="{{ route('issues.show', ['project' => $issue->project, 'issue' => $issue]) }}")>
                                            {{ $issue->subject }}
                                        </a>
                                    </td>
                                    @break
                                @case('author')
                                    <td class="text-center">{{ $issue->author->name }}</td>
                                    @break
                                @case('assigned_to')
                                    <td class="text-center">@unless(is_null($issue->assigned_to)){{ $issue->assigned_to->name }}@endunless</td>
                                    @break
                                @case('is_private')
                                    <td class="text-center">@if($issue->is_private)<i class="bi bi-check"></i>@endif</td>
                                    @break
                                @case('done_raito')
                                    <td class="text-center">
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="{{ $issue->done_raito }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    @break
                                @case('start_date')
                                    <td class="text-center">@unless(is_null($issue->start_date)){{ $issue->start_date->toDateString() }}@endunless</td>
                                    @break
                                @case('due_date')
                                    <td class="text-center">@unless(is_null($issue->due_date)){{ $issue->due_date->toDateString() }}@endunless</td>
                                    @break
                                @case('closed_at')
                                    <td class="text-center">@unless(is_null($issue->closed_at)){{ $issue->closed_at->toDateTimeString('minute') }}@endunless</td>
                                    @break
                                @case('created_at')
                                    <td class="text-center">@unless(is_null($issue->created_at)){{ $issue->created_at->toDateTimeString('minute') }}@endunless</td>
                                    @break
                                @case('updated_at')
                                    <td class="text-center">@unless(is_null($issue->updated_at)){{ $issue->updated_at->toDateTimeString('minute') }}@endunless</td>
                                    @break
                            @endswitch
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>