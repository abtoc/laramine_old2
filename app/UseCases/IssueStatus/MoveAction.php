<?php

namespace App\UseCases\IssueStatus;

use App\Models\IssueStatus;
use Illuminate\Support\Facades\DB;

class MoveAction {
    /**
     * IssueStatus Move Action
     * 
     * @param integer $from_id
     * @param integer $to_id
     * @return void
     */
    public function __invoke($from_id, $to_id)
    {
        $issue_status_from = IssueStatus::findOrFail($from_id);
        $issue_status_to = IssueStatus::findOrFail($to_id);

        DB::transaction(function() use($issue_status_from, $issue_status_to){
            $issue_status_from->position = $issue_status_to->position;
            $issue_status_from->save();
        });
    }
}
