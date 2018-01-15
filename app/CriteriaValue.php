<?php
/**
 * CriteriaValue Model
 * 
 * Bastien Nicoud
 * v0.0.1
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class CriteriaValue extends Model
{
    // Define a custom table name (this table dont use the laravel naming conventions)
    protected $table = 'criteriaValues';

    public $timestamps = false;

    /**
     * Authorize mass asignement columns
     *
     * @var array
     */
    protected $fillable = ['evaluation_id', 'criteria_id', 'points', 'studentComments', 'managerComments', 'contextSpecifics'];

    /**
     * Relation with the Criteria model
     */
    public function criteria()
    {
        return $this->belongsTo('App\Criteria');
    }

    /**
     * Relation with the Evaluation model
     */
    public function evaluation()
    {
        return $this->belongsTo('App\Evaluation');
    }
}
