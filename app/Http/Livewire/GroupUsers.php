<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\DB;
use Livewire\Component;
use Livewire\WithPagination;

class GroupUsers extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['refreshComponent' => '$refresh'];
    
    public $group;

    public function render()
    {
        $users = $this->group->users()->orderBy('name', 'asc')->paginate(10);

        return view('livewire.group-users', compact('users'));
    }

    public function destroy($id)
    {
        $this->group->users()->detach($id);
        $this->emit('refreshComponent');
    }
}
