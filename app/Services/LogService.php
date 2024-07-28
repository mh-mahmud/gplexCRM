<?php
namespace App\Services;

use App\Helpers\Helper;
use App\Models\Logs;

class LogService
{
    public function getLogList($request)
    {
        return Logs::orderBy('id', 'DESC')->paginate(config('constants.ROW_PER_PAGE'));
        
    }
}
