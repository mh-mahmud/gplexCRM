<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Campaign;
use App\Services\CampaignService;
use App\Models\Promotion;

class CampaignController extends Controller
{
    protected $campaignService;

    public function __construct(CampaignService $campaignService)
    {
        $this->campaignService = $campaignService;
    }

    public function index()
    {
        $campaigns = $this->campaignService->getAllCampaign();
        //dd($campaigns);die();
        return view('campaigns.index', compact('campaigns'));
    }

    public function create()
    {

        $promotions = Promotion::pluck('promotion_title', 'id');
        return view('campaigns.create', compact('promotions'));
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'campaign_title' => 'required',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);
       
        $this->campaignService->createCampaign($request->all());

        return redirect()->route('campaign-index')->with('success', 'Campaign created successfully.');
    }

    public function show($id)
    {
        $campaign = $this->campaignService->getCampaignByPromotionName($id);
        return view('campaigns.show', compact('campaign'));
    }

    public function edit($id)
    {
        $campaign = $this->campaignService->getCampaignById($id);
        $promotions = Promotion::pluck('promotion_title', 'id');
        return view('campaigns.edit', compact('campaign','promotions'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'campaign_title' => 'required',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $data = $request->all();
        $this->campaignService->updateCampaign($id, $data);

        return redirect()->route('campaign-index')->with('success', 'Campaign updated successfully.');
    }

    public function search(Request $request)
    {
        $searchTerm = trim($request->input('search'));

        if (empty($searchTerm)) {
            return redirect()->route('campaign-index')->with('error', 'Search Field cannot be blank.');
        }

        $request->validate([
            'search' => 'required|string',
        ]);

        $campaigns = $this->campaignService->searchCampaign($request);
        return view('campaigns.index', compact('campaigns'));
    }


    public function destroy($id)
    {
        $this->campaignService->deleteCampaign($id);
        return redirect()->route('campaign-index')->with('success', 'Campaign deleted successfully.');
    }
}