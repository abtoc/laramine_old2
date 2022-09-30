<div>
    <table class="table w-100">
        <thead>
            <th class="text-center">{{ __('User') }}</th>
            <th class="text-end">
                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#group-users-add-modal" class="bi bi-plus-circle link-dark text-decoration-none">
                    {{ __('New User') }}
                </a>
            </th>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr @class(['lock' => !$user->isActive()])>
                    <td class="text-start">
                        <a href="{{ route('users.show', ['user' => $user]) }}">{{ $user->name }}</a>
                    </td>
                    <td class="text-end">
                        <a href="#" class="bi bi-trash" wire:click.prevent="destroy({{ $user->id }})">{{ __('Delete') }}</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
    @livewire('group-users-add', ['group' => $group])
</div>
