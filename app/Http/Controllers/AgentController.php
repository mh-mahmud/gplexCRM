<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Agent;

class AgentController extends Controller {

	public function __construct()
    {
        $this->middleware('auth');
    }

	public function index()
    {
        $agents = Agent::all();
        return view('agents.index', compact('agents'));
    }

	function create() {
		return view('agents.create');
	}

    public function store(Request $request)
    {
        
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string',
            'password' => 'required|string',
            'profile_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
       
        if ($request->hasFile('profile_image')) {
            $fileNameWithExt = $request->file('profile_image')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('profile_image')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            $path = $request->file('profile_image')->move(public_path().'/uploads/agents', $fileNameToStore);
            
        } else {
            
            $fileNameToStore = 'noimage.jpg';
        }
        $user = User::create([
            'email' => $request->email,
            'name' => $request->name,
            'user_type' =>'agent',
            'password' => bcrypt($request->password),
        ]);
        $agent_id = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        $agent = new Agent([
            'agent_id' => $agent_id,
            'name' => $request->name,
            'gender' => $request->gender,
            'birth_day' => $request->birth_day,
            'phone_number' => $request->phone_number,
            'status' => $request->status,
            'profile_image' => $fileNameToStore,
            'address' => $request->address,
            'description' => $request->description,
        ]);
        $user->agent()->save($agent);
        return redirect()->route('agents.index')->with('success', 'Agent created successfully.');
    }

    public function show($id)
    {
        $agent = Agent::findOrFail($id);
        return view('agents.show', compact('agent'));
    }

    public function edit($id)
    {
        $agent = Agent::findOrFail($id);
        $user = User::findOrFail($agent->user_id);
        return view('agents.edit', compact('agent', 'user'));
    }


    public function update(Request $request, $id)
    {
        
        $request->validate([
            'name' => 'required|string',
            //'email' => 'required|email|unique:users,email,'.$id,
            //'password' => 'required|string',
            'profile_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Find the user by ID
        $agent = Agent::findOrFail($id);
        $user = User::findOrFail($agent->user_id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->user_type ='agent';
        $user->password = bcrypt($request->password);
        $user->save();
        $agent = $user->agent;
        $agent->name = $request->name;
        $agent->gender = $request->gender;
        $agent->birth_day = $request->birth_day;
        $agent->phone_number = $request->phone_number;
        $agent->status = $request->status;
        $agent->address = $request->address;
        $agent->description = $request->description;
        if ($request->hasFile('profile_image')) {
        // Delete the previous profile image
        if ($agent->profile_image) {
            $previousImagePath = public_path().'/uploads/agents/'.$agent->profile_image;
            if (file_exists($previousImagePath)) {
                unlink($previousImagePath);
            }
        }
            $fileNameWithExt = $request->file('profile_image')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('profile_image')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            $path = $request->file('profile_image')->move(public_path().'/uploads/agents', $fileNameToStore);
            $agent->profile_image = $fileNameToStore;
        }

        // Save the updated agent
        $agent->save();

        return redirect()->route('agents.index')->with('success', 'Agent updated successfully.');
    }


    public function destroy($id)
    {
        try {
            // Find the agent by ID
            $agent = Agent::findOrFail($id);
            $user = $agent->user;
            // Delete the profile image file if it exists
            if ($agent->profile_image) {
                $imagePath = public_path().'/uploads/agents/'.$agent->profile_image;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            $agent->delete();
            $user->delete();

            return redirect()->route('agents.index')->with('success', 'Agent deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete agent.');
        }
    }


}

