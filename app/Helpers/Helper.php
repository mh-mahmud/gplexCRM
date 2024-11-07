<?php


namespace App\Helpers;
use App\Models\Logs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
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

    public static function storeLog($log_text, $module_name, $sub_module_name, $action=null, $lead_id=null, $user_id = null)
    {
        $log                    = new Logs();
        $log->user_id           = $user_id ?? Auth::id();
        $log->lead_id           = $lead_id;
        $log->module            = $module_name;
        $log->sub_module        = $sub_module_name;
        // $log->log_message       = $log_text." => ".$module_name." => ".$action;
        $log->log_message       = $log_text;
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

    public static function getLeads() 
    {
        if (Auth::user()->user_type === 'admin') {
            return DB::table('leads')
                    ->select('id', 'first_name', 'last_name', 'email', 'phone')
                    ->where('lead_status', 1)
                    ->get();
        } else {
            return DB::table('leads')
                    ->select('id', 'first_name', 'last_name', 'email', 'phone')
                    ->where('lead_status', 1)
                    ->where('created_by', Auth::user()->id)
                    ->get();
        }

    }

    /**
     * If date is valid then return ture otherwise false
     * @return Bool
     */
    public static function isDateValid($date, $format)
    {
        $validator = Validator::make(['date' => $date], ['date' => "date|date_format:{$format}"]);
        return !$validator->fails();
    }

    public static function isDateRangeValid($startDate, $endDate):bool{
        if(strtotime($startDate) > strtotime($endDate)){// Start date is after end date
            return false;
        }
        $startDate  = Carbon::parse($startDate);
        $endDate    = Carbon::parse($endDate);
        return config('constants.MAX_REPORT_DAYS') >= $startDate->diffInDays($endDate);
    }

}