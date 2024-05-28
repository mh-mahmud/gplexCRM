<?php

namespace App\Services;

use App\Models\EmailTemplate;
use App\Models\Agent;
use Exception;
use Illuminate\Support\Facades\Validator;

class EmailService
{
    public function emailTemplateList()
    {
        return EmailTemplate::paginate(config('constants.ROW_PER_PAGE'));
    }

    public function templateStore($request)
    {
        $rules = [
            'email_content'         => 'required',
            'email_subject'         => 'required|unique:email_templates',
        ];
        // return Validator::make($request->all(), $rules)->validate();
        // if($validator->fails()) {

        //     return (object)[
        //         'status_code' => 400,
        //         'messages'    => config('status.status_code.400'),
        //         'errors'      => $validator->errors()->all()
        //     ];

        // }
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
                'messages'           => config('status.status_code.424'),
                'error'              => $e->getMessage()
            ];
        }

        return (object)[
            'status'                 => 201,
            'messages'               => config('status.status_code.201'),
            'info'                   => $dataObj->id
        ];

    }

    public function getEmailTemplateById($id)
    {
        return EmailTemplate::findOrFail($id);
    }
}