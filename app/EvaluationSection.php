<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluationSection extends Model
{
    public $timestamps = false;
    
    public $table = 'evaluationSections';

    /**
     * Relation with the Criteria model
     */
    public function criterias()
    {
        return $this->hasMany('App\Criteria');
    }
}
