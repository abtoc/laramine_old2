<?php

namespace App\Enums;

enum UserStatus : int
{
    case NONE      = 0;
    case ACTIVE    = 1;
    case REGISTERD = 2;
    case LOCKED    = 3;

    public function string(): string
    {
        return match($this){
            UserStatus::NONE      => __('None'),
            UserStatus::ACTIVE    => __('Active'),
            UserStatus::REGISTERD => __('Registerd'),
            UserStatus::LOCKED    => __('Locked'),
        };
    }
}
