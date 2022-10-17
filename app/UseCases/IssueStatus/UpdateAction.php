<?php

namespace App\UseCases\IssueStatus;

use Illuminate\Support\Facades\DB;

class UpdateAction {
    /**
     * IssueStatus Move Action
     * 
     * @param App\Models\IssueStatus $issue_status
     * @param array $attributes
     * @return void
     */
    public function __invoke($issue_status, $attributes)
    {

        DB::transaction(function() use($issue_status, $attributes){
            $issue_status->fill($attributes);
            $issue_status->save();
        });
    }
}
