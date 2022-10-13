<?php

namespace Database\Seeders;

use App\Enums\Permissions;
use App\Enums\RoleBuiltin;
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
                'builtin' => RoleBuiltin::NON_MEMBER,
            ]
        );
        Role::updateOrCreate(
            ['name' => __('Anonymous')],
            [ 
                'position' => 0,
                'builtin' => RoleBuiltin::ANONYMOUS,
            ]
        );
        Role::updateOrCreate(
            ['name' => __('Administrator')],
            [ 
                'position' => 1,
                'builtin' => RoleBuiltIn::OTHER,
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
                'builtin' => RoleBuiltin::OTHER,
                'permissions' => [],
            ]
        );
        Role::updateOrCreate(
            ['name' => __('Reporter')],
            [ 
                'position' => 3,
                'builtin' => RoleBuiltin::OTHER,
                'permissions' => [],
            ]
        );
    }
}
