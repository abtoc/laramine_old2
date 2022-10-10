<?php

namespace App\Enums;

enum Permissions : string
{
    case EDIT_PROJECT = 'edit_project';
    case CLOSE_PROJECT = 'close_project';
    case DELETE_PROJECT = 'delete_project';
    case MANAGE_MEMBERS = 'manage_members';

    public function string(): string
    {
        return match($this){
            Permissions::EDIT_PROJECT   => __('Edit Project'),
            Permissions::CLOSE_PROJECT  => __('Close Project'),
            Permissions::DELETE_PROJECT => __('Delete Project'),
            Permissions::MANAGE_MEMBERS => __('Manage Members'),
        };
    }

}
