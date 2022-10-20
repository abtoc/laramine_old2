<?php

namespace App\UseCases\GroupProjects;

use App\Enums\ProjectStatus as Status;
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

        $query = Project::query()
                    ->select(['projects.*', 'member.id as member_id'])
                    ->join('member', 'projects.id', '=', 'member.project_id')
                    ->where('member.user_id', $group->id)
                    ->where('status', '<>', Status::ARCHIVE);
        foreach($query->cursor() as $project){
            $index_projects = $projects->search(fn($item, $key) => $item->id === $project->id);
            if($index_projects === false){
                $index_projects = $projects->push((object)[
                    'id' => $project->id,
                    'name' => $project->name,
                    'status' => $project->status->value,
                    'roles' => collect([]),
                ])->count() - 1;
            }
            $projects[$index_projects]->is_delete = true;
            $project_obj = $projects[$index_projects];

            $member = Member::find($project->member_id);
            foreach($member->roles as $role){
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
            $project_obj->roles = $project_obj->roles->sortBy('position');

            $query = Project::activeOrClosed()
                        ->where('_lft', '>', $project->_lft)
                        ->where('_rgt', '<', $project->_rgt)
                        ->whereInheritMembers(true)
                        ->orderBy('_lft', 'asc');
            foreach($query->cursor() as $child){
                $index_children = $projects->search(fn($item, $value) => $item->id === $child->parent_id);
                if($index_children === false)  continue;
                $projects->push((object)[
                    'id' => $child->id,
                    'name' => $child->name,
                    'status' => $child->status->value,
                    'is_delete' => false,
                    'roles' => $project_obj->roles->map(function($item, $key){
                        $role = $item;
                        $role->inherit;
                        return $role;
                    })
                ]);
            }

            $projects[$index_projects] = $project_obj;
        }

        $projects = $projects->sortBy('name');

        return [$projects];
    }
}
