<?php

namespace App\UseCases\Workflow;

use App\Models\IssueStatus;
use Illuminate\Support\Facades\DB;

class UpdateAction
{
    /**
     * Update Workflow
     * 
     * @param integer $tracker_id
     * @param array $attributes
     * @return void
     */
    public function __invoke($tracker_id, $attributes)
    {
        DB::transaction(function() use($tracker_id, $attributes){
            if(!is_null($tracker_id)){
                $statuses_old = IssueStatus::query()->get();
                foreach($statuses_old as $status_old){
                    $statuses_new = IssueStatus::query()->get();
                    foreach($statuses_new as $status_new){
                        if(array_key_exists($status_old->id, $attributes['workflows']) and array_key_exists($status_new->id, $attributes['workflows'][$status_old->id]) ){
                            DB::table('workflows')->updateOrInsert(
                                ['tracker_id' => $tracker_id, 'old_status_id' => $status_old->id, 'new_status_id' => $status_new->id],
                                []
                            );
                            continue;
                        }
                        DB::table('workflows')
                            ->where('tracker_id', $tracker_id)
                            ->where('old_status_id', $status_old->id)
                            ->where('new_status_id', $status_new->id)
                            ->delete();
                    }
                }
            }
        });
   }
}