<?php

namespace App\Http\Livewire;

use App\Models\Role;
use App\UseCases\Role\AttachAction;
use Exception;
use Livewire\Component;

class RoleChoice extends Component
{
    public $project_id;
    public $user_id;
    public $roles;
    public $isEdit = false;
    public $checks;
    public $inherits = [];
    public $groups =[];

    protected $listeners = [
        'refresh' => '$refresh',
        'edit' => 'edit',
    ];

    public function mount($roles)
    {
        $this->roles = (array)$roles;
    
        $this->checks = [];
        foreach($roles as $role){
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
        $roles = (object)$this->roles;

        $all_roles = Role::query()->get();
        return view('livewire.role-choice', compact('roles', 'all_roles'));
    }

    public function edit($project_id, $user_id)
    {
        if(($this->project_id === $project_id) and ($this->user_id === $user_id)){
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
        $action($this->project_id, $this->user_id, $roles);
        $this->isEdit = false;
        $this->emit('refresh');
    }

    public function cancel()
    {
        $this->isEdit = false;
    }
}
