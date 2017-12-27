<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    public $timestamps = false;

    /**
     * Relation with the CriteriaValue model
     */
    public function criteriaValue()
    {
        return $this->hasMany('App\CriteriaValue');
    }

    /**
     * Relation with the Visit model
     */
    public function visit()
    {
        return $this->hasOne('App\Visit');
    }
}
