<?php

namespace App\Policies;

use App\Enums\UserType;
use App\Models\Group;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class GroupPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return ($user->admin or $user->admin_users)
             ? Response::allow()
             : Response::denyAsNotFound();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Group $group)
    {
        if($group->isGroup()){
            return ($user->admin or $user->admin_users)
                ? Response::allow()
                : Response::denyAsNotFound();
        }
        return Response::denyAsNotFound();
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return ($user->admin or $user->admin_users)
             ? Response::allow()
             : Response::denyAsNotFound();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Group $group)
    {
        if($group->isGroup()){
            return ($user->admin or $user->admin_users)
                ? Response::allow()
                : Response::denyAsNotFound();
        }
        return Response::denyAsNotFound();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Group $group)
    {
        if($group->isGroup(true)){
            return ($user->admin or $user->admin_users)
                ? Response::allow()
                : Response::denyAsNotFound();
        }
        return Response::denyAsNotFound();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Group $group)
    {
        if($group->isGroup()){
            if($group->type !== UserType::GROUP){
                return Response::denyAsNotFound();
            }
            return ($user->admin or $user->admin_users)
                ? Response::allow()
                : Response::denyAsNotFound();
        }
        return Response::denyAsNotFound();
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Group $group)
    {
        if($group->type !== UserType::GROUP){
            return Response::denyAsNotFound();
        }
        if($group->isGroup()){
            return ($user->admin or $user->admin_users)
                ? Response::allow()
                : Response::denyAsNotFound();
        }
        return Response::denyAsNotFound();
    }

    /**
     * @param  \App\Models\User  $user
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function users(User $user, Group $group)
    {
        if($group->isGroup(true)){
            return ($user->admin or $user->admin_users)
                ? Response::allow()
                : Response::denyAsNotFound();
        }
        return Response::denyAsNotFound();
    }

    /**
     * @param  \App\Models\User  $user
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function projects(User $user, Group $group)
    {
        if($group->isGroup()){
            return ($user->admin or $user->admin_users)
                ? Response::allow()
                : Response::denyAsNotFound();
        }
        return Response::denyAsNotFound();
    }
}
