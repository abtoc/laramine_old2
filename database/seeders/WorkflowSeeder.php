<?php

namespace Database\Seeders;

use App\Models\IssueStatus;
use App\Models\Tracker;
use App\Models\Workflow;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkflowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $trackers = Tracker::all();
        foreach($trackers as $tracker){
            $statuses_old = IssueStatus::all();
            foreach($statuses_old as $status_old){
                $statuses_new = IssueStatus::all();
                foreach($statuses_new as $status_new){
                    if($status_old->id === $status_new->id) continue;
                    Workflow::updateOrCreate(
                        [
                            'tracker_id' => $tracker->id,
                            'old_status_id' => $status_old->id,
                            'new_status_id' => $status_new->id,
                        ],
                        []
                    );
                }
            }
        }
    }
}
