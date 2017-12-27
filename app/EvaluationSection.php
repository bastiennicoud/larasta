<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluationSection extends Model
{
    public $timestamps = false;

    /**
     * Relation with the Criteria model
     */
    public function criteria()
    {
        return $this->hasMany('App\Criteria');
    }
}
