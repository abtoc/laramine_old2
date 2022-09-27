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
    
    public $group;

    public function render()
    {
        $users = User::query()
                    ->join('groups_users', 'id', '=', 'groups_users.user_id')
                    ->where('groups_users.group_id', '=', $this->group->id)
                    ->paginate(10);

        return view('livewire.group-users', compact('users'));
    }

    public function destroy($id)
    {
        $this->group->users()->detach($id);
    }
}
