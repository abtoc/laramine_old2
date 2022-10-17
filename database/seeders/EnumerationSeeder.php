<?php

namespace Database\Seeders;

use App\Enums\EnumerationType as Type;
use App\Models\Enumeration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EnumerationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Enumeration::updateOrCreate(
            ['name' => __('lowest')],
            ['type' => Type::ISSUE_PRIORITY, 'position' => 1, 'is_default' => false, 'active' => true]
        );
        Enumeration::updateOrCreate(
            ['name' => __('default')],
            ['type' => Type::ISSUE_PRIORITY, 'position' => 2, 'is_default' => true, 'active' => true]
        );
        Enumeration::updateOrCreate(
            ['name' => __('high3')],
            ['type' => Type::ISSUE_PRIORITY, 'position' => 3, 'is_default' => false, 'active' => true]
        );
        Enumeration::updateOrCreate(
            ['name' => __('high2')],
            ['type' => Type::ISSUE_PRIORITY, 'position' => 4, 'is_default' => false, 'active' => true]
        );
        Enumeration::updateOrCreate(
            ['name' => __('highest')],
            ['type' => Type::ISSUE_PRIORITY, 'position' => 5, 'is_default' => false, 'active' => true]
        );
    }
}
