<?php

namespace App\UseCases\Enumeration;

use App\Models\Enumeration;
use Illuminate\Support\Enumerable;
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
        $enumeration_from = Enumeration::withoutGlobalScope('enumeration')
                            ->whereId($from_id)->firstOrFail();
        $enumeration_to = Enumeration::withoutGlobalScope('enumeration')
                            ->whereId($to_id)->firstOrFail();

        if($enumeration_from->type !== $enumeration_to->type) return;

        DB::transaction(function() use($enumeration_from, $enumeration_to){
            $enumeration_from->position = $enumeration_to->position;
            $enumeration_from->save();
        });
    }
}
