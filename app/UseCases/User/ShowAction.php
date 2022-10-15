<?php

namespace App\UseCases\User;

use App\Models\Project;

class ShowAction {
    /**
     * Show User Action
     * 
     * @param \App\Models\User $user
     * @return array
     */
    public function __invoke($user)
    {
        $query = Project::query()
                    ->join('member', 'projects.id', '=', 'member.project_id')
                    ->select(['projects.id', 'projects.name', 'member.id as member_id', 'member.created_at'])
                    ->where(function($q) use($user){
                        $q->where('member.user_id', $user->id)
                          ->orWhereIn('member.user_id', function($q) use($user){
                            $q->select('group_id')->from('groups_users')->where('user_id', $user->id);
                          });                      
                    })
                    ->activeOrClosed()
                    ->orderBy('projects.name', 'asc');
        return [$query->get()];                    
    }
}