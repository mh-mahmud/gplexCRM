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
use App\Services\LeadsFormService;

class LeadsFormController extends Controller
{
    protected $leadsFormService;

    public function __construct(LeadsFormService $leadsFormService)
    {
        $this->leadsFormService = $leadsFormService;
    }

    public function index()
    {
        $leadsForms = $this->leadsFormService->getAllLeadsForms();
        return view('leads_forms.index', compact('leadsForms'));
    }

    public function create()
    {   
        $parents = LeadsForm::whereNull('parent_id')->pluck('form_name', 'form_id');
        return view('leads_forms.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'form_id' => 'nullable|string|max:10',
            'parent_id' => 'nullable|string|max:10',
            'form_name' => 'required|string|max:191',
            'form_description' => 'nullable|string',
           
        ]);
        //dd($request);die();

        $this->leadsFormService->createLeadsForm($request->all());

        return redirect()->route('leads_forms.index')->with('success', 'Leads Form created successfully.');
    }

    public function show($id)
    {
        $leadsForm = $this->leadsFormService->getLeadsFormParentName($id);
        return view('leads_forms.show', compact('leadsForm'));
    }

    public function edit($id)
    {
        $leadsForm = $this->leadsFormService->getLeadsFormById($id);
        $parents = LeadsForm::whereNull('parent_id')->pluck('form_name', 'form_id');
        return view('leads_forms.edit', compact('leadsForm','parents'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'form_id' => 'nullable|string|max:10',
            'parent_id' => 'nullable|string|max:10',
            'form_name' => 'required|string|max:191',
            'form_description' => 'nullable|string',
            'form_status' => 'required|integer',
        ]);

        $this->leadsFormService->updateLeadsForm($id, $request->all());

        return redirect()->route('leads_forms.index')->with('success', 'Leads Form updated successfully.');
    }

    public function search(Request $request)
    {
        $searchTerm = trim($request->input('search'));

        if (empty($searchTerm)) {
            return redirect()->route('leads_forms.index')->with('error', 'Search Field cannot be blank.');
        }

        $request->validate([
            'search' => 'required|string',
        ]);

        $leadsForms = $this->leadsFormService->searchLeadForm($request);
        return view('leads_forms.index', compact('leadsForms'));
    }


    public function destroy($id)
    {
        $this->leadsFormService->deleteLeadsForm($id);
        return redirect()->route('leads_forms.index')->with('success', 'Leads Form deleted successfully.');
    }
}