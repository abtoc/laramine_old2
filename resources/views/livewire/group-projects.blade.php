<div>
    <x-alert/>
    <div class="table-responsive">
        <table class="table table-sm table-hover text-nowrap w-100">
            <thead>
                <th class="text-center">{{ __('Project') }}</th>
                <th class="text-center">{{ __('Role') }}</th>
                <th class="text-end">
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#group-projects-add-modal" class="bi bi-plus-circle link-dark text-decoration-none">
                        {{ __('New Project') }}
                    </a>
                </th>
            </thead>
            <tbody>
                @forelse($projects as $project)
                    <tr @class(['text-start', 'lock' => !$project->isActive()])>
                        <td class="text-start">
                            <a href="{{ route('projects.show', ['project' => $project]) }}">{{ $project->name }}</a>
                        </td>
                        <td class="text-start">
                            @livewire('role-choice', ['project_id'=>$project->id, 'user_id'=>$group->id], key($project->id))
                        </td>
                        <td class="text-end">
                            <a href="#" class="link-dark text-decoration-none bi bi-pencil" wire:click.prevent="$emit('edit', {{ $project->id }},{{ $group->id }})">{{ __('Edit') }}</a>
                            <a href="#" class="link-dark text-decoration-none bi bi-trash" wire:click.prevent="destroy({{ $project->id }})">{{ __('Delete') }}</a>
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
    {{ $projects->links() }}
    @livewire('group-projects-add', ['group' => $group])
</div>
