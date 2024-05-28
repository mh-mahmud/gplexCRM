<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\LeadsForm;
use App\Services\DynamicTableService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class DynamicTableController extends Controller
{
    protected $dynamicTableService;

    public function __construct(DynamicTableService $dynamicTableService)
    {
        $this->dynamicTableService = $dynamicTableService;
    }

    public function index()
    {
        $dynamicTables = $this->dynamicTableService->getAllDynamicTables();
        return view('dynamic_table.index', compact('dynamicTables'));
    }

    public function create()
    {   
        //$parents = LeadsForm::whereNull('parent_id')->pluck('form_name', 'form_id');
        $formName = LeadsForm::pluck('form_name', 'form_id');
        return view('dynamic_table.create', compact('formName'));
    }

    public function createTable(Request $request)
    {
        // Validate the request inputs
        $request->validate([
            'table_name' => 'required|string|max:255',
            'form_id' => 'required|string|max:10',
            'fields' => 'required|array',
            'fields.*.name' => 'required|string|max:255',
            'fields.*.type' => 'required|string|max:255',
            'fields.*.character_length' => 'nullable|integer',
            'fields.*.is_index' => 'nullable|boolean',
            'fields.*.is_null' => 'nullable|boolean',
            'fields.*.is_unique' => 'nullable|boolean',
        ]);

        $tableName = $request->input('table_name');
        $formId = $request->input('form_id');
        $fields = $request->input('fields');

        // service to create the table and insert data
        $result = $this->dynamicTableService->createTable($tableName, $formId, $fields);

        if ($result === 'Table already exists.') {
            return redirect()->route('dynamic_table.index')->with('error', $result);
        }

        return redirect()->route('dynamic_table.index')->with('success','Dynamic Table created successfully.');
    }

    public function show($tableName)
    {
        $dynamicTableDetails = $this->dynamicTableService->getDetailsByTableName($tableName);
        return view('dynamic_table.show', compact('dynamicTableDetails', 'tableName'));
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
            return redirect()->route('dynamic_table.index')->with('error', 'Search Field cannot be blank.');
        }

        $request->validate([
            'search' => 'required|string',
        ]);

        $dynamicTables = $this->dynamicTableService->searchDynamicTable($request);
        return view('dynamic_table.index', compact('dynamicTables'));
    }


    public function destroy($id)
    {
        $this->leadsFormService->deleteLeadsForm($id);
        return redirect()->route('leads_forms.index')->with('success', 'Leads Form deleted successfully.');
    }
}