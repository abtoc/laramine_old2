<?php

namespace App\Rules;

use App\Models\Project;
use Illuminate\Contracts\Validation\Rule;

class ProjectPublicParentRule implements Rule
{
    /**
     * @var \App\Models\Project
     */
    private $parent;

    /**
     * Create a new rule instance.
     *
     * @param int;
     * @return void
     */
    public function __construct($parent_id)
    {
        $this->parent = Project::find($parent_id);
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
        if(is_null($this->parent) or (!$value)){
            return true;
        }
        return $this->parent->is_public;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Parents are not public.';
    }
}
