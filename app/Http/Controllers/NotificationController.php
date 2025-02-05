<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Helpers\Helper;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index()
    {
        $notifications = $this->notificationService->getAllNotifications();
        return view('notification.index', compact('notifications'));
    }

    public function create()
    {
        if (Auth::user()->user_type === 'admin') {
            $leads = DB::table('leads')
                ->select('id', 'first_name', 'last_name', 'email')
                ->where('lead_status', 1)
                ->get();
        } else {
            $leads = DB::table('leads')
                ->select('id', 'first_name', 'last_name', 'email')
                ->where('lead_status', 1)
                ->where('created_by', Auth::user()->id)
                ->get();
        }
        $users = DB::table('users')
            ->select('id', 'username', 'email')
            ->where('status', '1')
            ->get();
        return view('notification.create', compact('leads', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lead_id' => 'nullable|integer',
            'user_id' => 'nullable|integer',
            'notify_msg' => 'required|string',
            //'notify_date' => 'required|date',
            'notify_datetime' => 'required|date',
            //'notify_time' => 'required|date_format:H:i:s',
            //'notify_type' => 'required|string|max:50',
            //'send_email' => 'boolean',
            'send_sms' => 'boolean',
            'notify_by' => 'nullable|integer',
        ]);

        $this->notificationService->createNotification($request->all());
        Helper::storeLog("Notification created successfully", "Notification", "Create Notification", $request->lead_id);
        return redirect()->route('notification-index')->with('success', 'Notification created successfully.');
    }

    public function show($id)
    {
        $notification = $this->notificationService->getNotificationById($id);
        //associated lead and user details
        $lead = $notification->lead;
        $user = $notification->user;
       return view('notification.show', compact('notification', 'lead', 'user'));
    }


    public function edit($id)
    {
        $notification = $this->notificationService->getNotificationById($id);
        if (Auth::user()->user_type === 'admin') {
            $leads = DB::table('leads')
                ->select('id', 'first_name', 'last_name', 'email')
                ->where('lead_status', 1)
                ->get();
        } else {
            $leads = DB::table('leads')
                ->select('id', 'first_name', 'last_name', 'email')
                ->where('lead_status', 1)
                ->where('created_by', Auth::user()->id)
                ->get();
        }
        $users = DB::table('users')
            ->select('id', 'username', 'email')
            ->where('status', '1')
            ->get();
        return view('notification.edit', compact('notification', 'leads', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'lead_id' => 'nullable|integer',
            'user_id' => 'nullable|integer',
            'notify_msg' => 'required|string',
            //'notify_date' => 'required|date',
            'notify_datetime' => 'required|date',
            //'notify_time' => 'required|date_format:H:i:s',
            //'notify_type' => 'required|string|max:50',
            //'send_email' => 'boolean',
            'send_sms' => 'boolean',
            'notify_by' => 'nullable|integer',
        ]);

        $this->notificationService->updateNotification($id, $request->all());
        Helper::storeLog("Notification updated successfully", "Notification", "Edit Notification", $request->lead_id);
        return redirect()->route('notification-index')->with('success', 'Notification updated successfully.');
    }

    public function destroy($id)
    {
        $notification = $this->notificationService->getNotificationById($id);
        $leadId = $notification->lead_id;
        $this->notificationService->deleteNotification($id);
        Helper::storeLog("Notification deleted successfully", "Notification", "Delete Notification", $leadId);
        return redirect()->route('notification-index')->with('success', 'Notification deleted successfully.');
    }

      // search for notification
      public function search(Request $request)
      {
          $searchTerm = trim($request->input('search'));
  
          if (empty($searchTerm)) {
              return redirect()->route('notification-index')->with('error', 'Search field cannot be blank.');
          }
  
          $notifications = $this->notificationService->searchNotifications($request);
          return view('notification.index', compact('notifications'));
      }
  
}
