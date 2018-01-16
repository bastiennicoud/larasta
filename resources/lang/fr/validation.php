<?php 

/**
 * French traduction of the validation messages and values used in the app
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'max' => [
        'string'  => 'Les :attribute peuvent faire :max caractères maximum.'
    ],
    'required' => 'Le :attribute est requis.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        '*.specs' => 'spécifications',
        '*.mComm' => 'commentaire du responsable de stage',
        '*.sComm' => 'commentaires du stagiaire',
        '*.grade' => 'note',
        'submit' => 'type d\'enregistrement'
    ]

];