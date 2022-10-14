<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class ProjectUsers extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['refreshComponent' => '$refresh'];
    
    public $project;

    public function render()
    {
        $users = $this->project
                    ->users()
                    ->withoutGlobalScope('user')
                    ->orderBy('name', 'asc')
                    ->paginate(config('laramine.per_page'));

        return view('livewire.project-users', compact('users'));
    }

    public function destroy($id)
    {
        $this->project->users()->detach($id);
        $this->emit('refreshComponent');
    }
}
