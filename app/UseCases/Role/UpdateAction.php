<?php

namespace App\UseCases\Role;

use Illuminate\Support\Facades\DB;

class UpdateAction
{
    /**
     * IssueStatus Move Action
     * 
     * @param App\Models\Role $enumeration
     * @param array $attributes
     * @return void
     */
    public function __invoke($role, $attributes)
    {

        DB::transaction(function() use($role, $attributes){
            $role->fill($attributes);
            $role->save();
        });
    }
}
