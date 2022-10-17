<?php

namespace App\UseCases\IssueStatus;

use Illuminate\Support\Facades\DB;

class DestroyAction {
    /**
     * IssueStatus Move Action
     * 
     * @param App\Models\IssueStatus $issue_status
     * @return void
     */
    public function __invoke($issue_status)
    {

        DB::transaction(function() use($issue_status){
            $issue_status->delete();
        });
    }
}
