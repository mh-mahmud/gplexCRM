<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MeetingService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class MeetingController extends Controller
{
    protected $meetingService;

    public function __construct(MeetingService $meetingService)
    {
        $this->meetingService = $meetingService;
        $this->middleware('auth');
    }

    //listing of the meetings
    public function index()
    {
        $meetings = $this->meetingService->getAllMeetings();
        return view('meetings.index', compact('meetings'));
    }

    // show creating a new meeting
    public function create()
    {   
        $leads = DB::table('leads')->select('id', 'first_name')->get();
        $users = DB::table('users')->select('id', 'username')->get();
        return view('meetings.create', compact('leads', 'users'));
    }

    // store a newly created meeting
    public function store(Request $request)
    {   

        $validator = Validator::make($request->all(), [
            'meeting_subject' => 'required|string|max:191',
            'meeting_description' => 'nullable|string',
            'meeting_date' => 'required|date',
            'meeting_link' => 'nullable|url',
            'attachments' => 'nullable|file|mimes:jpeg,png,jpg,pdf,docx|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $this->meetingService->createMeeting($request);
        return redirect()->route('meeting-index')->with('success', 'Meeting created successfully.');
    }

    // show specified meeting
    public function show($id)
    {
        $meeting = $this->meetingService->getMeetingById($id);
        return view('meetings.show', compact('meeting'));
    }

    //form for editing
    public function edit($id)
    {
        $meeting = $this->meetingService->getMeetingById($id);
        return view('meetings.edit', compact('meeting'));
    }

    // update the specified meeting
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'meeting_subject' => 'required|string|max:191',
            'meeting_description' => 'required|string',
            'meeting_date' => 'required|date',
            'meeting_link' => 'nullable|url',
            'attachments' => 'nullable|file|mimes:jpeg,png,jpg,pdf,docx|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $this->meetingService->updateMeeting($request, $id);
        return redirect()->route('meeting-index')->with('success', 'Meeting updated successfully.');
    }

    // remove the specified meeting
    public function destroy($id)
    {
        $this->meetingService->deleteMeeting($id);
        return redirect()->route('meeting-index')->with('success', 'Meeting deleted successfully.');
    }

    // searech for meetings
    public function search(Request $request)
    {
        $searchTerm = trim($request->input('search'));

        if (empty($searchTerm)) {
            return redirect()->route('meeting-index')->with('error', 'Search field cannot be blank.');
        }

        $meetings = $this->meetingService->searchMeetings($request);
        return view('meetings.index', compact('meetings'));
    }
}

