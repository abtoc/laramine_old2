<?php

namespace App\Enums;

enum UserType : string
{
    case USER             = 'User';
    case GROUP            = 'Group';
    case GROUP_ANONYMOUS  = 'GroupAnonymous';
    case GROUP_NON_MEMBER = 'GroupNonMember';
    case ANONYMOUS_USER   = 'AnonymousUser';

    public function string(): string
    {
        return match($this){
            UserType::USER             => __('User'),
            UserType::GROUP            => __('Group'),
            UserType::GROUP_ANONYMOUS  => __('Anonymous users'),
            UserType::GROUP_NON_MEMBER => __('Non member users'),
            UserType::ANONYMOUS_USER   => __('Anonymous')
        };
    }
}