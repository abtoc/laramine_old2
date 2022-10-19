<?php

namespace App\UseCases\GroupProjects;

use App\Models\Member;
use App\Models\Project;

class RenderAction
{
    /**
     * Get Projects
     * 
     * @param  \App\Models\Group $group
     * @return \Illuminate\Support\Collection;
     */
    public function __invoke($group)
    {
        $projects = collect([]);

        foreach($group->projects as $project){
            $index_projects = $projects->search(fn($item, $key) => $item->id === $project->id);
            if($index_projects === false){
                $index_projects = $projects->push((object)[
                    'id' => $project->id,
                    'name' => $project->name,
                    'status' => $project->status->value,
                    'is_delete' => true,
                    'roles' => collect([]),
                ])->count() - 1;
            }
            $project_obj = $projects[$index_projects];
            $q = Member::query()
                    ->whereProjectId($project_obj->id)
                    ->whereUserId($group->id);
            if($q->exists()){
                foreach($q->first()->roles as $role){
                    $index_roles = $project_obj->roles->search(fn($item, $key) => $item->id === $role->id);
                    if($index_roles === false){
                        $project_obj->roles->push((object)[
                            'id' => $role->id,
                            'name' => $role->name,
                            'position' => $role->position,
                            'inherit' => false,
                            'group' => false,
                        ]);
                    }
                }
            }

            if($project->inherit_members){
                $project = $project->parent;
                while($project){
                    $query = Member::query()
                                ->whereProjectId($project->id)
                                ->whereUserId($group->id);
    
                    if($query->exists()){
                        foreach($query->first()->roles as $role){
                            $index_roles = $project_obj->roles->search(fn($item, $key) => $item->id === $role->id);
                            if($index_roles === false){
                                $index_roles = $project_obj->roles->push((object)[
                                    'id' => $role->id,
                                    'name' => $role->name,
                                    'position' => $role->position,
                                    'inherit' => true,
                                    'group' => false,
                                ])->count() - 1;
                            }
                            $project_obj->roles[$index_roles]->inherit = true;
                        }
                    }
    
                    if(!$project->inherit_members)  break;
                    $project = $project->parent;
                }
            }

            $project_obj->roles = $project_obj->roles->sortBy('positon');
            $projects[$index_projects] = $project_obj;
        }

        $projects = $projects->sortBy('name');
        return [$projects];
    }
}
