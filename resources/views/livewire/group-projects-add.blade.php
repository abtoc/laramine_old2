<div wire:ignore.self id="group-projects-add-modal" class="modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <div class="modal-title">
                {{ __('New Projects') }}
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <x-alert/>
            <div class="mb-3">
                <input type="text" class="form-control" wire:model="search">
            </div>
            <div class="overflow-auto" style="height: 400px;">
                <div class="principals">
                    @foreach($projects as $project)
                        <div class="form-check">
                            <input type="checkbox" id="checks-{{ $project->id }}" class="form-check-input" value="1" wire:model="check_projects.{{ $project->id }}">
                            <label for="checks-{{ $project->id }}" class="form-check-label">{{ $project->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
            <hr>
            <div class="roles-selection">
                @foreach($roles as $role)
                    <div class="form-check">
                        <input type="checkbox" id="roles-{{ $role->id }}" class="form-check-input" value="1" wire:model="check_roles.{{ $role->id }}">
                        <label for="roles-{{ $role->id }}" class="form-check-label">{{ $role->name }}</label>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
            <button type="button" class="btn btn-primary" wire:click="regist">{{ __('Register') }}</button>
        </div>
    </div>
</div>
</div>
