<div id="query-content" class="mb-3">
    <form id="issue-query-form" action="{{ is_null($project) ? route('issues.index') : route('issues.index_project', ['project' => $project]) }}" method="GET">
        <input type="hidden" name="type" value="IssueQuery">
        <div class="accordion mb-2" id="issue-query">
            <div class="accordion-item">
                <h2 class="accordion-header" id="heding-filter">
                    <button type="button" class="accordion-button py-0" data-bs-toggle="collapse" data-bs-target="#collapse-filter" aria-expanded="true" aria-controls="collapse-filter">
                        {{ __('Filter') }}
                    </button>
                </h2>
                <div id="collapse-filter" class="accordion-collapse collapse show" aria-labelledby="heading-filter">
                    <div class="accordion-body py-1">
                        @livewire('issue-query-filter')
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="opetion">
                    <button type="button" class="accordion-button collapsed py-0" data-bs-toggle="collapse" data-bs-target="#collapse-option" aria-expanded="false" aria-controls="#collapse-option">
                        {{ __('Option') }}
                    </button>
                </h2>
                <div id="collapse-option" class="accordion-collapse collapse" aria-labelledby="heading-option">
                    <div class="accordion-body py-1">
                        @livewire('issue-query-option')
                    </div>
                </div>
            </div>
        </div>
        <div class="btn-group" role="group">
            <button class="btn btn-outline-primary btn-sm" type="submit">{{ __('Apply') }}</button>
            <a class="btn btn-outline-primary btn-sm" href="{{ strtok(url()->current(), '?')}}">{{ __('Clear') }}</a>
            <a class="btn btn-outline-primary btn-sm">{{ __('Save') }}</a>
        </div>
    </form>
</div>
