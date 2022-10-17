<?php

namespace App\Http\Livewire;

use App\Enums\UserType as Type;
use App\Models\Role;
use App\Models\User;
use App\UseCases\Role\AttachAction;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectUsersAdd extends Component
{
    use WithPagination;

    public $project;
    public $search = "";
    public $check_roles = [];
    public $check_users = [];

    protected $listeners = [
        'hiddenModal' => 'hidden',
        'refresh' => '$refresh'
    ];

    public function regist(AttachAction $action)
    {
        $roles = [];
        foreach($this->check_roles as $key => $value){
            if($value){
                $roles[] = $key;
            }
        }
        if(count($roles) === 0){
            $this->emit('errorModal', __('Please select a role.'));
            return;
        }
        $hidden = false;
        foreach($this->check_users as $key => $value){
            if($value){
                $hidden = true;
                $action($this->project->id, $key, $roles);
             }
        }
        if($hidden) $this->emit('hideModal');
    }

    public function hidden()
    {
        $this->check_roles = [];
        $this->check_users = [];
        $this->emit('refresh');
    }

    public function render()
    {
        $project = $this->project;
        $query = User::query()
            ->withoutGlobalScope('user')
            ->active()
            ->whereIn('type', [Type::USER, Type::GROUP])
            ->whereNotIn("id", function($query) use($project){
                $query->select("user_id")->from("member")->where("project_id", $project->id);
            })
            ->active()
            ->orderBy('name', 'asc')
            ->when(!empty($this->search), function($q){
                return $q->where('name', 'like', '%'.$this->search.'%');
            });
        $users = $query->get();
        $roles = Role::orderBy('position', 'asc')->get();

        return view('livewire.project-users-add', compact('users', 'roles'));
    }
}
