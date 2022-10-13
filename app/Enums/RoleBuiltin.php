<?php

namespace App\Enums;

enum RoleBuiltin : int
{
    case OTHER      = 0;
    case NON_MEMBER = 1;
    case ANONYMOUS  = 2;

    public function string(): string
    {
        return match($this){
            RoleBuiltin::OTHER      => __('Other Role'),
            RoleBuiltin::NON_MEMBER => __('Active'),
            RoleBuiltin::ANONYMOUS  => __('Registerd'),
        };
    }
}
