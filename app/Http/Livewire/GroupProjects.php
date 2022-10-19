<?php

namespace App\Http\Livewire;

use App\UseCases\GroupProjects\RenderAction;
use Livewire\Component;
use Livewire\WithPagination;

class GroupProjects extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['refresh' => '$refresh'];
    
    public $group;

    public function render(RenderAction $action)
    {
        list($projects) = $action($this->group);
        return view('livewire.group-projects', compact('projects'));
    }

    public function destroy($id)
    {
        $this->group->projects()->detach($id);
        $this->emit('refresh');
    }
}
