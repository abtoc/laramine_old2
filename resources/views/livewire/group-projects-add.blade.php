<div wire:ignore.self id="group-projects-add-modal" class="modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <div class="modal-title">
                {{ __('New Projects') }}
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" style="min-height: 520px">
            <x-alert/>
            <div class="mb-3">
                <input type="text" class="form-control" wire:model="search">
            </div>
            <div class="d-flex flex-column flex-wrap" style="height: 400px">
                @foreach($projects as $project)
                    <div class="form-check">
                        <input type="checkbox" id="checks-{{ $project->id }}" class="form-check-input" value="1" wire:model="check_projects.{{ $project->id }}">
                        <label for="checks-{{ $project->id }}" class="form-check-label">{{ $project->name }}</label>
                    </div>
                @endforeach
            </div>
            <hr>
            <div class="d-flex">
                @foreach($roles as $role)
                    <div class="form-check">
                        <input type="checkbox" id="roles-{{ $role->id }}" class="form-check-input" value="1" wire:model="check_roles.{{ $role->id }}">
                        <label for="roles-{{ $role->id }}" class="form-check-label">{{ $role->name }}</label>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="modal-footer">
            {{ $projects->links() }}
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal" wire:click="regist">{{ __('Register') }}</button>
        </div>
    </div>
</div>
</div>
