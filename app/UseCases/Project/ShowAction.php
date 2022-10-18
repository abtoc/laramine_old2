<?php

namespace App\UseCases\Project;

use App\Models\User;

class ShowAction {
    /**
     * Get Members
     * 
     * @param \App\Models\Project $project
     * @param array $members
     * @return array
     */
    private function getMembers($project, $members)
    {
        $query = User::withoutGlobalScope('user')
                    ->join('member', 'users.id', '=', 'member.user_id')
                    ->join('member_roles', 'member.id', '=', 'member_roles.member_id')
                    ->join('roles', 'roles.id', '=', 'member_roles.role_id')
                    ->select(['roles.position','roles.name as role', 'users.id', 'users.name', 'users.type'])
                    ->where('member.project_id', $project->id)
                    ->orderBy('roles.position', 'asc')->orderBy('users.name', 'asc');
        foreach($query->cursor() as $member){
            $members[$member->role][] = $member;
        }
        if($project->inherit_members and $project->parent_id){
            return $this->getMembers($project->parent, $members);
        }
        return $members;
    }
    /**
     * Project Show Action
     * 
     * @param \App\Models\Project $project
     * @return array
     */
    public function __invoke($project)
    {
        $members = $this->getMembers($project, []);
        return [$members];
    }
}