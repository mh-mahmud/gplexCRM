<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;

class UserController extends Controller
{
    protected $service;
    public function __construct(UserService $service) {
    	$this->service = $service;
    }

    public function index() {
    	$data = [];
    	$data['users'] = $this->service->get_all_user();
    	return view('users.user_list', $data);
    }

    public function create() {
    	return view('users.create_user');
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
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
    	$data['user_data'] = $this->service->show_user($id);
    	return view('users.edit', $data);
    }

    public function update(Request $request) {
    	// dd($request->all());
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'gender' => 'required',
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
            'slug' => 'required|unique:permissions',
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
            'slug' => 'required'
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
}
