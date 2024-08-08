<?php
namespace App\Http\Controllers;
use App\Services\LogService;

use Illuminate\Http\Request;


class LogController extends Controller {
    protected $logService;

    public function __construct(LogService $logService)
    {
        $this->logService = $logService;
        $this->middleware('auth');
    }

    public function getLogList(Request $request)
    {      
        $logs = $this->logService->getLogList($request);
        return view('log.logs', compact('logs'));
    }

}