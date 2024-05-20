<?php

namespace App\Services;

use App\Models\User;
use App\Models\Agent;

class AgentService
{

    public function getAllAgents()
    {
        return Agent::paginate(config('constants.ROW_PER_PAGE'));
    }
    


    public function create_agent($request)
    {
        
        if ($request->hasFile('profile_image')) {
            $fileNameWithExt = $request->file('profile_image')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('profile_image')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            $path = $request->file('profile_image')->move(public_path().'/uploads/agents', $fileNameToStore);
            
        } else {
            
            $fileNameToStore = '';
        }
        $user = User::create([
            'user_id' => str_pad(mt_rand(1, 9999999999999), 20),
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'profile_image' => $fileNameToStore,
            'user_type' =>'agent',
            'password' => bcrypt($request->password),
        ]);
        $agent_id = str_pad(mt_rand(1, 9999), 4);
        $agent = new Agent([
            'agent_id' => $agent_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'birth_day' => $request->birth_day,
            'phone_number' => $request->phone_number,
            'status' => $request->status,
            'address' => $request->address,
            'description' => $request->description,
        ]);

        
        $user->agent()->save($agent);

        return $user;
    }

    public function getAgentWithUser($id)
    {
        $agent = Agent::findOrFail($id);
        $user = $agent->user()->firstOrFail();
        
        return compact('agent', 'user');
    }

    public function getAgentEditData($id)
    {
        $agent = Agent::findOrFail($id);
        $user = $agent->user()->firstOrFail();
        
        return compact('agent', 'user');
    }


    public function updateAgent($request, $id)
    {
        // Find the user by id
        $agent = Agent::findOrFail($id);
        $user = User::findOrFail($agent->user_id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->user_type ='agent';
        $user->password = bcrypt($request->password);
        if ($request->hasFile('profile_image')) {
           
            if ($user->profile_image) {
                $previousImagePath = public_path().'/uploads/agents/'.$user->profile_image;
                if (file_exists($previousImagePath)) {
                    unlink($previousImagePath);
                }
            }
            $fileNameWithExt = $request->file('profile_image')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('profile_image')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            $path = $request->file('profile_image')->move(public_path().'/uploads/agents', $fileNameToStore);
            $user->profile_image = $fileNameToStore;
               
        }
        $user->save();
        $agent = $user->agent;
        $agent->first_name = $request->first_name;
        $agent->last_name = $request->last_name;
        $agent->gender = $request->gender;
        $agent->birth_day = $request->birth_day;
        $agent->phone_number = $request->phone_number;
        $agent->status = $request->status;
        $agent->address = $request->address;
        $agent->description = $request->description;
        

        // Save the agent
        $agent->save();
    }

    public function searchAgents($request)
    {
        $searchTerm = trim($request->input('search'));
        $query = Agent::query();

        $query->where(function($q) use ($searchTerm) {
            $q->where('agent_id', 'LIKE', '%' . $searchTerm . '%')
              ->orWhere('first_name', 'LIKE', '%' . $searchTerm . '%')
              ->orWhere('last_name', 'LIKE', '%' . $searchTerm . '%');
        });

        return $query->paginate(config('constants.ROW_PER_PAGE'));
    }

    public function deleteAgentAndUser($id)
    {
        $agent = Agent::findOrFail($id);
        $user = $agent->user;
        if ($user->profile_image) {
            $imagePath = public_path().'/uploads/agents/'.$user->profile_image;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        $agent->delete();
        $user->delete();
        if($user->delete()) {
            return true;
        }
        return false;
    }
}
