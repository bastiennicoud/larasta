<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persons extends Model
{
    public $timestamps = false;

    /**
     * Relation to the internship of the student
     */
    public function internships()
    {
        return $this->hasMany('App\Internship', 'intern_id');
    }

    /**
     * Relation to the flock of the student
     */
    public function flock()
    {
        return $this->belongsTo('App\Flock', 'flock_id');
    }


    public function getRoleAttribute()
    {
        if (empty($this->company_id)) {
            return 'Eleve';
        } else {
            return 'Company';
        }
    }

    /**
     * Computed property to recompose full name
     */
    public function getFullNameAttribute()
    {
        return "{$this->firstname} {$this->lastname}";
    }
}
