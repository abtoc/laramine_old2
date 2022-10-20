<?php

namespace App\UseCases\Tracker;

use App\Models\Tracker;
use Illuminate\Support\Facades\DB;

class MoveAction
{
    /**
     * IssueStatus Move Action
     * 
     * @param integer $from_id
     * @param integer $to_id
     * @return void
     */
    public function __invoke($from_id, $to_id)
    {
        $tracker_from = Tracker::findOrFail($from_id);
        $tracker_to = Tracker::findOrFail($to_id);

        DB::transaction(function() use($tracker_from, $tracker_to){
            $tracker_from->position = $tracker_to->position;
            $tracker_from->save();
        });
    }
}
