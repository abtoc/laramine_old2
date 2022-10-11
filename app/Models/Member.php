<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Member
 * 
 * @property integer $id
 * @property integer $project_id
 * @property itneger $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \App\Models\Project $project
 * @property \Illuminate\Database\Eloquent\Collection<MemberRole> $member_roles 
 * @property \App\Models\User $user
 */

class Member extends Model
{
    use HasFactory;

    /**
     * Relation
     */
    public function project() { return $this->belongsTo(Project::class); }
    public function member_roles() { return $this->hasMany(MemberRole::class); }
    public function roles() { return $this->belongsToMany(Role::class, 'member_roles', 'member_id', 'role_id'); }
    public function user() { return $this->belongsTo(User::class); }
}
