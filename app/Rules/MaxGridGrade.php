<?php
/**
 * MaxGridGrade
 * 
 * This class contains custom validation code for the grade field in the evaluation grid
 * 
 * Bastien Nicoud
 * v1.0.0
 */

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MaxGridGrade implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        //
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
