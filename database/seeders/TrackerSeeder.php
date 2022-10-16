<?php

namespace Database\Seeders;

use App\Models\Tracker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrackerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tracker::updateOrCreate(
            ['name' => __('Bug')],
            ['issue_status_id' => 1, 'position' => 1],
        );
        Tracker::updateOrCreate(
            ['name' => __('Feature')],
            ['issue_status_id' => 1, 'position' => 2],
        );
        Tracker::updateOrCreate(
            ['name' => __('Support')],
            ['issue_status_id' => 1, 'position' => 3],
        );
    }
}
