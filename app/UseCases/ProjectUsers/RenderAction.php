<?php

namespace App\UseCases\ProjectUsers;

use App\Models\Member;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

class RenderAction {

    /**
     * Get Members
     * 
     * @param  \App\Models\Project $project
     * @return array
     */
    public function __invoke($project)
    {
        $users = collect([]);
        $inherit = false;
        $proj = $project;
        while($proj){
            foreach($proj->users as $user){
                $index_users = $users->search(fn($item, $key) => $item->id === $user->id);
                if($index_users === false){
                    $index_users = $users->push((object)[
                        'id' => $user->id,
                        'name' => $user->name,
                        'type' => 'User',
                        'is_user' => true,
                        'project' => $proj->id,
                        'is_delete' => $inherit ? false : true,
                        'roles' => collect([]),
                    ])->count() - 1;
                }
                $user_obj = $users[$index_users];
                $q = Member::query()
                            ->whereProjectId($proj->id)
                            ->whereUserId($user->id);
                if($q->exists()){
                    foreach($q->first()->roles as $role){
                        $index_roles = $user_obj->roles->search(fn($item, $key) => $item->id === $role->id);
                        if($index_roles === false){
                            $user_obj->roles->push((object)[
                                'id' => $role->id,
                                'name' => $role->name,
                                'position' => $role->position,
                                'inherit' => $inherit,
                                'group' => false,
                            ]);
                        }
                    }
                }
                $user_obj->roles = $user_obj->roles->sortBy('position');
                $users[$index_users] = $user_obj;
            }
            if(!$proj->inherit_members) break;
            $proj = $proj->parent;
            $inherit = true;
        }

        $proj = $project;
        $inherit = false;
        while($proj){
            foreach($proj->groups as $group){
                $index_groups = $users->search(fn($item, $key) => $item->id === $group->id);
                if($index_groups === false){
                    $index_groups = $users->push((object)[
                        'id' => $group->id,
                        'name' => $group->name,
                        'type' => 'Group',
                        'is_user' => true,
                        'project' => $proj->id,
                        'is_delete' => $inherit ? false : true,
                        'roles' => collect([]),
                    ])->count() - 1;
                }
                $group_obj = $users[$index_groups];
                $q = Member::query()
                            ->whereProjectId($proj->id)
                            ->whereUserId($group->id);
                if($q->exists()){
                $roles_group = $q->first()->roles;
                    foreach($roles_group as $role){
                        $index_roles = $group_obj->roles->search(fn($item, $key) => $item->id === $role->id);
                        if($index_roles === false){
                            $group_obj->roles->push((object)[
                                'id' => $role->id,
                                'name' => $role->name,
                                'position' => $role->position,
                                'inherit' => $inherit,
                                'group' => false,
                            ]);
                        }
                    }
                } else {
                    $roles_group = collect([]);
                }
                $group_obj->roles = $group_obj->roles->sortBy('position');
                $users[$index_groups] = $group_obj;

                $q = DB::table('groups_users')->whereGroupId($group->id);
                foreach($q->get() as $gu){
                    $index_users = $users->search(fn($item, $key) => $item->id === $gu->user_id);
                    if($index_users === false){
                        $user = User::find($gu->user_id);
                        $index_users = $users->push((object)[
                            'id' => $user->id,
                            'name' => $user->name,
                            'type' => 'User',
                            'is_user' => true,
                            'project' => $proj->id,
                            'is_delete' => false,
                            'roles' => collect([]),
                        ])->count() - 1;
                   }
                   $user_obj = $users[$index_users];
                   foreach($roles_group as $role){
                        $index_roles = $user_obj->roles->search(fn($item, $key) => $item->id === $role->id);
                        if($index_roles === false){
                            $user_obj->roles->push((object)[
                                'id' => $role->id,
                                'name' => $role->name,
                                'position' => $role->position,
                                'inherit' => $inherit,
                                'group' => true,
                            ]);
                        }
                   }
                }
            }
            if(!$proj->inherit_members) break;
            $proj = $proj->parent;
            $inherit = true;
        }

        $users = $users->sortBy('name');
        return [$users];       
    }
}