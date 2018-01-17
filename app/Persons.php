<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use CPNVEnvironment\Environment;

class Persons extends Model
{
    //use SoftDeletes;

    //protected $dates = ['deleted_at'];

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

    /**
     * getRoleAttribute
     * 
     * @return string eleve|company
     */

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
     * 
     * @return string The full name
     */
    public function getFullNameAttribute()
    {
        return "{$this->firstname} {$this->lastname}";
    }
}
