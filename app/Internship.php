<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
    public $timestamps = false;

    /**
     * Relation with the vilit model
     */
    public function visit()
    {
        return $this->hasMany('App\Visit');
    }

    /**
     * Relation to retrive the companies
     */
    public function companie()
    {
        return $this->belongsTo('App\Companies');
    }

    /**
     * Relation to retrive the student
     */
    public function student()
    {
        return $this->belongsTo('App\Persons', 'intern_id');
    }

    /**
     * Relation to retrive the teacher
     */
    public function teacher()
    {
        return $this->belongsTo('App\Persons', 'responsible_id');
    }

    /**
     * Relation to retrive the internship master
     */
    public function intern()
    {
        return $this->belongsTo('App\Persons', 'responsible_id');
    }
}
