<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class AuthController extends Controller
{

	public function index()
	{   
		if(!Session::has('users')) {
			return view('auth.login');
		} else {
			//dd('dsds');die();
			return redirect()->intended('dashboard'); // Redirect to the dashboard if the user is already logged in
		}
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

	public function postLogin(Request $request)
	{   
		// Check user is already logged in
		if(Session::has('users')) {
			return redirect('dashboard')->with('success', 'You are already logged in.');
		}

		$this->validate($request,[
			'email' => 'required',
			'password' => 'required',
		]);

		$user = User::where('email', $request->email)->first();

		if(empty($user)) {
			return redirect("login")->with('error', 'Invalid email address.');
		}

		// Check if the password
		 if(Hash::check($request->password, $user->password)) {
			Session::put('users', $user);
			return redirect()->intended('dashboard')->with('success', 'You have successfully logged in.');
		}

		return redirect("login")->with('error', 'Invalid password.');
	}

    public function logoutAPI(Request $request) {
    	auth()->user()->tokens()->delete();
    	return [
    		'message' => 'Logged Out'
    	];
    }

	public function logout(Request $request)
	{
	   Auth::logout();
       $request->session()->invalidate();
       $request->session()->regenerateToken();
       return redirect('login')->with('success', 'You have successfully logged out.');
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
