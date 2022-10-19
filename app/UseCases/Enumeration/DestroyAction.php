<?php

namespace App\UseCases\Enumeration;

use Illuminate\Support\Facades\DB;

class DestroyAction
{
    /**
     * IssueStatus Move Action
     * 
     * @param App\Models\Enumeration $enumeration
     * @return void
     */
    public function __invoke($enumeration)
    {

        DB::transaction(function() use($enumeration){
            $enumeration->delete();
        });
    }
}
