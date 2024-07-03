<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Lead;
use App\Models\Agent;
use App\Models\Product;
use App\Models\Campaign;
use App\Models\Task;
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
        $data['lead_list'] = Lead::where('lead_status', 1)->orderBy('id', 'desc')->limit(5)->get(['id', 'first_name', 'email', 'phone', 'gender', 'age', 'lead_source']);
        $data['camp_list'] = Campaign::where('status', 1)->orderBy('id', 'desc')->limit(5)->get(['campaign_title', 'start_date', 'end_date', 'campaign_type', 'campaign_limit']);
        $data['agent_list'] = Agent::where('status', 1)->limit(5)->get(['first_name', 'last_name', 'phone_number', 'agent_id']);
        $data['todo_list'] = Task::where('status', '!=', 9)->limit(6)->get(['task_name', 'description', 'due_date', 'status']);

        $data['count_lead'] = Lead::where('lead_status', 1)->count();
        $data['active_agents'] = Agent::where('status', 1)->count();
        $data['active_products'] = Product::where('status', 1)->count();
        // dd($data);
        return view('dashboard', $data);
    }

	function profile() {
		return view('single_form');
	}

}

