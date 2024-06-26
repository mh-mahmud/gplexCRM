<?php

namespace App\Services;
use App\Models\User;
use App\Models\Task;
use Exception;
use Illuminate\Support\Facades\Auth;

class TaskService
{
    public function getUsers()
    {
        return User::where('role_id', '!=', config('constants.ADMIN_ROLE_ID'))
                    ->orWhereNull('role_id')
                    ->get();
    }

    public function addTaskPro($request)
    {
        $request->validate([
            'task_name' => 'required',
            'due_date' => 'required',
            'assigned_to' => 'required',
        ]);
        $data = $request->all();

        try {
            $dataObj                        = new Task();
            $dataObj->task_name             = $data['task_name'];
            $dataObj->assigned_to           = $data['assigned_to'];
            $dataObj->description           = $data['description'];
            $dataObj->due_date              = $data['due_date'];
            $dataObj->status                = 0;
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
}