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

    /**
     * editCriteriasValues
     * 
     * Save the criterias values
     * 
     * @param int $id The id of the criteria to edit
     * @param array $colums An array of key values for all the columns to edit
     */
    public static function editCriteriasValues ($id, $columns) {

        // Find the corresponding id and update is values
        // for each key in the array we check if exists, if not we choose a default value
        self::where('id', $id)->update([
            'points' => isset($columns['grade']) ? $columns['grade'] : 1,
            'studentComments' => isset($columns['sComm']) ? $columns['sComm'] : '',
            'managerComments' => isset($columns['mComm']) ? $columns['mComm'] : '',
            'contextSpecifics' => isset($columns['specs']) ? $columns['specs'] : ''
        ]);
    }
}
