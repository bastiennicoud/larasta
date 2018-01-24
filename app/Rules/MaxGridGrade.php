<?php
/**
 * MaxGridGrade
 * 
 * This class contains custom validation rule for the grade field in the evaluation grid
 * He check the max value accepted in the field
 * 
 * Bastien Nicoud
 * v1.0.0
 */

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\CriteriaValue;

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
     * He check the max point field in the criteria asociated to the criteriaValue to validate
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $criteriaValueId = str_before($attribute, '.');
        
        if($value > CriteriaValue::find($criteriaValueId)->criteria->maxPoints) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'La note renseignée est trop grande.';
    }
}
