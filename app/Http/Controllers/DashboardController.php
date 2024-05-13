<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller {

    public function __construct() {
		/*if( !(Session::has('users')) ) {
            return Redirect('login');
        }*/

    }

	public function dashboard() 
	{
		//dd(Session::has('users'));die();
		/*if( !(Session::has('users')) ) {
			return Redirect('login');
		}*/

		return view('dashboard');
	  
	}

	function profile() {
		dd("hi kaka");
	}

}

