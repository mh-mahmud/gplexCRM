<?php
namespace App\Services;

use App\Helpers\Helper;
use App\Models\Logs;

class LogService
{
    public function getLogList($request)
    {
        return Logs::join('users', 'users.id', '=', 'logs.user_id')
                    ->leftJoin('leads', 'leads.id', '=', 'logs.lead_id')
                    ->select('logs.*', 'users.first_name', 'users.last_name', 'leads.first_name as lead_first_name', 'leads.last_name as lead_last_name')
                    ->orderBy('id', 'DESC')
                    ->paginate(config('constants.ROW_PER_PAGE'));
        
    }
}
