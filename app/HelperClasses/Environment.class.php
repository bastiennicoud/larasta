<?php
/**
 * Created by PhpStorm.
 * User: Xavier
 * Date: 31.12.17
 * Time: 09:29
 */

namespace CPNVEnvironment;

class Environment
{
    // Lets you know if your code is running on the intranet or not
    static function isProd()
    {
        return (strpos(strtoupper(gethostname()), "-ITRA-") > 0);
    }

    // Lets you know who is the current user
    static function currentUser()
    {
        // fake values at this point
        $user = new IntranetUser();
        $user->setInitials("abc");
        $user->setLevel(2);
        return $user;
    }
}