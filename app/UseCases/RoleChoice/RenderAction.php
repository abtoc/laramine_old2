<?php

namespace App\UseCases\RoleChoice;

use App\Enums\UserType as Type;
use App\Models\Member;
use App\Models\Project;
use App\Models\User;
use App\Models\Role;

class RenderAction
{
    /**
     * Role Choilce
     * 
     * @param  integer $project_id
     * @param  integer $user_id
     * @return array
     */
    public function __invoke($project_id, $user_id)
    {
        $all_roles = Role::get();
        $roles = collect([]);

        $user = User::withoutGlobalScope('user')
                    ->whereId($user_id)
                    ->first();
        if(is_null($user))  return [$roles, $all_roles];
        $project = Project::withoutGlobalScope('project')
                    ->whereId($project_id)
                    ->first();
        if(is_null($project))   return [$roles, $all_roles];

        $inherit = false;
        while($project){
            $member = Member::query()
                        ->whereProjectId($project->id)
                        ->whereUserId($user->id)
                        ->first();
            if($member){
                foreach($member->roles as $role){
                    $index = $roles->search(fn($item, $key) => $item->id === $role->id);
                    if($index === false){
                        $index = $roles->push((object)[
                            'id' => $role->id,
                            'name' => $role->name,
                            'position' => $role->position,
                        ])->count() - 1;
                    }
                    $roles[$index]->inherit = $inherit;
                    $roles[$index]->group = false;
                }                
            }
            if($user->type === Type::USER){
                $members = Member::query()
                            ->whereProjectId($project->id)
                            ->whereIn('user_id', function($q) use($user){
                                $q->select('group_id')->from('groups_users')->where('user_id', $user->id);
                            })->get();
                foreach($members as $member){
                    foreach($member->roles as $role){
                        $index = $roles->search(fn($item, $key) => $item->id === $role->id);
                        if($index === false){
                            $index = $roles->push((object)[
                                'id' => $role->id,
                                'name' => $role->name,
                                'position' => $role->positon,
                            ])->count() - 1;
                        }
                        $roles[$index]->inherit = $inherit;
                        $roles[$index]->group = true;
                    }
                }
            }

            if(!$project->inherit_members) break;
            $project = $project->parent;
            $inherit = true;
        }

        $roles = $roles->sortBy('position');

        return [$roles, $all_roles];
    }
}