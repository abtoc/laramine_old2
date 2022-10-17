<?php

namespace App\Enums;

enum Permissions : string
{
    case EDIT_PROJECT = 'edit_project';
    case CLOSE_PROJECT = 'close_project';
    case DELETE_PROJECT = 'delete_project';
    case MANAGE_MEMBERS = 'manage_members';
    case ADD_SUBPROJECTS = 'add_subprojects';

    case VIEW_ISSUE = 'view_issue';
    case ADD_ISSUE = 'add_issue';
    case EDIT_ISSUE = 'edit_issue';
    case EDIT_OWN_ISSUE = 'edit_own_issue';
    case COPY_ISSUE = 'cope_issue';
    case MANAGE_ISSUE_RELATIONS = 'manage_issue_relations';
    case MANAGE_SUBTASKS = 'manage_subtasks';
    case SET_ISSUES_PRIVATE = 'set_issues_private';
    case SET_OWN_ISSUES_PRIVATE = 'set_own_issues_private';


    public function string(): string
    {
        return match($this){
            Permissions::EDIT_PROJECT   => __('Edit Project'),
            Permissions::CLOSE_PROJECT  => __('Close Project'),
            Permissions::DELETE_PROJECT => __('Delete Project'),
            Permissions::MANAGE_MEMBERS => __('Manage Members'),
            Permissions::ADD_SUBPROJECTS => __('Add Subprojects'),

            Permissions::VIEW_ISSUE => __('View Ticket'),
            Permissions::ADD_ISSUE => __('Add Ticket'),
            Permissions::EDIT_ISSUE => __('Edit Ticket'),
            Permissions::EDIT_OWN_ISSUE => __('Edit Own Ticket'),
            Permissions::COPY_ISSUE => __('Copy Ticket'),
            Permissions::MANAGE_ISSUE_RELATIONS => __('Manage Ticket Reloations'),
            Permissions::MANAGE_SUBTASKS => __('Manage Sub Ticket'),
            Permissions::SET_ISSUES_PRIVATE => __('Set Ticket Private'),
            Permissions::SET_OWN_ISSUES_PRIVATE => __('Set Own Ticket Private'),

        };
    }

}
