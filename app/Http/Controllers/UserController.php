<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Agent;
use Auth;

class UserController extends Controller
{
    protected $service;
    public function __construct(UserService $service) {
    	$this->service = $service;
    }

    public function index() {
    	$data = [];
    	// dd(Auth::user()->get_menu_data());
    	$data['users'] = $this->service->get_all_user();
    	$data['role_names'] = $this->service->get_all_role_name();
    	return view('users.user_list', $data);
    }

    public function create() {
    	$data = [];
    	$data['role_list'] = $this->service->get_all_role();
    	return view('users.create_user', $data);
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string'
        ]);
       
        $user = $this->service->create_user($request);
        if(!empty($user->id)) {
        	return redirect()->to('user-list')->with('success', 'User created successfully.');
        }
        return redirect()->route('create-user')->with('error', 'Failed request');
    }

    public function edit_form($id) {
    	$data = [];
    	$data['role_list'] = $this->service->get_all_role();
    	$data['user_data'] = $this->service->show_user($id);
    	return view('users.edit', $data);
    }

    public function update(Request $request) {
    	// dd($request->all());
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $request->id,
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'username' => 'required|string|unique:users,username,' . $request->id
           
        ]);
       
        $user = $this->service->edit_user($request);
        if($user) {
        	return redirect()->to('user-list')->with('success', 'User edited successfully.');
        }
        return redirect()->back()->with('error', 'Failed request');
    }

    public function show($id) {
    	$res = [];
    	$res['user'] = $this->service->show_user($id);
    	return view('users.show', $res);
    }

    public function destroy($id)
    {
        try {
            $this->service->deleteUser($id);
            return redirect()->route('users.index')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    // permission data
    public function permission_index() {
    	$data = [];
    	$data['users'] = $this->service->get_all_permission();
    	return view('users.permission_list', $data);
    }

    public function permission_create() {
    	$data = [];
    	$data['list'] = $this->service->get_parent_list();
    	return view('users.create_permission', $data);
    }

    public function permission_store(Request $request)
    {
        
        $request->validate([
            'name' => 'required|unique:permissions',
            // 'slug' => 'required|unique:permissions',
            'show_in_menu' => 'required'
        ]);

        // dd($request->all());

        $user = $this->service->create_permission($request);
        if(!empty($user->id)) {
        	return redirect()->to('permission-list')->with('success', 'Permission created successfully.');
        }
        return redirect()->route('permission-user')->with('error', 'Failed request');
    }

    public function permission_update(Request $request) {
        $request->validate([
            'name' => 'required',
            'show_in_menu' => 'required'
        ]);
        $data = $this->service->edit_permission($request);
        if($data) {
        	return redirect()->to('permission-list')->with('success', 'Permission edited successfully.');
        }
        return redirect()->back()->with('error', 'Failed request');
    }

    public function permission_edit($id) {
    	$res = [];
    	$res['list'] = $this->service->get_parent_list();
    	$res['data'] = $this->service->show_permission($id);
    	return view('users.permission_edit', $res);
    }

    public function permission_show($id) {
    	$res = [];
    	$res['user'] = $this->service->show_permission($id);
    	return view('permission.show', $res);
    }

    public function permission_destroy($id)
    {
        try {
            $this->service->delete_permission($id);
            return redirect()->route('permission.index')->with('success', 'Permission deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function role_index() {
    	$data = [];
    	$data['roles'] = $this->service->get_all_role();
    	return view('users.role_list', $data);
    }

    public function role_destroy($id) {
        try {
            $this->service->delete_role($id);
            return redirect()->route('role-list')->with('success', 'Role deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function role_create() {
    	$data = [];
    	$data['menus'] = $this->service->menu_list();
    	return view('users.create_role', $data);
    }

    public function role_store(Request $request) {
        $request->validate([
            'role_name' => 'required'
        ]);
    	// dd($request->all());

        $role_data = $this->service->create_role_data($request);
        // dd($role_data);
        if(!empty($role_data)) {
        	return redirect()->to('role-list')->with('success', 'Role created successfully.');
        }
        return redirect()->back()->with('error', 'Failed request');
    }

    public function role_edit($id) {
        $data = [];
        $ids = [];
        $data['menus'] = $this->service->menu_list();
        $data['role_data'] = $this->service->get_role_data($id);
        $permissions = json_decode($data['role_data']->permission_ids);
        if(!empty($permissions)) {
            foreach($permissions as $key=>$val) {
                for($i=0; $i<count($val); $i++) {
                    $ids[] = $val[$i];
                }
            }
            $data['ids'] = $ids;
        }
        else {
            $data['ids'] = [];
        }

        
        return view('users.edit_role', $data);
    }

    public function role_update(Request $request) {
        // dd($request->all());
        $request->validate([
            'role_name' => 'required'
        ]);

        $role_data = $this->service->edit_role_data($request);
        // dd($role_data);
        if(!empty($role_data)) {
            return redirect()->to('role-list')->with('success', 'Role created successfully.');
        }
        return redirect()->back()->with('error', 'Failed request');
    }

  

    public function user_profile($id)
    {
        $user = $this->service->show_user_with_role($id);
        return view('users.user_profile', compact('user'));
    }


    public function profile_edit($id)
    {
        $user = $this->service->getUserById($id);
        return view('users.account_settings', compact('user'));
    }



    public function profile_update(Request $request, $id)
    {
        $this->validate($request, [
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,' . $id,
            'phone_number' => 'nullable|string|max:20',
            'gender' => 'nullable|string|max:6',
            'profile_image' => 'nullable|image|max:2048',
            'address' => 'nullable|string',
            'current_password' => 'nullable|string',
            'password' => 'nullable|string|confirmed',
            'password_confirmation' => 'required_with:password',
        ]);

        try {
            //$this->service->updateUser($id, $request);
            $user = $this->service->updateUser($id, $request);
            // Update session data
            Session::setId(session()->getId());
            Session::put('users', $user);
            return redirect()->back()->with('success', 'Account settings updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }


    public function search(Request $request)
    {
        $searchTerm = trim($request->input('search'));

        if (empty($searchTerm)) {
            return redirect()->route('users.index')->with('error', 'Search Field cannot be blank.');
        }

        $request->validate([
            'search' => 'required|string',
        ]);

        $users = $this->service->searchUser($request);
        return view('users.user_list', compact('users'));
    }


    public function role_search(Request $request)
    {
        $searchTerm = trim($request->input('search'));

        if (empty($searchTerm)) {
            return redirect()->route('role-list')->with('error', 'Search Field cannot be blank.');
        }

        $request->validate([
            'search' => 'required|string',
        ]);

        $roles = $this->service->searchRole($request);
        return view('users.role_list', compact('roles'));
    }


    public function permission_search(Request $request)
    {
        $searchTerm = trim($request->input('search'));

        if (empty($searchTerm)) {
            return redirect()->route('permission.index')->with('error', 'Search Field cannot be blank.');
        }

        $request->validate([
            'search' => 'required|string',
        ]);

        $users = $this->service->searchPermission($request);
        return view('users.permission_list', compact('users'));
    }

    public function deleteProfileImage($id)
    {
        $user = User::find($id);

        // Set profile image to null
        $user->profile_image = null;

        $user->save();

        //return redirect()->back();
    }


    public function updateProfileImage($id)
    {
        $user = User::findOrFail($id);
        if ($user->profile_image) {
            // path to the image file
            //$imagePath = public_path('uploads/agents/' . $user->profile_image);
            $imagePath =getcwd().'/uploads/agents/'.$user->profile_image;
            // delete the file if it exists
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            //Update the user record to remove the profile image
            $user->profile_image = null;
            $user->save();
    
            return response()->json(['success' => true]);
        }
    
        return response()->json(['success' => false, 'message' => 'No profile image found']);
    }

    public function role_show($id) {
        $res = [];
        $res['user'] = $this->service->show_role_data($id);
        return view('users.show_roles', $res);
    }

    
}
