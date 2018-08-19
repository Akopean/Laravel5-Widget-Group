<?php

namespace Akopean\widgets\Rules;

use Illuminate\Contracts\Validation\Rule;

class ExistsGroup implements Rule
{
    protected $group;

    public function __construct()
    {
        $this->group = array_merge(config('widgets.group'), config('widgets.inactive_group'));
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
        return array_key_exists($value,$this->group);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This group not exists.';
    }
}
