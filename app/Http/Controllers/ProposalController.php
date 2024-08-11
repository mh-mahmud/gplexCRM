<?php
namespace App\Http\Controllers;
use App\Services\ProposalService;
use App\Services\CountryService;
use App\Services\CurrencyService;

use Illuminate\Http\Request;


class ProposalController extends Controller {
    protected $proposalService;
    protected $countryService;
    protected $currencyService;

    public function __construct(ProposalService $proposalService, CountryService $countryService, CurrencyService $currencyService)
    {
        $this->proposalService = $proposalService;
        $this->countryService  = $countryService;
        $this->currencyService  = $currencyService;

        $this->middleware('auth');
    }

    public function proposalList(Request $request)
    {      
        $proposals = $this->proposalService->proposalList($request);
        return view('proposals.proposal-list', compact('proposals'));
    }

    public function addProposal(Request $request)
    {      
        $countries = $this->countryService->countryList($request);
        $currencies = $this->currencyService->currencyList($request);
        return view('proposals.add-proposal', compact('countries', 'currencies'));
    }
    

}