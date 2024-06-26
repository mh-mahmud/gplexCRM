<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TaskService;
use App\Models\EmailTemplate;
use App\Services\API\UserService;

class TaskController extends Controller {

	// public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
        $this->middleware('auth');
    }

    public function addTask()
    {
        $users = $this->taskService->getUsers();     
        return view('tasks.add-task', compact('users'));
    }

    public function addTaskPro(Request $request)
    { 
        $result = $this->taskService->addTaskPro($request);
        dd($result);
        if($result->status == 201){
            return redirect()->route('add-task')->with('success', 'Email template created successfully.');

        }else{
            session()->flash('error', 'Can not Create !');
        }

    }
}