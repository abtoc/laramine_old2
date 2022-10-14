<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class GroupUsers extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['refresh' => '$refresh'];
    
    public $group;

    public function render()
    {
        $users = $this->group->users()->orderBy('name', 'asc')->paginate(config('laramine.per_page'));

        return view('livewire.group-users', compact('users'));
    }

    public function destroy($id)
    {
        $this->group->users()->detach($id);
        $this->emit('refresh');
    }
}
