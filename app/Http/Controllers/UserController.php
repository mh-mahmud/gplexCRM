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
}
