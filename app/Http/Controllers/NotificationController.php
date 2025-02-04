<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NotificationService;
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
        return view('notification.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'lead_id' => 'nullable|integer',
            'user_id' => 'nullable|integer',
            'notify_msg' => 'required|string',
            //'notify_date' => 'required|date',
            'notify_datetime' => 'required|date_format:Y-m-d H:i:s',
            'notify_time' => 'required|date_format:H:i:s',
            'notify_type' => 'required|string|max:50',
            'send_email' => 'boolean',
            'send_sms' => 'boolean',
            'notify_by' => 'nullable|integer',
        ]);

        $this->notificationService->createNotification($request->all());
        Helper::storeLog("Notification created successfully", "Notification", "Create Notification",$request->lead_id);
        return redirect()->route('notification-index')->with('success', 'Notification created successfully.');
    }

    public function show($id)
    {
        $notification = $this->notificationService->getNotificationById($id);
        return view('notification.show', compact('notification'));
    }

    public function edit($id)
    {
        $notification = $this->notificationService->getNotificationById($id);
        return view('notification.edit', compact('notification'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'lead_id' => 'nullable|integer',
            'user_id' => 'nullable|integer',
            'notify_msg' => 'required|string',
            //'notify_date' => 'required|date',
            'notify_datetime' => 'required|date_format:Y-m-d H:i:s',
            'notify_time' => 'required|date_format:H:i:s',
            'notify_type' => 'required|string|max:50',
            'send_email' => 'boolean',
            'send_sms' => 'boolean',
            'notify_by' => 'nullable|integer',
        ]);

        $this->notificationService->updateNotification($id, $request->all());
        Helper::storeLog("Notification updated successfully", "Notification", "Edit Notification",$request->lead_id);
        return redirect()->route('notification-index')->with('success', 'Notification updated successfully.');
    }

    public function destroy($id)
    {   $notification = $this->notificationService->getNotificationById($id);
        $leadId = $notification->lead_id;
        $this->notificationService->deleteNotification($id);
        Helper::storeLog("Notification deleted successfully", "Notification", "Delete Notification",$leadId);
        return redirect()->route('notification-index')->with('success', 'Notification deleted successfully.');
    }
}
