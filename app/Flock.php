<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flock extends Model
{
    
    /**
     * Relation with the students
     */
    public function students ()
    {
        return $this->hasMany('App\Persons', 'flock_id');
    }

    /**
     * Relation to get the class teacher
     */
    public function classMaster ()
    {
        return $this->belongsTo('App\Persons', 'classMaster_id');
    }
}
