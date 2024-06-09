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
use App\Models\LeadFormDetail;
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
        $formName = LeadsForm::pluck('form_name', 'form_id');
        return view('leads.index', compact('leads','formName'));
    }

    public function create_backup()
    {   
        
        return view('leads.create');
    }

    public function create(Request $request)
    {
        $formName = [
            1 => 'Form A',
            2 => 'Form B',
            // Add more form names and IDs as needed
        ];

        $fieldsByTable = [];

        if ($request->has('form_id')) {
            $formId = $request->input('form_id');
            $fields = LeadFormDetail::where('form_id', $formId)->get();

            foreach ($fields as $field) {
                $fieldsByTable[$field->table_name][] = $field;
            }
        }

        return view('leads.create', compact('formName', 'fieldsByTable'));
    }

    

    public function store_backup(Request $request)
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

    public function store(Request $request)
    {  
       
        $request->validate([
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'title' => 'required|string|max:191',
            'email' => 'nullable|string|email|max:191|unique:leads,email',
            'phone' => 'required|string|max:191',
            'form_id' => 'required|exists:leads_form,form_id',
        ]);
        //dd($request);die();

        //$data = $request->only(['first_name', 'last_name', 'title', 'email', 'phone', 'lead_status','form_id']);
        $data = $request->all();
        
        $dynamicFields = $request->except(['first_name', 'last_name', 'title', 'email', 'phone', 'form_id', '_token']);
        //dd($dynamicFields);die();
        
        

        $this->leadService->createLead($data, $request->input('form_id'), $dynamicFields);

        return redirect()->route('lead-index')->with('success', 'Lead created successfully.');
    }


    public function show_backup($id)
    {
        $lead = $this->leadService->getLeadById($id);
        return view('leads.show', compact('lead'));
    }

    public function show($id)
    {
        $lead = $this->leadService->getLeadById($id);

        // Fetch dynamic fields data based on lead_id
        $fields = LeadFormDetail::where('form_id', $lead->form_id)->get();
        $tableData = [];
        foreach ($fields as $field) {
            $tableName = $field->table_name;
            $tableData[$tableName] = DB::table($tableName)->where('lead_id', $lead->id)->first();
        }

        return view('leads.show', compact('lead', 'tableData'));
    }

    

    public function edit_backup($id)
    {   
        $formName = LeadsForm::pluck('form_name', 'form_id');
        $lead = $this->leadService->getLeadById($id);
        return view('leads.edit', compact('lead','formName'));
    }

    public function edit($id)
    {
        $formName = LeadsForm::pluck('form_name', 'form_id');
        $lead = $this->leadService->getLeadById($id);
        $fieldsByTable = [];
        $tableData = [];
    
        if ($lead->form_id) {
            $formId = $lead->form_id;
            $fields = LeadFormDetail::where('form_id', $formId)->get();
    
            foreach ($fields as $field) {
                $fieldsByTable[$field->table_name][] = $field;
    
                // specific table based on lead_id
                if (!isset($tableData[$field->table_name])) {
                    $tableData[$field->table_name] = DB::table($field->table_name)->where('lead_id', $lead->id)->first();
                }
            }
        }
    
        return view('leads.edit', compact('lead', 'formName', 'fieldsByTable', 'tableData'));
    }
    

    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'title' => 'required|string|max:191',
            'email' => 'nullable|string|email|max:191|unique:leads,email,' . $id,
            'phone' => 'required|string|max:191',
            'form_id' => 'required|exists:leads_form,form_id',
        ]);

        $data = $request->all();
        $dynamicFields = $request->except(['first_name', 'last_name', 'title', 'email', 'phone', 'form_id', '_token']);

        $this->leadService->updateLead($id, $data, $request->input('form_id'), $dynamicFields);

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