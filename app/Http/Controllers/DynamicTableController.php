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
use App\Models\LeadFormDetail;
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
            return redirect()->route('dynamictable-index')->with('error', $result);
        }

        return redirect()->route('dynamictable-index')->with('success','Dynamic Table created successfully.');
    }

    public function show($tableName)
    {
        $dynamicTableDetails = $this->dynamicTableService->getDetailsByTableName($tableName);
        return view('dynamic_table.show', compact('dynamicTableDetails', 'tableName'));
    }

    public function edit($id)
    {
        $tableDetails = LeadFormDetail::where('table_name', $id)->get();
        if (!$tableDetails) {
            return redirect()->route('dynamictable-index')->with('error', 'Table not found.');
        }
    
        $formName = LeadsForm::pluck('form_name', 'form_id');
    
        return view('dynamic_table.edit', compact('tableDetails', 'formName'));
    }
    
    public function update(Request $request, $id)
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
    
        // service to update the table and insert data
        $result = $this->dynamicTableService->updateTable($tableName, $formId, $fields, $id);
    
        if ($result === 'Table not found.') {
            return redirect()->route('dynamictable-index')->with('error', $result);
        }
    
        return redirect()->route('dynamictable-index')->with('success', 'Dynamic Table updated successfully.');
    }
    

    public function search(Request $request)
    {
        $searchTerm = trim($request->input('search'));

        if (empty($searchTerm)) {
            return redirect()->route('dynamictable-index')->with('error', 'Search Field cannot be blank.');
        }

        $request->validate([
            'search' => 'required|string',
        ]);

        $dynamicTables = $this->dynamicTableService->searchDynamicTable($request);
        return view('dynamic_table.index', compact('dynamicTables'));
    }


    public function destroy($id)
    {   
        //dd($id);
        $this->dynamicTableService->deleteDynamicTable($id);
        return redirect()->route('dynamictable-index')->with('success', 'Dynamic Table deleted successfully.');
    }

}