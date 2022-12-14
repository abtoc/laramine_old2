<?php

namespace App\UseCases\Role;

use App\Models\Member;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class HasAction
{
    /**
     * Attach Role
     * 
     * @param \App\Models\Project $project
     * @param \App\Models\User $user
     * @param array<\App\Enums\Permissions>|\App\Enums\Permissions $permissions
     * @return bool
     */
    public function __invoke($project, $user, $permissions)
    {
        while($project){
            $member = $project->members()->whereUserId($user->id)->first();
            if($member){
                $index = $member->roles->search(fn($item, $key) => $item->has($permissions));
                if($index !== false)  return true;
            }
            foreach($project->groups as $group){
                if(!$group->hasUser($user)) continue;
                $index = $group->pivot->roles()->get()->search(fn($item, $key) => $item->has($permissions));
                if($index !== false) return true;
            }
            if(!$project->inherit_members)  break;
            $project = $project->parent;
        }
        return false;
    }
}