<?php

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
        return $this->belongsTo('App\EvaluationSection');
    }

    /**
     * Relation with the CriteriaValue model
     */
    public function criteriaValues()
    {
        return $this->hasMany('App\CriteriaValue');
    }
}
