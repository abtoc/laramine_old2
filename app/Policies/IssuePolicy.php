<?php

namespace App\Policies;

use App\Models\Issue;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class IssuePolicy
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
        return Response::allow();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Issue  $issue
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Issue $issue)
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Issue  $issue
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Issue $issue)
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Issue  $issue
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Issue $issue)
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Issue  $issue
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Issue $issue)
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Issue  $issue
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Issue $issue)
    {
        return Response::allow();
    }
}
