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

    public function getTaskList(Request $request)
    {      
        $tasks = $this->taskService->getTaskList($request);
        return view('tasks.task-list', compact('tasks'));
    }

    public function addTask()
    {
        $users = $this->taskService->getUsers();     
        return view('tasks.add-task', compact('users'));
    }

    public function addTaskPro(Request $request)
    { 
        $result = $this->taskService->addTaskPro($request);
        if($result->status == 201){
            return redirect()->route('task-list')->with('success', 'Task created successfully.');

        }else{
            session()->flash('error', 'Can not Create !');
        }

    }

    public function changeStatus(Request $request, $id)
    { 
        $result = $this->taskService->changeStatus($request, $id);
        if($result->status == 208){
            return redirect()->route('task-list')->with('success', 'Status updated successfully.');
        }else{
            session()->flash('error', 'Can not Update !');
        }

    }

    public function delete($id)
    {
        $result = $this->taskService->taskDelete($id);
        if($result->status == 200) {
            return redirect()->route('task-list')->with('success', 'Task deleted successfully.');
        } else{
            session()->flash('error', 'Can not Delete !');
        }
    }
}