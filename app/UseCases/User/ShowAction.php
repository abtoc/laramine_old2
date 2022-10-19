<?php

namespace App\UseCases\User;

use App\Models\Member;
use App\Models\Project;
use Exception;

class ShowAction {
	/**
	 * Get Sub Projects
	 * 
	 * @param  \App\Models\User $user
	 * @param  object $project_obj
	 * @param  \Illuminate\Support\Collection $projects
	 * @return \Illuminate\Support\Collection
	 */
	private function getSubProjects($user, $project_obj, $projects)
	{
		$query = Project::query()
					->whereParentId($project_obj->id)
					->whereInheritMembers(true);
		foreach($query->cursor() as $project){
			$index_projects = $projects->search(fn($item, $key) => $item->id === $project->id);
			if($index_projects === false){
				$index_projects =$projects->push((object)[
					'id' => $project->id,
					'name' => $project->name,
					'roles' => collect([]),
					'created_at' => $project_obj->created_at,
				])->count() -1;
			}

			$child = $projects[$index_projects];
			foreach($project_obj->roles as $role){
				$index_roles = $child->roles->search(fn($item, $key) => $item->id === $role->id);
				if($index_roles === false) $child->roles->push($role);
			}
			$projects[$index_projects] = $child;

			$projects = $this->getSubProjects($user, $child, $projects);
		}		

		return $projects;
	}
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
					->select(['projects.id', 'projects.name', 'member.user_id', 'member.id as member_id', 'member.created_at'])
					->join('member', 'projects.id', '=', 'member.project_id')
					->where(function($q) use($user){
						$q->where('member.user_id', $user->id)
						  ->orWhereIn('member.user_id', function($q) use($user){
							$q->select('group_id')->from('groups_users')->where('groups_users.user_id', $user->id);
						  });
					})
					->activeOrClosed()
					->orderBy('projects.name', 'asc');
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
			$projects = $this->getSubProjects($user, $project_obj, $projects);	
		}

		$projects = $projects->sortBy('name');
		$projects->transform(function($item, $key){
			$item->roles = $item->roles->sortBy('position')->implode('name', ',');
			return $item;
		});
	    return [$projects];                    
    }
}