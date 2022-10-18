<?php

namespace App\UseCases\User;

use App\Models\Member;
use App\Models\Project;
use Exception;

class ShowAction {
    /**
     * Show User Action
     * 
     * @param \App\Models\User $user
     * @return array
     */
    public function __invoke($user)
    {
		$projects = collect([]);
		$query = Project::activeOrClosed()->orderBy('name', 'asc');
		foreach($query->get() as $project)
		{
			if(!$project->isJoining($user)) continue;

			$project_obj = (object)[
				'id' => $project->id,
				'name' => $project->name,
				'roles' => collect([]),
				'created_at' => null,
			];
			$q = Project::query()
				->select(['member.id', 'member.created_at'])
				->join('member', 'projects.id', '=', 'member.project_id')
				->where('projects.id', $project->id)
				->where(function($q) use($user){
					$q->where('member.user_id', $user->id)
					  ->orWhereIn('member.user_id', function($q) use($user){
							$q->select('group_id')->from('groups_users')->where('user_id', $user->id);
					  });
				});
			if($q->exists()){
				foreach($q->get() as $obj){
					$project_obj->created_at = $obj->created_at;
					foreach(Member::find($obj->id)->roles as $role){
						$index = $project_obj->roles->search(fn($item, $key) => $item->id === $role->id);
						if($index === false) $project_obj->roles->push($role);
					}
				}
			}
			$parent = $project->inherit_members ? $project->parent : null;
			while($parent){
				$q = Member::query()
					->select(['id', 'created_at'])
					->whereProjectId($parent->id)
					->where(function($q) use($user){
						$q->whereUserId($user->id)
						  ->orWhereIn('user_id', function($q) use($user){
								$q->select('group_id')->from('groups_users')->where('user_id', $user->id);
						  });
					});
				if($q->exists()){
					foreach($q->get() as $obj){
						$project_obj->created_at = $obj->created_at;
						foreach(Member::find($obj->id)->roles as $role){
							$index = $project_obj->roles->search(fn($item, $key) => $item->id === $role->id);
							if($index === false) $project_obj->roles->push($role);
						}
					}
				}
				if(!$parent->inherit_members) break;
				$parent = $parent->parent;
			}
			$project_obj->roles = $project_obj->roles->sortBy('position')->implode('name', ',');
			$projects->push($project_obj);
		}
	    return [$projects];                    
    }
}