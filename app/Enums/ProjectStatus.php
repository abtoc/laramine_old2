<?php

namespace App\Enums;

enum ProjectStatus : int
{
    case NONE      = 0;
    case ACTIVE    = 1;
    case CLOSED    = 5;
    case ARCHIVE   = 9;

    public function string(): string
    {
        return match($this){
            ProjectStatus::NONE    => __('All Project'),
            ProjectStatus::ACTIVE  => __('Active'),
            ProjectStatus::CLOSED  => __('Closed'),
            ProjectStatus::ARCHIVE => __('Archive'),
        };
    }
}
