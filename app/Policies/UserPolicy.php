<?php

namespace App\Policies;

use App\Enums\UserType;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
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
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, User $model)
    {
        if($model->isUser()){
            if($user->admin or $user->admin_users){
                return Response::allow();
            }
            return $user->id === $model->id
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
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, User $model)
    {
        if($model->isUser()){
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
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, User $model)
    {
        if($model->isUser()){
            if($user->id === $model->id){
                return Response::denyAsNotFound();
            }
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
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, User $model)
    {
        if($model->isUser()){
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
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, User $model)
    {
        if($model->isUser()){
            if($user->id === $model->id){
                return Response::denyAsNotFound();
            }
            return ($user->admin or $user->admin_users) 
            ? Response::allow()
            : Response::denyAsNotFound();
        }
        return Response::denyAsNotFound();
    }

    /**
     * Determine if the user can lock.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function lock(User $user, User $model)
    {
        if($model->isUser()){
            if($user->id === $model->id){
                return Response::denyAsNotFound();
            }
            return ($user->admin or $user->admin_users)
                ? Response::allow()
                : Response::denyAsNotFound();
        }
        return Response::denyAsNotFound();
    }

    /**
     * Determine if the user can unlock.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function unlock(User $user, User $model)
    {
        if($model->isUser()){
            if($user->id === $model->id){
                return Response::denyAsNotFound();
            }
            return ($user->admin or $user->admin_users) 
                ? Response::allow()
                : Response::denyAsNotFound();
       }
        return Response::denyAsNotFound();
    }

}
