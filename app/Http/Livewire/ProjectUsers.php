<?php

namespace App\Http\Livewire;

use App\UseCases\ProjectUsers\RenderAction;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectUsers extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['refresh' => '$refresh'];
    
    public $project;

    public function render(RenderAction $action)
    {
        list($users) = $action($this->project);
        return view('livewire.project-users', compact('users'));
    }

    public function destroy($id)
    {
        $this->project->users()->detach($id);
        $this->emit('refresh');
    }
}
