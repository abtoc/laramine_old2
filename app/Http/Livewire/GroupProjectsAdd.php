<?php

namespace App\Http\Livewire;

use App\Models\Project;
use App\Models\Role;
use App\UseCases\Role\AttachAction;
use Livewire\Component;
use Livewire\WithPagination;

class GroupProjectsAdd extends Component
{
    use WithPagination;

    public $group;
    public $search = "";
    public $check_roles = [];
    public $check_projects = [];

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
        foreach($this->check_projects as $key => $value){
            if($value){
                $action($key, $this->group->id, $roles);
             }
        }
        $this->check_roles = [];
        $this->check_projects = [];
        $this->setPage(1, 'projects-page');
        $this->emit('refresh');
    }

    public function render()
    {
        $group = $this->group;
        $query = Project::query()
            ->active()
            ->whereNotIn("id", function($query) use($group){
                $query->select("project_id")->from("member")->where("user_id", $group->id);
            })
            ->active()
            ->orderBy('name', 'asc')
            ->when(!empty($this->search), function($q){
                return $q->where('name', 'like', '%'.$this->search.'%');
            });
        $projects = $query->simplePaginate(30, ['*'], 'projects-page');
        $roles = Role::orderBy('position', 'asc')->get();
        return view('livewire.group-projects-add', compact('projects', 'roles'));
    }
}
