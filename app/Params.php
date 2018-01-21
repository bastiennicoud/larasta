<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Params extends Model
{
    public $timestamps = false;
    
    //
    /**
     * Get the param from the name
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

    /**
     * Set the param if the name not already exists
     * @param name mixed value
     * @param valueText string value
     * @param valueInt int value
     * @param valueDate date value
     * 
     * @author Benjamin Delacombaz
     */
    public static function setParam($name, $valueText = null, $valueInt = null, $valueDate = null)
    {
        $params = new Params;
        $hasParam = false;
        $hasError = false;
        $error = null;
        // Test if not empty
        if(trim($name) != null)
        {
            // Test for duplicate datas
            if(Params::getParamByName($name) == null)
            {
                $params->paramName = $name;
            }
            else
            {
                // Error
                $hasError = true;
                $error = "Le nom du paramètre existe déjà.";
            }
        }
        else
        {
            // Error
            $hasError = true;
            $error = "Le nom du paramètre ne doit pas être vide.";
        }

        // Test if text value is not empty
        if(trim($valueText) != null)
        {
            $hasParam = true;
            $params->paramValueText = $valueText;
        }

        // Test if text value is not empty
        if(trim($valueInt) != null)
        {
            $hasParam = true;
            $params->paramValueInt = $valueInt;
        }

        // Test if date value is not empty
        if(trim($valueDate) != null)
        {
            $hasParam = true;
            $params->paramValueDate = $valueDate;
        }
        
        if(!$hasParam)
        {
            // Error
            $hasError = true;
            $error = "Au moins 1 paramètre doit être complété";
        }

        // Test if error
        if(!$hasError)
        {
            if($params->save())
            {
                return true;
            }
            else
            {
                // Error
                $error = "Une erreur est survenue lors de l'ajout du paramêtre";
                return $error;
            }
        }
        else
        {
            return $error;
        }
    }
}
