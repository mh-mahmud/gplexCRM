<?php

namespace App\Services;

use App\Models\Meeting;
use Illuminate\Support\Facades\Storage;

class MeetingService
{
    // Get all meetings
    public function getAllMeetings()
    {
        return Meeting::orderBy('created_at', 'desc')->paginate(config('constants.ROW_PER_PAGE'));
    }

    // Create a new meeting
    public function createMeeting($request)
    {

        //dd($request);die();
        $fileNameToStore = null;

        if ($request->hasFile('attachments')) {
            $file = $request->file('attachments');
            $fileNameToStore = time().'_'.$file->getClientOriginalName();
            $file->move(getcwd().'/uploads/meetings', $fileNameToStore);
        }

        $recipients = is_array($request->recipients) ? implode(',', $request->recipients) : null;

        Meeting::create([
            'lead_id' => $request->lead_id,
            'recipients' => $recipients,
            'created_by' => auth()->id(),
            'meeting_subject' => $request->meeting_subject,
            'meeting_description' => $request->meeting_description,
            'meeting_date' => $request->meeting_date,
            'meeting_link' => $request->meeting_link,
            'attachments' => $fileNameToStore,
            'duration' => $request->duration,
            'status' => $request->status,
            //'send_email' => $request->send_email,
            //'send_sms' => $request->send_sms,
            //'meeting_feedback' => $request->meeting_feedback,
            //'rating' => $request->rating,
        ]);
    }

    // Get a single meeting by ID
    public function getMeetingById($id)
    {
        return Meeting::findOrFail($id);
    }

    // Update an existing meeting
    public function updateMeeting($request, $id)
    {
        $meeting = Meeting::findOrFail($id);

        if ($request->hasFile('attachments')) {
            if ($meeting->attachments) {
                //$existingFilePath = public_path('uploads/meetings/'.$meeting->attachments);
                $existingFilePath = getcwd() . '/uploads/meetings/' . $meeting->attachments;
                if (file_exists($existingFilePath)) {
                    unlink($existingFilePath);
                }
            }

            $file = $request->file('attachments');
            $fileNameToStore = time().'_'.$file->getClientOriginalName();
            //$file->move(public_path('uploads/meetings'), $fileNameToStore);
            $file->move(getcwd().'/uploads/meetings', $fileNameToStore);
            $meeting->attachments = $fileNameToStore;
        }
        $recipients = is_array($request->recipients) ? implode(',', $request->recipients) : null;
        

        //dd($request->lead_id);die();

        $meeting->update([
            'lead_id' => isset($request->lead_id) ? $request->lead_id : null,
            'recipients' => isset($recipients) ? $recipients : null,
            'meeting_subject' => $request->meeting_subject,
            'meeting_description' => $request->meeting_description,
            'meeting_date' => $request->meeting_date,
            'meeting_link' => $request->meeting_link,
            'attachments' => $meeting->attachments,
            'duration' => $request->duration,
            'status' => $request->status,
            //'send_email' => $request->send_email,
            //'send_sms' => $request->send_sms,
            //'meeting_feedback' => $request->meeting_feedback,
            //'rating' => $request->rating,
        ]);
    }

    // Delete a meeting
    public function deleteMeeting($id)
    {
        $meeting = Meeting::findOrFail($id);

        if ($meeting->attachments) {
            //$existingFilePath = public_path('uploads/meetings/'.$meeting->attachments);
            $existingFilePath = getcwd() . '/uploads/meetings/' . $meeting->attachments;
            if (file_exists($existingFilePath)) {
                unlink($existingFilePath);
            }
        }

        $meeting->delete();
    }

    // Search meetings
    public function searchMeetings($request)
    {
        $searchTerm = trim($request->input('search'));

        return Meeting::where('meeting_subject', 'LIKE', "%{$searchTerm}%")
            ->orWhere('meeting_description', 'LIKE', "%{$searchTerm}%")
            ->orWhere('meeting_date', 'LIKE', "%{$searchTerm}%")
            ->orderBy('created_at', 'desc')
            ->paginate(config('constants.ROW_PER_PAGE'));
    }
}
