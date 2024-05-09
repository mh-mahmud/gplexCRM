<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Session;
use App\Models\User;

class AuthController extends Controller
{

	public function index()
    {
		
		if(!(Session::get('users')) ) {
            return view('auth.login');
        }else{
			 return redirect()->intended('dashboard');
		}
       
    } 

	public function dashboard()
    {
		// dd("hello");
        return view('dashboard');
    }

	
    public function register(Request $request) {
		//var_dump($request);die();
    	$inputs = $request->validate([
    		'name' => 'required|string',
    		'email' => 'required|string|unique:users,email',
    		'password' => 'required|string|confirmed'
    	]);

    	$user = User::create([
    		'name' => $inputs['name'],
    		'email' => $inputs['email'],
    		'password' => bcrypt($inputs['password'])
    	]);
    	$token = $user->createToken('gpleCRMToken')->plainTextToken;

    	$response = [
    		'user' => $user,
    		'token' => $token
    	];
    	return response($response, 201);
    }

    public function logout(Request $request) {
    	auth()->user()->tokens()->delete();
    	return [
    		'message' => 'Logged Out'
    	];
    }
 
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to log in with the provided credentials
        if (Auth::attempt($request->only('email', 'password'), $request->has('remember'))) {
            // Redirect to a specific route or homepage on successful login
            return redirect()->intended('/dashboard');
        }

        // If authentication fails, redirect back with errors
        return redirect()->back()->withErrors(['email' => 'The provided credentials do not match our records.']);
    }
}
