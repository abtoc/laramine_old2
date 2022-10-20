<?php

namespace App\UseCases\Tracker;

use Illuminate\Support\Facades\DB;

class DestroyAction
{
    /**
     * IssueStatus Move Action
     * 
     * @param App\Models\Tracker $tracker
     * @return void
     */
    public function __invoke($tracker)
    {

        DB::transaction(function() use($tracker){
            $tracker->delete();
        });
    }
}
