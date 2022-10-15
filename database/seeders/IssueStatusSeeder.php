<?php

namespace Database\Seeders;

use App\Models\IssueStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IssueStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        IssueStatus::updateOrCreate(
            ['name' => __('New')],
            ['position' => 1]
        );
        IssueStatus::updateOrCreate(
            ['name' => __('Progress')],
            ['position' => 2]
        );
        IssueStatus::updateOrCreate(
            ['name' => __('Solution')],
            ['position' => 3],
        );
        IssueStatus::updateOrCreate(
            ['name' => __('Feedback')],
            ['position' => 4]
        );
        IssueStatus::updateOrCreate(
            ['name' => __('End')],
            ['position' => 5, 'is_closed' => true]
        );
        IssueStatus::updateOrCreate(
            ['name' => __('Rejection')],
            ['position' => 6, 'is_closed' => true]
        );
    }
}
