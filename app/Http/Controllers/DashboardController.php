<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Lead;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller {

	public function __construct()
    {
        $this->middleware('auth');
    }

	public function dashboard()
    {
        $data = [];
        $data['lead_list'] = Lead::where('lead_status', 1)->orderBy('id', 'desc')->limit(5)->get(['id', 'first_name', 'email', 'phone', 'gender']);
        return view('dashboard', $data);
    }

	function profile() {
		return view('single_form');
	}

}

