<?php

namespace App\Services;

use App\Models\EmailTemplate;
use App\Models\EmailLog;
use Exception;
use Mail;
use App\Mail\SingleMail;
use Carbon\Carbon;

class EmailService
{
    public function emailTemplateList($request)
    {
        $sql = EmailTemplate::query();
        $data = $request->all();
        if(!empty($data["search"])) {
            $sql->where('email_subject','like', '%' . $data["search"] . '%');

        }
        if (isset($data['paginate']) && $data['paginate'] == false) {
            return  $sql->orderBy('id', 'DESC')->get();

        } else {
            return  $sql->orderBy('id', 'DESC')->paginate(config('constants.ROW_PER_PAGE'));

        }
    }

    public function templateStore($request)
    {
        $request->validate([
            'email_subject' => 'required',
            'email_content' => 'required',
           
        ]);
        $data = $request->all();

        try {
            $dataObj                        = new EmailTemplate();
            $dataObj->email_subject         = $data['email_subject'];
            $dataObj->email_content         = $data['email_content'];
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

    public function getEmailTemplateById($id)
    {
        return EmailTemplate::findOrFail($id);
    }

    public function templateDelete($id)
    {
        $promotion = EmailTemplate::findOrFail($id);
        $promotion->delete();
    }

    public function templateUpdate($request, $id)
    {
        $request->validate([
            'email_subject' => 'required',
            'email_content' => 'required',
           
        ]);
        $data = $request->all();

        try {
            $dataObj                        = EmailTemplate::findOrFail($id);
            $dataObj->email_subject         = $data['email_subject'];
            $dataObj->email_content         = $data['email_content'];
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

    public function sendEmailPro($request) {
        $data = [];
        $request->validate([
            'email_subject' => 'required',
            'email_content' => 'required',
            'to_email' => 'required|email'
        ]);
       
        $data = $request->all();

        $subject = $data["email_subject"];
        $body = $data["email_content"];
        $to_email = $data["to_email"];

        try {
            Mail::to($to_email)->send(new SingleMail($subject, $body));
            $dataObj                        = new EmailLog();
            $dataObj->email_from            = "Genuity";
            $dataObj->email_to              = $data['to_email'];
            $dataObj->email_subject         = $data['email_subject'];
            $dataObj->email_content         = $data['email_content'];
            $dataObj->log_time              = Carbon::now();
            $dataObj->delivery_time         = Carbon::now();
            $dataObj->send_status           = 1;
            $dataObj->save();
            

        } catch (Exception $e) {
            $dataObj                        = new EmailLog();
            $dataObj->email_from            = "Genuity";
            $dataObj->email_to              = $data['to_email'];
            $dataObj->email_subject         = $data['email_subject'];
            $dataObj->email_content         = $data['email_content'];
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

    public function sendEmailList($request)
    {
        $sql = EmailLog::query();
        $data = $request->all();
        if(!empty($data["search"])) {
            $sql->where('email_to','like', '%' . $data["search"] . '%');

        }
        return $sql->orderBy('id', 'DESC')->paginate();
    }

}