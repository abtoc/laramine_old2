<?php

namespace App\UseCases\User;

use App\Models\Member;
use App\Models\Project;

class ShowAction
{
    /**
     * Show User Action
     * 
     * @param \App\Models\User $user
     * @return array
     */
    public function __invoke($user)
    {
		$projects = collect([]);

		$query = Project::query()
					->select(['projects.*', 'member.user_id', 'member.id as member_id', 'member.created_at'])
					->join('member', 'projects.id', '=', 'member.project_id')
					->where(function($q) use($user){
						$q->where('member.user_id', $user->id)
						  ->orWhereIn('member.user_id', function($q) use($user){
							$q->select('group_id')->from('groups_users')->where('groups_users.user_id', $user->id);
						  });
					})
					->activeOrClosed()
					->orderBy('projects._lft', 'asc');
		foreach($query->cursor() as $project){
			$index_projects = $projects->search(fn($item, $key) => $item->id === $project->id);
			if($index_projects === false){
				$index_projects = $projects->push((object)[
					'id' => $project->id,
					'name' => $project->name,
					'roles' => collect([]),
					'created_at' => $project->created_at,
				])->count() - 1;
			}
			$project_obj = $projects[$index_projects];
			$q = Member::query()
					->whereProjectId($project->id)
					->whereUserId($project->user_id);
			if($q->exists()){
				foreach($q->get() as $member){
					foreach($member->roles as $role){
						$index_roles = $project_obj->roles->search(fn($item, $key) => $item->id === $role->id);
						if($index_roles === false){
							$project_obj->roles->push($role);
						}
					}
				}
			}
			$projects[$index_projects] = $project_obj;

            $query = Project::query()
                        ->where('_lft', '>', $project->_lft)
                        ->where('_rgt', '<', $project->_rgt)
                        ->whereInheritMembers(true)
                        ->orderBy('_lft', 'asc');
			foreach($query->cursor() as $child){
				$index_children = $projects->search(fn($item, $key) => $item === $child->id);
				if($index_children === false){
					$projects->push((object)[
						'id' => $child->id,
						'name' => $child->name,
						'roles' => clone $project_obj->roles,
						'created_at' => $project->created_at,
					]);
				}				
			}
		}

		$projects = $projects->sortBy('name');
		$projects->transform(function($item, $key){
			$item->roles = $item->roles->sortBy('position')->implode('name', ',');
			return $item;
		});
	    return [$projects];                    
    }
}