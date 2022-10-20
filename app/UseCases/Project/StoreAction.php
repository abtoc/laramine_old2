<?php

namespace App\UseCases\Project;

use App\Models\Project;
use App\Models\Tracker;
use Illuminate\Support\Facades\DB;

class StoreAction {
    /**
     * Project Stor Action
     * 
     * @param array $attributes
     * @return array
     */
    public function __invoke($attributes)
    {
        DB::transaction(function() use($attributes){
            $project = new Project();
            $project->fill($attributes);
            $project->save();
        });
   }
}