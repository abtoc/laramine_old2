<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class GroupUsersAdd extends Component
{
    use WithPagination;

    public $group;
    public $search = "";
    public $checks = [];

    protected $listeners = ['refresh' => '$refresh'];

    public function regist()
    {
        foreach($this->checks as $key => $value){
            if($value){
                $this->group->users()->attach($key);
            }
        }
        $this->checks = [];
        $this->setPage(1, 'users-page');
        $this->emit('refresh');
    }

    public function render()
    {
        $group = $this->group;
        $query = User::query()
            ->whereNotIn("id", function($query) use($group){
                $query->select("user_id")->from("groups_users")->where("group_id", $group->id);
            })
            ->active()
            ->orderBy('name', 'asc')
            ->when(!empty($this->search), function($q){
                return $q->where('name', 'like', '%'.$this->search.'%');
            });
        $users = $query->get();

        return view('livewire.group-users-add', compact('users'));
    }
}
