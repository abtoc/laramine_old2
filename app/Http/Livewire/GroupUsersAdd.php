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

    protected $listeners = [
        'hiddenModal' => 'hidden',
        'refresh' => '$refresh'
    ];

    public function regist()
    {
        $hidden = false;
        foreach($this->checks as $key => $value){
            if($value){
                $hidden = true;
                $this->group->users()->attach($key);
            }
        }
        if($hidden) $this->emit('hideModal');
    }

    public function hidden()
    {
        $this->checks = [];

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
