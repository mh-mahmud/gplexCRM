<?php

namespace App\Services;

use App\Models\EmailTemplate;
use App\Models\Agent;
use Exception;
use Illuminate\Support\Facades\Validator;

class EmailService
{
    public function emailTemplateList($request)
    {
        $sql = EmailTemplate::query();
        $data = $request->all();
        if(!empty($data["search"])) {
            $sql->where('email_subject','like', '%' . $data["search"] . '%');

        }
        return  $sql->paginate(config('constants.ROW_PER_PAGE'));
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

}