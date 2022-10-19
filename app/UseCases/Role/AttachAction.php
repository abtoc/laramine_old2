<?php

namespace App\UseCases\Role;

use App\Models\Member;
use Illuminate\Support\Facades\DB;

class AttachAction {
    /**
     * Attach Role
     * 
     * @param integer $project_id
     * @param integer $user_id
     * @param array<integer>|integer $role_ids
     * @return void
     */
    public function __invoke($project_id, $user_id, $role_ids)
    {
        DB::transaction(function() use($project_id, $user_id, $role_ids){
            if(count($role_ids) > 0){
                $member = Member::firstOrCreate(['project_id' => $project_id, 'user_id' => $user_id]);
                $member->roles()->sync($role_ids);
            } else {
                $member = Member::query()
                            ->whereProjectId($project_id)
                            ->whereUserId($user_id)
                            ->first();
                if($member) $member->delete();
            }
        });
    }
};