<div>
    @if($isEdit)
        @foreach($all_roles as $role)
            @if(array_key_exists($role->id, $inherits))
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="checks-{{ $project_id }}-{{ $user_id }}" checked disabled>
                    <label for="checks-{{ $project_id }}-{{ $user_id }}" class="form-check-label">{{ $role->name }}<em>:{{ __('Inherited from parent project') }}</em></label>
                </div>
            @elseif(array_key_exists($role->id, $groups))
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="checks-{{ $project_id }}-{{ $user_id }}" checked disabled>
                    <label for="checks-{{ $project_id }}-{{ $user_id }}" class="form-check-label">{{ $role->name }}<em>:{{ __('Inherited from group') }}</em>
                    </label>
                </div>
            @else
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="checks-{{ $project_id }}-{{ $user_id }}" value="1" wire:model="checks.{{ $role->id }}">
                    <label for="checks-{{ $project_id }}-{{ $user_id }}" class="form-check-label">{{ $role->name }}</label>
                </div>
            @endif
        @endforeach
        <div class="btn-group">
            <button class="btn btn-primary" wire:click="save">{{ __('Save') }}</button>
            <button class="btn btn-secondary" wire:click="cancel">{{ __('Cancel') }}</button>
        </div>
    @else
        {{ $all_roles->filter(fn($value, $key) => 
                (array_key_exists($value->id, $checks) and ($checks[$value->id] == 1)) or
                (array_key_exists($value->id, $inherits)) or
                (array_key_exists($value->id, $groups))
            )->implode('name', ',') }}
    @endif
</div>
