<div>
    <x-alert/>
    <div class="table-responsive">
        <table class="table table-sm table-hover text-nowrap w-100">
            <thead>
                <th class="text-center">{{ __('Project') }}</th>
                <th class="text-center">{{ __('Role') }}</th>
                <th class="text-end">
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-modal-for="#group-projects-add-modal" class="link-dark text-decoration-none">
                        <i class="bi bi-plus-circle"></i>
                        {{ __('New Project') }}
                    </a>
                </th>
            </thead>
            <tbody>
                @forelse($projects as $project)
                    <tr @class(['text-start', 'lock' => $project->status !== 1])>
                        <td class="text-start">
                            <a href="{{ route('projects.show', ['project' => $project->id]) }}">{{ $project->name }}</a>
                        </td>
                        <td class="text-start">
                            @livewire('role-choice', ['project_id'=>$project->id, 'user_id'=>$group->id, 'roles' => $project->roles], key($project->id))
                        </td>
                        <td class="text-end">
                            <a href="#" class="link-dark text-decoration-none" wire:click.prevent="$emit('edit', {{ $project->id }},{{ $group->id }})"><i class="bi bi-pencil"></i> {{ __('Edit') }}</a>
                            @if($project->is_delete)
                                <a href="#" class="link-dark text-decoration-none" wire:click.prevent="destroy({{ $project->id }})"><i class="bi bi-trash"></i> {{ __('Delete') }}</a>
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
    @livewire('group-projects-add', ['group' => $group])
</div>
