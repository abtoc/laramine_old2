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
                'permissions' => [
                    Permissions::VIEW_ISSUE->value,
                    Permissions::ADD_ISSUE->value,
                ],
            ]
        );
        Role::updateOrCreate(
            ['name' => __('Anonymous')],
            [ 
                'position' => 0,
                'builtin' => RoleBuiltin::ANONYMOUS,
                'permissions' => [
                    Permissions::VIEW_ISSUE->value,
                ],
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
                    Permissions::ADD_SUBPROJECTS->value,

                    Permissions::VIEW_ISSUE->value,
                    Permissions::ADD_ISSUE->value,
                    Permissions::EDIT_ISSUE->value,
                    Permissions::EDIT_OWN_ISSUE->value,
                    Permissions::COPY_ISSUE->value,
                    Permissions::MANAGE_ISSUE_RELATIONS->value,
                    Permissions::MANAGE_SUBTASKS->value,
                    Permissions::SET_ISSUES_PRIVATE->value,
                    Permissions::SET_OWN_ISSUES_PRIVATE->value,
                ],
            ]
        );
        Role::updateOrCreate(
            ['name' => __('Developer')],
            [ 
                'position' => 2,
                'builtin' => RoleBuiltin::OTHER,
                'permissions' => [
                    Permissions::VIEW_ISSUE->value,
                    Permissions::ADD_ISSUE->value,
                    Permissions::EDIT_ISSUE->value,
                    Permissions::MANAGE_ISSUE_RELATIONS->value,
                    Permissions::MANAGE_SUBTASKS->value,
                ],
            ]
        );
        Role::updateOrCreate(
            ['name' => __('Reporter')],
            [ 
                'position' => 3,
                'builtin' => RoleBuiltin::OTHER,
                'permissions' => [
                    Permissions::VIEW_ISSUE->value,
                    Permissions::ADD_ISSUE->value,
                ],
            ]
        );
    }
}
