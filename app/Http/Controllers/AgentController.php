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
use App\Models\Agent;
use App\Services\AgentService;

class AgentController extends Controller {

	// public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    protected $agentService;

    public function __construct(AgentService $agentService)
    {
        $this->agentService = $agentService;
        $this->middleware('auth');
    }

	public function index()
    {
        
        $agents = $this->agentService->getAllAgents();
        return view('agents.index', compact('agents'));
    }

	function create() {
		return view('agents.create');
	}

    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'password' => 'required|string',
            'profile_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
           
        ]);
       
        // If validation fails,return error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user = $this->agentService->create_agent($request);
        return redirect()->route('agents.index')->with('success', 'Agent created successfully.');
    }

   
    public function show($id)
    {
        $agentData = $this->agentService->getAgentWithUser($id);
        return view('agents.show', $agentData);
    }

   
    public function edit($id)
    {
        $agentData = $this->agentService->getAgentEditData($id);
        return view('agents.edit', $agentData);
    }


    public function update(Request $request, $id)
    {
        
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'profile_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

       
        $this->agentService->updateAgent($request, $id);
        return redirect()->route('agents.index')->with('success', 'Agent updated successfully.');
    }

  

    public function search(Request $request)
    {
        $request->validate([
            'search' => 'required|string',
        ]);

        $agents = $this->agentService->searchAgents($request);
        return view('agents.index', compact('agents'));
    }




    public function destroy($id)
    {
        try {
            $this->agentService->deleteAgentAndUser($id);
            return redirect()->route('agents.index')->with('success', 'Agent deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete agent.');
        }
    }


}

