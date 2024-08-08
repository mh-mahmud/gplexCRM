<?php


namespace App\Helpers;
use App\Models\Logs;
use Illuminate\Support\Facades\Auth;

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

    public static function storeLog($log_text, $module_name, $action)
    {
        $log                = new Logs();
        $log->user_id       = Auth::id();
        $log->log_message   = $log_text." ".$module_name." ".$action;
        $log->status        = 1;
        $log->save();
    }
}