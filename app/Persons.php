<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persons extends Model
{
    public $timestamps = false;


    public function getRoleAttribute()
    {
        if (empty($this->company_id)) {
            return 'Eleve';
        } else {
            return 'Company';
        }
    }

    //
}
