<?php

namespace App\UseCases\Role;

use App\Enums\RoleBuiltin;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class MoveAction 
{
    /**
     * IssueStatus Move Action
     * 
     * @param integer $from_id
     * @param integer $to_id
     * @return void
     */
    public function __invoke($from_id, $to_id)
    {
        $role_from = Role::findOrFail($from_id);
        $role_to = Role::findOrFail($to_id);

        if($role_from->builtin !== RoleBuiltin::OTHER) abort(404);
        if($role_to->builtin !== RoleBuiltin::OTHER) abort(404);

        DB::transaction(function() use($role_from, $role_to){
            $role_from->position = $role_to->position;
            $role_from->save();
        });
    }
}
