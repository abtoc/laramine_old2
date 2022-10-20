<?php

namespace App\UseCases\Tracker;

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
            if(in_array('projects', $attributes)){
                $tracker->projects()->sync($attributes['projects']);
            } else {
                $tracker->projects()->sync([]);
            }
        });
    }
}
