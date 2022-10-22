<?php

namespace App\UseCases\Tracker;

use App\Models\Workflow;
use Illuminate\Support\Facades\DB;

class UpdateAction
{
    /**
     * IssueStatus Move Action
     * 
     * @param App\Models\Tracker $tracker
     * @param array $attributes
     * @return void
     */
    public function __invoke($tracker, $attributes)
    {
        DB::transaction(function() use($tracker, $attributes){
            $tracker->fill($attributes);

            $fields_bits = 1 + 8 + 16 + 32 + 256;
            foreach($attributes['fields_bits'] as $field_bit){
                $fields_bits = $fields_bits & ~(int)$field_bit;
            }
            $tracker->fields_bits = $fields_bits;
            $tracker->save();
            if(array_key_exists('projects', $attributes)){
                $tracker->projects()->sync($attributes['projects']);
            } else {
                $tracker->projects()->sync([]);
            }

            if(array_key_exists('from_tracker_id', $attributes)){
                if($attributes['from_tracker_id'] != 0){
                    $workflows = Workflow::query()
                                    ->whereTrackerId($attributes['from_tracker_id'])
                                    ->get();
                    foreach($workflows as $workflow){
                        $new_workflow = $workflow->replicate();
                        $new_workflow->tracker_id = $tracker->id;
                        $new_workflow->save();
                    }
                }
            }
        });
    }
}
