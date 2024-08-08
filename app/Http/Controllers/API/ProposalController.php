<?php
namespace App\Http\Controllers;
use App\Services\ProposalService;

use Illuminate\Http\Request;


class ProposalController extends Controller {
    protected $proposalService;

    public function __construct(ProposalService $proposalService)
    {
        $this->proposalService = $proposalService;
        $this->middleware('auth');
    }

    public function getLogList(Request $request)
    {      
        $logs = $this->proposalService->proposalList($request);
        return view('logs.log-list', compact('logs'));
    }

    

}