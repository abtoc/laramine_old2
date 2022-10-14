<?php

namespace App\Http\Livewire;

use App\Models\Member;
use App\Models\Role;
use App\UseCases\Role\AttachAction;
use Livewire\Component;

class RoleChoice extends Component
{
    public $project_id;
    public $user_id;
    public $isEdit = false;
    public $checks;

    protected $listeners = [
        'refresh' => '$refresh',
        'edit' => 'edit',
    ];

    public function mount()
    {
        $member = Member::query()
                    ->whereProjectId($this->project_id)
                    ->whereUserId($this->user_id)
                    ->first();
        $roles = $member->roles;
        $this->checks = [];
        foreach($roles as $role){
            $this->checks[$role->id] = "1";
        }
    }

    public function render()
    {
        $member = Member::query()
                    ->whereProjectId($this->project_id)
                    ->whereUserId($this->user_id)
                    ->first();
        $roles = $member->roles;
        $all_roles = Role::orderBy('position', 'asc')->get();
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
