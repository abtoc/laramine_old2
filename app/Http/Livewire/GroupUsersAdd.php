<?php

namespace App\Http\Livewire;

use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class GroupUsersAdd extends Component
{
    use WithPagination;

    public $group;
    public $search = "";
    public $checks = array();

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function regist()
    {
        foreach($this->checks as $key => $value){
            if($value){
                $this->group->users()->attach($key);
            }
        }
        $this->checks = array();
        $this->setPage(1, 'users-page');
        $this->emit('refreshComponent');
    }

    public function render()
    {
        $group = $this->group;
        $query = User::query()
            ->whereNotIn("id", function($query) use($group){
                $query->select("user_id")->from("groups_users")->where("group_id", $group->id);
            })
            ->whereType(UserType::USER)
            ->whereStatus(UserStatus::ACTIVE)
            ->orderBy('name', 'asc');
        if(!empty($this->search)){
            $query = $query->where("name", "like", "%".$this->search."%");
        }
        
        $users = $query->simplePaginate(39, ['*'], 'users-page');

        return view('livewire.group-users-add', compact('users'));
    }
}
