<?php

namespace App\UseCases\Workflow;

use App\Models\IssueStatus;
use App\Models\Tracker;
use App\Models\Workflow;

class EditAction
{
    /**
     * Workflow edit
     * 
     * @param  integer $tracker_id
     * @return array
     */
    public function __invoke($tracker_id = null)
    {
        $result = [];
        if(!is_null($tracker_id)){
            $workflows = Workflow::query()
                ->whereTrackerId($tracker_id)
                ->get();
            foreach($workflows as $workflow){
                if(!array_key_exists($workflow->old_status_id, $result)){
                    $result[$workflow->old_status_id] = [];
                }
                $result[$workflow->old_status_id][$workflow->new_status_id] = 1;
            }

        }

        return [$result];
    }
}