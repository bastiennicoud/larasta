<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CriteriaValue extends Model
{
    public $timestamps = false;

    /**
     * Relation with the Criteria model
     */
    public function criteria()
    {
        return $this->hasOne('App\Criteria');
    }

    /**
     * Relation with the Evaluation model
     */
    public function evaluation()
    {
        return $this->hasOne('App\Evaluation');
    }
}
