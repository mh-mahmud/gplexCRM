<?php

namespace App\Services;

use App\Models\SmsTemplate;
use App\Models\SmsLog;
use App\Models\SmsQueue;
use Exception;
use Mail;
use App\Mail\SingleMail;
use Carbon\Carbon;

class SmsService
{
    public function smsTemplateList($request)
    {
        $sql = SmsTemplate::query();
        $data = $request->all();
        if(!empty($data["search"])) {
            $sql->where('title','like', '%' . $data["search"] . '%');

        }
        if (isset($data['paginate']) && $data['paginate'] == false) {
            return  $sql->get();

        } else {
            return  $sql->paginate(config('constants.ROW_PER_PAGE'));

        }
    }

    public function templateStore($request)
    {
        $request->validate([
            'title' => 'required|unique:sms_templates',
            'description' => 'required',
           
        ]);
        $data = $request->all();

        try {
            $dataObj                        = new SmsTemplate();
            $dataObj->title                 = $data['title'];
            $dataObj->description           = $data['description'];
            $dataObj->status                = $data['status'];

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

    public function getSmsTemplateById($id)
    {
        return SmsTemplate::findOrFail($id);
    }

    public function templateDelete($id)
    {
        $promotion = SmsTemplate::findOrFail($id);
        $promotion->delete();
    }

    public function templateUpdate($request, $id)
    {
        $request->validate([
            'title' => 'required|unique:sms_templates,title,'.$id,
            'description' => 'required',
           
        ]);
        $data = $request->all();

        try {
            $dataObj                        = SmsTemplate::findOrFail($id);
            $dataObj->title                 = $data['title'];
            $dataObj->description           = $data['description'];
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

    public function send_sms_service($request) {
        $data = [];
        $request->validate([
            'user_id' => 'required',
            'sms_from' => 'required',
            'sms_to' => 'required',
            'sms_text' => 'required'
        ]);

        if(empty($request->send_status)) {
            $request['send_status'] = 0;
        }

        if(empty($request->priority_level)) {
            $request['priority_level'] = 5;
        }
        $request['log_time'] = date("Y-m-d h:i:s", time());

        try {
            $data['data'] = SmsQueue::create($request->all());
            $data['status'] = "success";
            $data['msg']=["Sms sending is on process successfully"];
            return response()->json(compact('data'))->setStatusCode(200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'User not found'], 404);
        } catch (\Exception $e) {
            // Handle other types of exceptions
            return response()->json(['error' => $e->getMessage()], 500);
        }
	}
   
    public function get_queue_list() {
		return SmsQueue::paginate(20);
	}

	public function get_log_list() {
		return SmsLog::paginate(20);
	}

	public function queue_details($id) {
        $data = [];
        $chk_data = SmsQueue::find($id);

        if(!empty($chk_data)) {
            $data[] = ['status' => 'success', 'msg' => 'data found', 'data' => $chk_data];
            return response()->json(compact('data'))->setStatusCode(200);
        }
        $data[] = ['status' => 'failed', 'msg' => 'no data found'];
        return response()->json(compact('data'))->setStatusCode(401);
	}

	public function log_details($id) {
        $data = [];
        $chk_data = SmsLog::find($id);

        if(!empty($chk_data)) {
            $data[] = ['status' => 'success', 'msg' => 'data found', 'data' => $chk_data];
            return response()->json(compact('data'))->setStatusCode(200);
        }
        $data[] = ['status' => 'failed', 'msg' => 'no data found'];
        return response()->json(compact('data'))->setStatusCode(401);
	}

    public function single_queue_delete($request, $id)
    {
        $data = [];
        $request->validate([
            'delete_code' => 'required'
        ]);

        $check = SmsQueue::find($id);
        if(!empty($check)) {
            $data['data'] = SmsQueue::destroy($id);
            $data['status'] = "success";
            $data['msg'] = ["Single Queue deleted successfully"];
            return response()->json(compact('data'))->setStatusCode(200);
        }
        $data['status'] = "failed";
        $data['msg']= ["no data found"];
        return response()->json(compact('data'))->setStatusCode(401);
    }

    public function all_queue_delete($request)
    {
        $data = [];
        $request->validate([
            'delete_code' => 'required'
        ]);

        $deleted = SmsQueue::truncate();
        if(!empty($deleted)) {
        	$data['data'] = $deleted;
            $data['status'] = "success";
            $data['msg'] = ["All Queue deleted successfully"];
            return response()->json(compact('data'))->setStatusCode(200);
        }
        $data['status'] = "failed";
        $data['msg']= ["no data found"];
        return response()->json(compact('data'))->setStatusCode(401);
    }

}