<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Lead;
use App\Models\LeadsForm;
use App\Models\Agent;
use App\Models\Product;
use App\Models\Campaign;
use App\Models\Task;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller {

	public function __construct() {
        // $this->middleware(['auth']);
    }

	public function dashboard()
    {

        $data = [];
        $user_id = Auth::user()->id;
        if(Auth()->user()->user_type=='admin') {
           $data['lead_list'] = Lead::where('lead_status', 1)->orderBy('id', 'desc')->limit(5)->get(['id', 'first_name', 'email', 'phone', 'gender', 'age', 'lead_source']); 
        }
        else {
            $data['lead_list'] = Lead::where('lead_status', 1)->where('created_by', Auth::user()->id)->orderBy('id', 'desc')->limit(5)->get(['id', 'first_name', 'email', 'phone', 'gender', 'age', 'lead_source']);
        }
        $data['camp_list'] = Campaign::where('status', 1)->orderBy('id', 'desc')->limit(5)->get(['id', 'campaign_title', 'start_date', 'end_date', 'campaign_type', 'campaign_limit']);
        $data['agent_list'] = Agent::with('user')->where('status', 1)->orderBy('agent_id', 'desc')->limit(5)->get();
        $data['todo_list'] = (Auth()->user()->user_type=='admin') ? Task::where('status', '!=', 9)->limit(6)->get(['task_name', 'description', 'due_date', 'status']) : Task::where('created_by', $user_id)->orWhere('assigned_to', $user_id)->limit(6)->get(['task_name', 'description', 'due_date', 'status']);
        $data['formName'] = $formName = LeadsForm::whereNull('parent_id')->pluck('form_name', 'form_id');

        $data['count_lead'] = Lead::where('lead_status', 1)->count();
        $data['active_agents'] = Agent::where('status', 1)->count();
        $data['active_products'] = Product::where('status', 1)->count();
        $data['const_task'] = config('constants.TASK_STATUS');
        // dd($data);
        return view('dashboard', $data);
    }

	function profile() {
		return view('single_form');
	}

}

