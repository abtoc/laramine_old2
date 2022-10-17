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

    protected $listeners = ['refresh' => '$refresh'];

    public function regist(AttachAction $action)
    {
        $roles = [];
        foreach($this->check_roles as $key => $value){
            if($value){
                $roles[] = $key;
            }
        }
        if(count($roles) === 0){
            return;
        }
        foreach($this->check_users as $key => $value){
            if($value){
                $action($this->project->id, $key, $roles);
             }
        }
        $this->check_roles = [];
        $this->check_projects = [];
        $this->setPage(1, 'users-page');
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
