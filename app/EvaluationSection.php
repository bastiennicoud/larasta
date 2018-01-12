<?php
/**
 * EvaluationSection Model
 * 
 * Bastien Nicoud
 * v0.0.1
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluationSection extends Model
{
    public $timestamps = false;

    // Define a custom table name (this table dont use the laravel naming conventions)
    protected $table = 'evaluationSections';

    /**
     * Relation with the Criteria model
     */
    public function criterias()
    {
        return $this->hasMany('App\Criteria', 'evaluationSection_id');
    }
}
