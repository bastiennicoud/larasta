<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    public $timestamps = false;

    /**
     * Relation with the Evaluation model
     */
    public function visit()
    {
        return $this->hasMany('App\Evaluation');
    }
}
