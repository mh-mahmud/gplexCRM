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
    protected $dynamicTableServiceService;

    public function __construct(DynamicTableService $dynamicTableServiceService)
    {
        $this->dynamicTableServiceService = $dynamicTableServiceService;
    }

    public function index()
    {
        $leadsForms = $this->dynamicTableServiceService->getAllLeadsForms();
        return view('leads_forms.index', compact('leadsForms'));
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
      // Check table already exists in the schema
      if (Schema::hasTable($tableName)) {
        return redirect()->back()->with('error', 'Table already exists.');
      }
  
      // Create the table if it doesn't exist
      if (!Schema::hasTable($tableName)) {
          Schema::create($tableName, function (Blueprint $table) use ($fields) {
              $table->id();
              $table->unsignedBigInteger('lead_id');
              $table->char('form_id', 10)->nullable(false);
              //$table->lead_id();
              foreach ($fields as $field) {
                  $type = $field['type'];
                  $name = $field['name'];
                  $length = $field['character_length'] ?? null;
  
                  if ($type === 'string' && $length) {
                      $column = $table->$type($name, $length)->nullable();
                  } else {
                      $column = $table->$type($name)->nullable();
                  }
  
                  if (isset($field['is_index']) && $field['is_index']) {
                      $table->index($name);
                  }
                  if (isset($field['is_unique']) && $field['is_unique']) {
                      $table->unique($name);
                  }
                  if (!isset($field['is_null']) || !$field['is_null']) {
                      $column->nullable(false);
                  }
              }
              $table->timestamps();
          });
      }
  
      // Prepare data for insertion
    $data = [];
    foreach ($fields as $field) {
        $data[] = [
            'form_id' => $formId,
            'field_name' => $field['name'],
            'field_value' => $field['type'],
            'character_length' => $field['character_length'] ?? null,
            'is_index' => $field['is_index'] ?? 0,
            'is_null' => $field['is_null'] ?? 0,
            'is_unique' => $field['is_unique'] ?? 0,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    // Insert data into the lead_form_details table
    DB::table('lead_form_details')->insert($data);
  
      return redirect()->back()->with('success', 'Data inserted successfully.');
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