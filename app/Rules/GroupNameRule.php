<?php

namespace App\Rules;

use App\Enums\UserType;
use App\Models\Group;
use Illuminate\Contracts\Validation\Rule;

class GroupNameRule implements Rule
{
    /**
     *
     * @var Group
     */
    private $group;

    /**
     * Create a new rule instance.
     *
     * @param Group|null $group
     * @return void
     */
    public function __construct(Group $group=null)
    {
        $this->group = $group;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if(is_null($this->group)){
            return !Group::where('type', '<>', UserType::USER)->whereName($value)->exists();
        }
        if($this->group->name === $value){
            return true;
        }
        return !Group::where('type', '<>', UserType::USER)->whereName($value)->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.unique');
    }
}
