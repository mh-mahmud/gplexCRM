<?php

namespace App\Services;
use App\Models\User;
use App\Models\Task;
use Exception;
use Illuminate\Support\Facades\Auth;

class TaskService
{
    public function getTaskList()
    {
        $sql = Task::query();
        if(Auth::user()->user_type != 'admin') {
            $sql->where('assigned_to', Auth::id());
        } else {
            $sql->join('users', 'users.id', '=', 'tasks.assigned_to')
                ->select('tasks.*', 'users.first_name', 'users.last_name');
        }
        return $sql->paginate(config('constants.ROW_PER_PAGE'));
    }


    public function getUsers()
    {
        return User::where('role_id', '!=', config('constants.ADMIN_ROLE_ID'))
                    ->orWhereNull('role_id')
                    ->get();
    }

    public function addTaskPro($request)
    {
        if(Auth::user()->user_type == 'admin') {
            $request->validate([
                'task_name' => 'required',
                'due_date' => 'required',
                'assigned_to' => 'required',
            ]);
        } else {
            $request->validate([
                'task_name' => 'required',
                'due_date' => 'required',
            ]);
        }
       
        $data = $request->all();

        try {
            $dataObj                        = new Task();
            $dataObj->task_name             = $data['task_name'];
            $dataObj->assigned_to           = Auth::user()->user_type == 'admin' ? $data['assigned_to'] : Auth::id();
            $dataObj->description           = $data['description'];
            $dataObj->due_date              = $data['due_date'];
            $dataObj->status                = config('constants.TASK_TO_DO');
            $dataObj->created_by            = Auth::id();

            $dataObj->save();

        } catch (Exception $e) {
            return (object)[
                'status'             => 424,
                'error'              => $e->getMessage()
            ];
        }

        return (object)[
            'status'                 => 201,
            'info'                   => $dataObj->id
        ];
    }

    public function changeStatus($request, $id)
    {
        $data = $request->all();

        try {
            $dataObj                        = Task::findOrFail($id);
            $dataObj->status                = $data['status'];

            $dataObj->save();

        } catch (Exception $e) {
            return (object)[
                'status'             => 424,
                'error'              => $e->getMessage()
            ];
        }

        return (object)[
            'status'                 => 208,
            'info'                   => $dataObj->id
        ];

    }

    public function taskDelete($id)
    {
        try {
            $task = Task::findOrFail($id);
            $task->delete();

        } catch (Exception $e) {
            return (object)[
                'status'             => 424,
                'error'              => $e->getMessage()
            ];
        }

        return (object)[
            'status'                 => 200,
        ];

    }
}