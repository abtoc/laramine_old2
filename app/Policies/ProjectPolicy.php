<?php

namespace App\Policies;

use App\Enums\ProjectStatus;
use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAnyAdmin(User $user)
    {
        return ($user->admin or $user->admin_projects)
             ? Response::allow()
             : Response::denyAsNotFound();
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Project $project)
    {
        if($project->status === ProjectStatus::ARCHIVE){
            return Response::denyAsNotFound();
        }
        if($project->is_public){
            return Response::allow();
        }
        return Auth::check()
             ? Response::allow()
             : Response::denyAsNotFound();
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return ($user->admin or $user->admin_projects)
             ? Response::allow()
             : Response::denyAsNotFound();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Project $project)
    {
        if($project->status !== ProjectStatus::ACTIVE){
            return Response::denyAsNotFound();
        }
        return ($user->admin or $user->admin_projects)
             ? Response::allow()
             : Response::denyAsNotFound();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Project $project)
    {
        return ($user->admin or $user->admin_projects)
             ? Response::allow()
             : Response::denyAsNotFound();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Project $project)
    {
        return ($user->admin or $user->admin_projects)
             ? Response::allow()
             : Response::denyAsNotFound();
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Project $project)
    {
        return ($user->admin or $user->admin_projects)
             ? Response::allow()
             : Response::denyAsNotFound();
    }

    /**
     * Determine whether the user can permanently open the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function open(User $user, Project $project)
    {
        if($project->status !== ProjectStatus::ACTIVE){
            return ($user->admin or $user->admin_projects)
                ? Response::allow()
                : Response::denyAsNotFound();
       }
       return Response::denyAsNotFound();
    }

    /**
     * Determine whether the user can permanently close the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function close(User $user, Project $project)
    {
        if($project->status === ProjectStatus::ACTIVE){
            return ($user->admin or $user->admin_projects)
                ? Response::allow()
                : Response::denyAsNotFound();
       }
       return Response::denyAsNotFound();
    }

    /**
     * Determine whether the user can permanently archive the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function archive(User $user, Project $project)
    {
        if($project->status !== ProjectStatus::ARCHIVE){
            return ($user->admin or $user->admin_projects)
                ? Response::allow()
                : Response::denyAsNotFound();
       }
       return Response::denyAsNotFound();
    }

    /**
     * Determine whether the user can permanently member the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function member(User $user, Project $project)
    {
        if($project->status !== ProjectStatus::ARCHIVE){
            return ($user->admin or $user->admin_projects)
                ? Response::allow()
                : Response::denyAsNotFound();
       }
       return Response::denyAsNotFound();
    }
}
