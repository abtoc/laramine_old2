<?php

namespace App\Http\Livewire;

use App\Models\Role;
use App\UseCases\Role\AttachAction;
use Livewire\Component;

class RoleChoice extends Component
{
    public $roles;
    public $project_id;
    public $user_id;
    public $isEdit = false;
    public $checks;

    protected $listeners = ['edit' => 'edit'];

    public function mount()
    {
        foreach($this->roles as $role){
            $checks[$role->id] = "1";
        }
        \Log::info('mount');
    }

    public function render()
    {
        \Log::info('render');
        $all_roles = Role::orderBy('position', 'asc')->get();
        $roles = $this->roles;
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
                $roles = $key;
            }
        }
        $action($this->project_id, $this->user_id, $roles);
        $this->isEdit = false;
        $this->emit('refreshComponent');
    }

    public function cancel()
    {
        $this->isEdit = false;
    }
}
