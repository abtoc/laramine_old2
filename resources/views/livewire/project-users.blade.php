<div>
    <x-alert/>
    <div class="table-responsive">
        <table class="table table-sm table-hover text-nowrap w-100">
            <thead>
                <th class="text-center">{{ __('User') }}/{{__('Group') }}</th>
                <th class="text-center">{{ __('Role') }}</th>
                <th class="text-end">
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-modal-for="#project-users-add-modal" class="link-dark text-decoration-none">
                        <i class="bi bi-plus-circle"></i>
                        {{ __('New User') }}
                    </a>
                </th>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr class="text-start">
                        <td class="text-start">
                            @if($user->type === 'User')
                                <a href="{{ route('users.show', ['user' => $user->id]) }}">{{ $user->name }}</a>
                            @else
                                <i class="bi bi-people"></i>{{ $user->name }}                                
                            @endif
                        </td>
                        <td class="text-start">
                            @livewire('role-choice', ['project_id'=>$project->id, 'user_id'=>$user->id, 'roles' => $user->roles], key($user->id))
                        </td>
                        <td class="text-end">
                            <a href="#" class="link-dark text-decoration-none" wire:click.prevent="$emit('edit', {{ $project->id }},{{ $user->id }})"><i class="bi bi-pencil"></i> {{ __('Edit') }}</a>
                            @if($user->is_delete)
                                <a href="#" class="link-dark text-decoration-none" wire:click.prevent="destroy({{ $user->id }})"><i class="bi bi-trash"></i> {{ __('Delete') }}</a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">
                            <div class="alert alert-warning">{{ __('No data to display.') }}</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @livewire('project-users-add', ['project' => $project])
</div>
