<?php

namespace App\UseCases\Issue;

use App\Models\Issue;
use Illuminate\Support\Facades\DB;

class StoreAction
{
    /**
     * IssueStatus Move Action
     * 
     * @param array $attributes
     * @return void
     */
    public function __invoke($attributes)
    {
        DB::transaction(function() use($attributes){
            $issue = new Issue();
            $issue->fill($attributes);
            $issue->save();
        });
    }
}