<?php


namespace App\Helpers;
use App\Models\Logs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public static function storeLog($log_text, $module_name, $sub_module_name, $action)
    {
        $log                    = new Logs();
        $log->user_id           = Auth::id();
        $log->module_name       = $module_name;
        $log->sub_module_name   = $sub_module_name;
        $log->log_message       = $log_text." ".$module_name." ".$action;
        $log->status            = 1;
        $log->save();
    }



    public static function getEnumValues($table, $column)
    {
        $query = "SHOW COLUMNS FROM `{$table}` WHERE Field = '{$column}'";
        $result = DB::select($query);
        if (!empty($result)) {
            $type = $result[0]->Type;
            // Use regex to extract the enum values
            preg_match('/^enum\((.*)\)$/', $type, $matches);
            if (isset($matches[1])) {
                $enum = array_map(function ($value) {
                    return trim($value, "'");
                }, explode(',', $matches[1]));
                return $enum;
            }
        }
        return [];
    }

}