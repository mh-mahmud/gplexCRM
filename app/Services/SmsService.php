<?php
namespace App\Services;
use App\Models\SmsTemplates;
use App\Models\SmsQueue;
use App\Models\SmsLog;

class SmsService {

	public function get_all_templates() {
		return SmsTemplates::all();
	}

	public function sms_template_destroy_service() {
        $data = [];
        $request->validate([
            'id' => 'required'
        ]);

        $check = SmsTemplate::find($request->id);
        if(!empty($check)) {
            $data['data'] = SmsTemplate::destroy($request->id);
            $data['status'] = "success";
            $data['msg'] = ["SmsTemplate deleted successfully"];
            return response()->json(compact('data'))->setStatusCode(200);
        }
        $data['status'] = "failed";
        $data['msg']= ["no data found"];
        return response()->json(compact('data'))->setStatusCode(401);
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
}