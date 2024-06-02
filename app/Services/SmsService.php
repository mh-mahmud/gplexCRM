<?php

namespace App\Services;

use App\Models\SmsTemplate;
use App\Models\SmsLog;
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

    public function sendSmsPro($request) {
        $data = [];
        // $request->validate([
        //     'subject' => 'required',
        //     'body' => 'required',
        //     'to_email' => 'required'
        // ]);
       
        $data = $request->all();

        $subject = $data["title"];
        $body = $data["description"];
        $to_email = $data["to_email"];

        try {
            $dataObj                        = new SmsLog();
            $dataObj->sms_from              = "Genuity";
            $dataObj->sms_to                = $data['to_sms'];
            $dataObj->title                 = $data['title'];
            $dataObj->description           = $data['description'];
            $dataObj->log_time              = Carbon::now();
            $dataObj->delivery_time         = Carbon::now();
            $dataObj->send_status           = 1;
            $dataObj->save();
            

        } catch (Exception $e) {
            $dataObj                        = new SmsLog();
            $dataObj->email_from            = "Genuity";
            $dataObj->email_to              = $data['to_email'];
            $dataObj->title                 = $data['title'];
            $dataObj->description         = $data['description'];
            $dataObj->log_time              = Carbon::now();
            $dataObj->delivery_time         = Carbon::now();
            $dataObj->send_status           = 0;
            $dataObj->save();

            return (object)[
                'status'                 => 401,
                'message'                => $e->getMessage()
            ];

        }

        

        return (object)[
            'status'                 => 200,
            'message'                => "Email sent successfully"
        ];

    }

    public function sendSmsList($request)
    {
        $sql = SmsLog::query();
        $data = $request->all();
        if(!empty($data["search"])) {
            $sql->where('email_to','like', '%' . $data["search"] . '%');

        }
        return $sql->paginate();
    }

}