<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SmsService;
use App\Models\SmsTemplate;

class SmsController extends Controller
{
    protected $service;
    public function __construct(SmsService $sms_service) {
    	$this->service = $sms_service;
    }

    /*
        SMS Templates
    */
        
    public function sms_template_list()
    {
        return SmsTemplate::all();
    }

    public function sms_template_create(Request $request)
    {
        $data = [];
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'status' => 'required'
        ]);

        $ckh_dub = SmsTemplate::where('title', $request->title)->first();
        if(!empty($ckh_dub)) {
            $data['status'] = "dublicate";
            $data['msg']=["this template already created"];
            return response()->json(compact('data'))->setStatusCode(200);
        }

        $data['data'] = SmsTemplate::create($request->all());
        $data['status'] = "success";
        $data['msg']=["SmsTemplate saved successfully"];
        return response()->json(compact('data'))->setStatusCode(200);
    }

    public function sms_template_show(string $id)
    {
        $data = [];
        $chk_data = SmsTemplate::find($id);
        if(!empty($chk_data)) {
            $status = "success";
            $msg=["data found"];
            $data['data'] = $chk_data;
            return response()->json(compact('data'))->setStatusCode(200);
        }
        $data['status'] = "failed";
        $data['msg']=["no data found"];
        return response()->json(compact('data'))->setStatusCode(401);
    }

    public function sms_template_update(Request $request)
    {
        $data = [];
        $request->validate([
            'id' => 'required'
        ]);

        $branch_data = SmsTemplate::find($request->id);
        if(!empty($branch_data)) {
            $branch_data->update($request->all());
            $data['status'] = "success";
            $data['msg']=["SmsTemplate updated successfully"];
            $data['data'] = $branch_data;
            return response()->json(compact('data'))->setStatusCode(200);
        }

        $data['status'] = "failed";
        $data['msg']=["no data found"];
        return response()->json(compact('data'))->setStatusCode(401);
    }

    public function sms_template_destroy(Request $request)
    {
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
}
