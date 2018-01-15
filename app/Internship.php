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
}
