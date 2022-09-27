<div>
    <table class="table w-100">
        <thead>
            <th class="text-center">{{ __('User') }}</th>
            <th class="text-end"></th>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
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
</div>
