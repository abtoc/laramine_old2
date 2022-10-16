<?php

namespace App\Http\Livewire;

use App\Enums\ProjectStatus as Status;
use Livewire\Component;
use Livewire\WithPagination;

class GroupProjects extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['refresh' => '$refresh'];
    
    public $group;

    public function render()
    {
        $projects = $this->group
                    ->projects()
                    ->orderBy('name', 'asc')
                    ->paginate(config('laramine.per_page'));

        return view('livewire.group-projects', compact('projects'));
    }

    public function destroy($id)
    {
        $this->group->projects()->detach($id);
        $this->emit('refresh');
    }
}
