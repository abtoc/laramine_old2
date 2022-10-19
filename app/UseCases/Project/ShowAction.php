<?php

namespace App\UseCases\Project;

use App\Models\User;

class ShowAction {
    /**
     * Project Show Action
     * 
     * @param \App\Models\Project $project
     * @return array
     */
    public function __invoke($project)
    {
        $members =collect([]);
        while($project){
            $query = User::withoutGlobalScope('user')
                        ->join('member', 'users.id', '=', 'member.user_id')
                        ->join('member_roles', 'member.id', '=', 'member_roles.member_id')
                        ->join('roles', 'roles.id', '=', 'member_roles.role_id')
                        ->select(['roles.position', 'roles.position', 'roles.name as role', 'users.id', 'users.name', 'users.type'])
                        ->where('member.project_id', $project->id)
                        ->orderBy('roles.position', 'asc')
                        ->orderBy('users.name', 'asc');
            foreach($query->cursor() as $user){
                $key = $user->position.'.'.$user->role;
                if(!$members->contains(fn($value, $key) => $key === $user->role)){
                    $members->put($key, collect([]));
                }
                if(!$members[$key]->contains(fn($value, $key) => $value->id === $user->id)){
                    $members[$key]->push($user);
                }
            }

            if(!$project->inherit_members) break;
            $project = $project->parent;
        }

        $members = $members->sortKeys();

        return [$members];
    }
}