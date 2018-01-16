<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    public $timestamps = false;

    /**
     * Relation with the Evaluation model
     */
    public function evaluation()
    {
        return $this->hasMany('App\Evaluation');
    }

    /**
     * Relation with the internships model
     */
    public function internship()
    {
        return $this->belongsTo('App\Internship', 'internships_id');
    }
}
