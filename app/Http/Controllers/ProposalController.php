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
        $leads = $this->proposalService->getLeadsData();

        return view('proposals.add-proposal', compact('countries', 'currencies', 'leads'));
    }

    public function saveProposal(Request $request) {

        $request->validate([
            'subject' => 'required|string|max:191',
            'lead_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'currency' => 'required',
            'status' => 'required',
            'send_to' => 'required|email',
            'price' => 'required|numeric',
            'offer_price' => 'required|numeric',
            'item_name' => 'required|string|max:191',
            'item_description' => 'required|string',
            'upload_file' => 'file|mimes:xlsx,xls,pdf,docx,txt|max:1024',
        ]);

        $entry = $this->proposalService->save_proposal($request);
        return redirect()->route('proposal-list')->with('success', 'Proposal created successfully.');

        // dd($request->all());
    }
    

}