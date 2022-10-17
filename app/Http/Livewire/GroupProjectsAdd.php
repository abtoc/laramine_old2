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
        foreach($this->check_projects as $key => $value){
            if($value){
                $hidden = true;
                $action($key, $this->group->id, $roles);
             }
        }
        if($hidden) $this->emit('hideModal');
    }

    public function hidden()
    {
        $this->check_roles = [];
        $this->check_projects = [];

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
        $projects = $query->get();
        $roles = Role::orderBy('position', 'asc')->get();
        return view('livewire.group-projects-add', compact('projects', 'roles'));
    }
}
