<div>
    @if($isEdit)
        @foreach($all_roles as $role)
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="checks-{{ $project_id }}-{{ $user_id }}" value="1" wire:model="checks.{{ $role->id }}">
                <label for="checks-{{ $project_id }}-{{ $user_id }}" class="form-check-label">{{ $role->name }}</label>
            </div>
        @endforeach
        <div class="btn-group">
            <button class="btn btn-primary" wire:click="save">{{ __('Save') }}</button>
            <button class="btn btn-secondary" wire:click="cancel">{{ __('Cancel') }}</button>
        </div>
        {{ var_dump($checks) }}
    @else
        @foreach($roles as $role)
            {{ $role->name }}@unless($loop->last),@endunless
        @endforeach
    @endif
</div>
