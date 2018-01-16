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

    /**
     * Computed property to recompose full name
     */
    public function getFullNameAttribute()
    {
        return "{$this->firstname} {$this->lastname}";
    }
}
