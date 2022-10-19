<?php

namespace App\UseCases\Role;

use Illuminate\Support\Facades\DB;

class DestroyAction
{
    /**
     * IssueStatus Move Action
     * 
     * @param App\Models\Role $role
     * @return void
     */
    public function __invoke($role)
    {

        DB::transaction(function() use($role){
            $role->delete();
        });
    }
}
