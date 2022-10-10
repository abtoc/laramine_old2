<?php

namespace Database\Seeders;

use App\Enums\Permissions;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::updateOrCreate(
            ['name' => __('Non Member')],
            [
                'position' => 0,
                'builtin' => 1,
            ]
        );
        Role::updateOrCreate(
            ['name' => __('Anonymous')],
            [ 
                'position' => 0,
                'builtin' => 2,
            ]
        );
        Role::updateOrCreate(
            ['name' => __('Administrator')],
            [ 
                'position' => 1,
                'permissions' => [
                    Permissions::EDIT_PROJECT->value,
                    Permissions::CLOSE_PROJECT->value,
                    Permissions::DELETE_PROJECT->value,
                    Permissions::MANAGE_MEMBERS->value,
                ],
            ]
        );
        Role::updateOrCreate(
            ['name' => __('Developer')],
            [ 
                'position' => 2,
                'permissions' => [],
            ]
        );
        Role::updateOrCreate(
            ['name' => __('Reporter')],
            [ 
                'position' => 3,
                'permissions' => [],
            ]
        );
    }
}
