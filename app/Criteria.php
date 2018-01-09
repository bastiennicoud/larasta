<?php
/**
 * Criteria Model
 * 
 * Bastien Nicoud
 * v0.0.1
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    public $timestamps = false;

    /**
     * Relation with the EvaluationSection model
     */
    public function evaluationSections()
    {
        return $this->belongsTo('App\EvaluationSection', 'evaluationSection_id');
    }

    /**
     * Relation with the CriteriaValue model
     */
    public function criteriaValues()
    {
        return $this->hasMany('App\CriteriaValue');
    }
}
