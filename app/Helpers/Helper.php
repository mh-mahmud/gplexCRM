<?php


namespace App\Helpers;

use Auth;

class Helper
{
    public static function generateTableId() 
    {
        $microtime = explode(' ', microtime());
        $genaratedId = (int)round($microtime[0] * 1000000) + $microtime[1];
        return $genaratedId.rand(1000, 9999);
    }
    public static function slugify($value)
    {

        return strtolower(preg_replace("/[^a-zA-Z0-9]+/", "-", $value));

    }
}