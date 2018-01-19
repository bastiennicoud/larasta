<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Params extends Model
{
    public $timestamps = false;
    
    //
    /**
     * Get the the param from the name
     * @param name mixed value
     * 
     * @author Benjamin Delacombaz
     */
    public static function getParamByName($name)
    {
        $params = Params::where('paramName', $name)
        ->first();
        return $params;
    }
}
