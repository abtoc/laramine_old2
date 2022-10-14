<div>
    <x-alert/>
    <div class="table-responsive">
        <table class="table table-sm table-hover text-nowrap w-100">
            <thead>
                <th class="text-center">{{ __('User') }}/{{__('Group') }}</th>
                <th class="text-center">{{ __('Role') }}</th>
                <th class="text-end">
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#project-users-add-modal" class="bi bi-plus-circle link-dark text-decoration-none">
                        {{ __('New User') }}
                    </a>
                </th>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr class="text-start">
                        <td class="text-start">
                            @if($user->isUser())
                                <a href="{{ route('users.show', ['user' => $user]) }}">{{ $user->name }}</a>
                            @else
                                <i class="bi bi-people"></i>{{ $user->name }}                                
                            @endif
                        </td>
                        <td class="text-center">
                            @foreach($user->pivot->roles()->get() as $role)
                                <span>{{ $role->name }}@unless($loop->last),@endunless</span>
                            @endforeach
                        </td>
                        <td class="text-end">
                            <a href="#" class="link-dark text-decoration-none bi bi-trash" wire:click.prevent="destroy({{ $user->id }})">{{ __('Delete') }}</a>
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
    {{ $users->links() }}
    @livewire('project-users-add', ['project' => $project])
</div>
