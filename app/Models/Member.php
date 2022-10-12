<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Member
 *
 * @property integer $id
 * @property integer $project_id
 * @property itneger $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \App\Models\Project $project
 * @property \App\Models\User $user
 * @property \App\Models\Group $group
 * @property \Illuminate\Database\Eloquent\Collection<Member> $roles 
 */

class Member extends Pivot
{
    /**
     * Relation
     */
    public function project() { return $this->belongsTo(Project::class); }
    public function group() { return $this->belongsTo(Group::class); }
    public function roles() { return $this->belongsToMany(Role::class, 'member_roles'); }
    public function user() { return $this->belongsTo(User::class); }
}
