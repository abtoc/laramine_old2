<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * MemberRole
 * 
 * @property \App\Models\Member $member
 * @property \App\Models\Role $role
 */

class MemberRole extends Model
{
    use HasFactory;

    public function member() { $this->belongTo(Member::class); }
    public function role()   { $this->belongTo(Role::class); }
}
