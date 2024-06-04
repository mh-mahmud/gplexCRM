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
use App\Models\LeadsForm;
use App\Models\Lead;
use App\Services\LeadService;

class LeadController  extends Controller
{
    protected $leadService;

    public function __construct(LeadService  $leadService)
    {
        $this->leadService = $leadService;
    }

    
    public function index()
    {
        $leads = $this->leadService->getAllLeads();
        return view('leads.index', compact('leads'));
    }

    public function create()
    {   
        $formName = LeadsForm::pluck('form_name', 'form_id');
        return view('leads.create', compact('formName'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'title' => 'required|string|max:191',
            'email' => 'nullable|string|email|max:191|unique:leads,email',
            'phone' => 'required|string|max:191',
            
        ]);

        $data = $request->all();
        $this->leadService->createLead($data);

        return redirect()->route('lead-index')->with('success', 'Lead created successfully.');
    }

    public function show($id)
    {
        $lead = $this->leadService->getLeadById($id);
        return view('leads.show', compact('lead'));
    }

    public function edit($id)
    {   
        $formName = LeadsForm::pluck('form_name', 'form_id');
        $lead = $this->leadService->getLeadById($id);
        return view('leads.edit', compact('lead','formName'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'title' => 'required|string|max:191',
            'email' => 'nullable|string|email|max:191|unique:leads,email,' . $id,
            'phone' => 'required|string|max:191',
           
        ]);

        $data = $request->all();
        $this->leadService->updateLead($id, $data);

        return redirect()->route('lead-index')->with('success', 'Lead updated successfully.');
    }

    public function search(Request $request)
    {
        $searchTerm = trim($request->input('search'));

        if (empty($searchTerm)) {
            return redirect()->route('lead-index')->with('error', 'Search Field cannot be blank.');
        }

        $request->validate([
            'search' => 'required|string',
        ]);

        $leads = $this->leadService->searchLeadForm($request);
        return view('leads.index', compact('leads'));
    }

    public function destroy($id)
    {
        $this->leadService->deleteLead($id);
        return redirect()->route('lead-index')->with('success', 'Lead deleted successfully.');
    }
    
}