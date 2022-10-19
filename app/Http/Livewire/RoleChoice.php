<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Member;
use App\Models\Role;
use App\UseCases\Role\AttachAction;
use Exception;
use Livewire\Component;

class RoleChoice extends Component
{
    public $project_id;
    public $user;
    public $isEdit = false;
    public $checks;
    public $inherits = [];
    public $groups =[];

    protected $listeners = [
        'refresh' => '$refresh',
        'edit' => 'edit',
    ];

    public function mount($user)
    {
        $this->user = (array)$user;
    
        $this->checks = [];
        foreach($user->roles as $role){
            if($role->inherit){
                $this->inherits[$role->id] = "1";
            } elseif($role->group){
                $this->groups[$role->id] = "1";
            } else {
                $this->checks[$role->id] = "1";
            }
        }
    }

    public function render()
    {
        $user_obj = (object)$this->user;
        $user_obj->roles = collect($user_obj->roles);

        $all_roles = Role::query()->get();
        return view('livewire.role-choice', compact('user_obj', 'all_roles'));
    }

    public function edit($project_id, $user_id)
    {
        if(($this->project_id === $project_id) and ($this->user['id'] === $user_id)){
            $this->isEdit = true;
        }
    }

    public function save(AttachAction $action)
    {
        $roles = [];
        foreach($this->checks as $key => $value){
            if($value){
                $roles[] = $key;
            }
        }
        $user = (object)$this->user;
        $action($this->project_id, $user->id, $roles);
        $this->isEdit = false;
        $this->emit('refresh');
    }

    public function cancel()
    {
        $this->isEdit = false;
    }
}
