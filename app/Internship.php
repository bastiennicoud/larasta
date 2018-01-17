<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
    public $timestamps = false;

    /**
     * Eloquent will automaticaly convert this colums of the model in Carbon dates
     */
    protected $dates = ['beginDate', 'endDate'];

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
        return $this->belongsTo('App\Companies', 'companies_id');
    }

    /**
     * Relation to retrive the student
     */
    public function student()
    {
        return $this->belongsTo('App\Persons', 'intern_id');
    }

    /**
     * Relation to retrive the internship master
     */
    public function responsible()
    {
        return $this->belongsTo('App\Persons', 'responsible_id');
    }
}
