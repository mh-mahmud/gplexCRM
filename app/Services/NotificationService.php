<?php

namespace App\Services;

use App\Models\Notification;

class NotificationService
{
    public function getAllNotifications()
    {
        return Notification::paginate(config('constants.ROW_PER_PAGE'));
    }

    public function createNotification($data)
    {
        return Notification::create($data);
    }

    public function getNotificationById($id)
    {
        return Notification::findOrFail($id);
    }

    public function updateNotification($id, $data)
    {
        $notification = Notification::findOrFail($id);
        $notification->update($data);

        return $notification;
    }

    public function deleteNotification($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();
    }
}
