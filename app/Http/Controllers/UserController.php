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

    public function show($id) {
    	$res = [];
    	$res['user'] = $this->service->show_user($id);
    	return view('users.show', $res);
    }
}
