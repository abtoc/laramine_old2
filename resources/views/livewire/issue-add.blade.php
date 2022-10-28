<div>
    
    <input type="hidden" name="author_id" value="{{ Auth::id() }}">

    <div class="row mb-3">
        <label for="project-id" class="col-md-2 col-form-label text-md-end">{{ __('Project') }}<small class="required">*</small></label>
        <div class="col-md-6">
            <select name="project_id" id="project-id" class="form-select @invalid('project_id')" wire:model="project_id">
                @foreach($projects as $project)
                    <option value="{{ $project['id'] }}" @selected($project['id'] === $project_id)>{!!str_repeat('&nbsp;&nbsp;', $project['depth'])!!}{{ $project['name'] }}</option>
                @endforeach
            </select>     
            <x-invalid-feedback name="project_id"/>
        </div>
        <div class="col-md-2 form-check">
            <input type="checkbox" class="form-check-input @invalid('is_private')" id="is-private" value="1" @checked(old('is_private'))>
            <label for="is-private" class="form-check-label">{{ __('Private') }}</label>
            <x-invalid-feedback name="is_private"/>
        </div>
    </div>

    <div class="row mb-3">
        <label for="tracker-id" class="col-md-2 col-form-label text-md-end" @invalid('tracker_id')>{{ __('Tracker') }}<small class="required">*</small></label>
        <div class="col-md-6">
            <select name="tracker_id" id="tracker-id" class="form-select" wire:model="tracker_id">
                @foreach($trackers as $tracker)
                    <option value="{{ $tracker['id'] }}" @selected($tracker['id'] == $tracker_id)>{{ $tracker['name'] }}</option>
                @endforeach
            </select>
            <x-invalid-feedback name="tracker_id"/>
        </div>
    </div>

    <div class="row mb-3">
        <label for="subject" class="col-md-2 col-form-label text-md-end">{{ __('Subject') }}<small class="required">*</small></label>
        <div class="col-md-10">
            <input id="subject" type="text" class="form-control @invalid('subject')" name="subject" value="{{ $subject }}" required autocomplete="subject" autofocus>
            <x-invalid-feedback name="subject"/>
        </div>
    </div>

    @if(~$fields_bits & 256)
        <div class="row mb-3">
            <label for="description" class="col-md-2 col-form-label text-md-end">{{ __('Description') }}</label>
            <div class="col-md-10">
                <x-editor name="description">{{ $description }}</x-editor>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-6">

            <div class="row mb-3">
                <label for="status-id" class="col-md-2 col-lg-4 col-form-label text-md-end">{{ __('Status') }}<small class="required">*</small></label>
                <div class="col-md-6 col-lg-6">
                    <select name="status_id" id="status-id" class="form-select @invalid('status_id')">
                        @foreach($statuses as $status)
                            <option value="{{ $status['id'] }}" @selected($status_id == $status['id'])>{{ $status['name'] }}</option>
                        @endforeach
                    </select>
                    <x-invalid-feedback name="status_id"/>
                </div>
            </div>

            <div class="row mb-3">
                <label for="priority-id" class="col-md-2 col-lg-4 col-form-label text-md-end">{{ __('Priority') }}<small class="required">*</small></label>
                <div class="col-md-6 col-lg-6">
                    <select name="priority_id" id="priority-id" class="form-select @invalid('priority_id')">
                        @foreach($priorites as $priority)
                            <option value="{{ $priority['id'] }}" @selected($priority_id == $priority['id'])>{{ $priority['name'] }}</option>
                        @endforeach
                    </select>
                    <x-invalid-feedback name="priority_id"/>
                </div>
            </div>

            @if(~$fields_bits & 1)
                <div class="row mb-3">
                    <label for="assigned" class="col-md-2 col-lg-4 col-form-label text-md-end">{{ __('Assigned') }}</label>
                    <div class="col-md-6 col-lg-6">
                        <select name="assigned_to_id" id="assigned-to-id" class="form-select @invalid('assigned_to_id')">
                            <option value=""></option>
                            @foreach($assignments as $key => $value)
                                <option value="{{ $key }}" @selected($assigned_to_id == $key)>{{ $value }}</option>
                            @endforeach
                        </select>
                        <x-invalid-feedback name="assigned_to_id"/>
                    </div>
                </div>
            @endif

        </div>
        <div class="col-lg-6">

            @if(~$fields_bits & 8)
                <div class="row mb-3">
                    <label for="parent-id" class="col-md-2 col-lg-4 col-form-label text-md-end">{{ __('Parent Issue')}}</label>
                    <div class="col-md-5 col-lg-5">
                        <div class="input-group">
                            <input id="parent-id" type="text" name="parent_id" class="form-control @invalid('parent_id')" wire:model="parent_id">                  
                            <button class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></button>
                        </div>
                        <x-invalid-feedback name="parent_id"/>
                    </div>
                </div>
            @endif

            @if(~$fields_bits & 16)
                <div class="row mb-3">
                    <label for="start-date" class="col-md-2 col-lg-4 col-form-label text-md-end">{{ __('Start Date')}}</label>
                    <div class="col-md-5 col-lg-5">
                        <input id="start-date" type="date" name="start_date" class="form-control @invalid('start_date')" value="{{ $start_date }}">                    
                        <x-invalid-feedback name="start_date"/>
                    </div>
                </div>
            @endif

            @if(~$fields_bits & 32)
                <div class="row mb-3">
                    <label for="due-date" class="col-md-2 col-lg-4 col-form-label text-md-end">{{ __('Due Date')}}</label>
                    <div class="col-md-5 col-lg-5">
                        <input id="due-date" type="date" name="due_date" class="form-control @invalid('due_date')" value="{{ $due_date }}">                    
                        <x-invalid-feedback name="due_date"/>
                    </div>
                </div>
            @endif

            @if(~$fields_bits & 128)
                <div class="row mb-3">
                    <label for="done-raito" class="col-md-2 col-lg-4 col-form-label text-md-end">{{ __('Done Raito') }}</label>
                    <div class="col-md-5 col-lg-5">
                        <select name="done_raito" id="done-raito" class="form-select @invalid('done_raito')">
                            <option value="0" @selected($done_raito == 0)>0%</option>
                            <option value="10" @selected($done_raito == 10)>10%</option>
                            <option value="20" @selected($done_raito == 20)>20%</option>
                            <option value="30" @selected($done_raito == 30)>30%</option>
                            <option value="40" @selected($done_raito == 40)>40%</option>
                            <option value="50" @selected($done_raito == 50)>50%</option>
                            <option value="60" @selected($done_raito == 60)>60%</option>
                            <option value="70" @selected($done_raito == 70)>70%</option>
                            <option value="80" @selected($done_raito == 80)>80%</option>
                            <option value="90" @selected($done_raito == 90)>90%</option>
                            <option value="100" @selected($done_raito == 100)>100%</option>
                        </select>
                        <x-invalid-feedback name="done_raite"/>
                    </div>
                </div>
            @endif

        </div>

        <div class="row mb-3">
            <label for="watchers" class="col-md-2 col-lg-2 col-form-label text-md-end">{{ __('Watchers')}}</label>
            <div class="col-md-10 col-lg-10 watchers">
                @foreach($watchers as $key => $value)
                    <div class="form-check">
                        <input type="checkbox" id="watchers-{{ $key }}" class="form-check-input">
                        <label for="watchers-{{ $key }}">{{ $value }}</label>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="row mb-0">
            <div class="col-md-6 offset-md-2 offset-lg-2">
                <button type="submit" class="btn btn-primary">
                    {{ __('Register') }}
                </button>
            </div>
        </div>
    </div>
</div>
