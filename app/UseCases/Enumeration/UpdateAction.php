<?php

namespace App\UseCases\Enumeration;

use Illuminate\Support\Facades\DB;

class UpdateAction {
    /**
     * IssueStatus Move Action
     * 
     * @param App\Models\Enumeration $enumeration
     * @param array $attributes
     * @return void
     */
    public function __invoke($enumeration, $attributes)
    {

        DB::transaction(function() use($enumeration, $attributes){
            $enumeration->fill($attributes);
            $enumeration->save();
        });
    }
}
