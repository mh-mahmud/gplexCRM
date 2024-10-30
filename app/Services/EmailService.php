<?php

namespace App\Services;

use App\Models\EmailTemplate;
use App\Models\EmailLog;
use App\Models\Lead;
use App\Models\Logs;
use Exception;
use Mail;
use App\Mail\SingleMail;
use App\Mail\BulkEmail;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;
use DB;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;

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
            return  $sql->where('status', 1)->orderBy('id', 'DESC')->get();

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
            return  DB::transaction(function () use ($data) {
                $dataObj                        = new EmailTemplate();
                $dataObj->email_subject         = $data['email_subject'];
                $dataObj->email_content         = $data['email_content'];
                $dataObj->status                = $data['status'];
                $dataObj->save();

                Helper::storeLog($data['email_subject'], "Email Template", "Email Template Create", "Created");

                return (object)[
                    'status'                 => 201,
                    'info'                   => $dataObj->id
                ];
        
                
            });


        } catch (Exception $e) {
            return (object)[
                'status'             => 424,
                'error'              => $e->getMessage()
            ];
        }

       
    }

    public function getEmailTemplateById($id)
    {
        return EmailTemplate::findOrFail($id);
    }

    public function templateDelete($id)
    {
        return  DB::transaction(function () use ($id) {
            $promotion = EmailTemplate::findOrFail($id);
            $promotion->delete();
            Helper::storeLog($promotion->email_subject, "Email Template", "Email Template Delete",  "Deleted");
        });
    }

    public function templateUpdate($request, $id)
    {
        $request->validate([
            'email_subject' => 'required',
            'email_content' => 'required',
           
        ]);
        $data = $request->all();

        try {
            return  DB::transaction(function () use ($data, $id) {
                $dataObj                        = EmailTemplate::findOrFail($id);
                $dataObj->email_subject         = $data['email_subject'];
                $dataObj->email_content         = $data['email_content'];
                $dataObj->status                = $data['status'];

                $dataObj->save();

                Helper::storeLog($data['email_subject'], "Email Template", "Email Template Update", "Updated");

                return (object)[
                    'status'                 => 208,
                    'info'                   => $dataObj->id
                ];
            });

        } catch (Exception $e) {
            return (object)[
                'status'             => 424,
                'error'              => $e->getMessage()
            ];
        }

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
            $dataObj->lead_id               = $data['lead_id'];
            $dataObj->user_id               = Auth::id();
            $dataObj->log_time              = Carbon::now();
            $dataObj->delivery_time         = Carbon::now();
            $dataObj->send_status           = config('constants.campaign_status')["Success"];
            $dataObj->save();
            
            Helper::storeLog("Email send successfully to " .$data['to_email'], "Email Module", "Send an Email", "Send Email", $data['lead_id']);

        } catch (Exception $e) {
            $dataObj                        = new EmailLog();
            $dataObj->email_from            = "Genuity";
            $dataObj->email_to              = $data['to_email'];
            $dataObj->email_subject         = $data['email_subject'];
            $dataObj->email_content         = $data['email_content'];
            $dataObj->user_id               = Auth::id();
            $dataObj->log_time              = Carbon::now();
            $dataObj->delivery_time         = Carbon::now();
            $dataObj->send_status           = config('constants.campaign_status')["Failed"];
            $dataObj->save();

            Helper::storeLog("Email send fail to " .$data['to_email'], "Email Module", "Send an Email", "Send Email", $data['lead_id']);

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
        return $sql->orderBy('id', 'DESC')->paginate(config('constants.ROW_PER_PAGE'));
    }

    public function  sendBulkEmailPro($request)
    {
        $request->validate([
            'file' => 'required|file',
            'email_subject' => 'required|string|max:150',
            'email_content' => 'required|string',
        ]);
        $allowedExtensions = ['csv', 'xls', 'xlsx'];
        if (!in_array($request->file('file')->getClientOriginalExtension(), $allowedExtensions)) {
            return (object)[
                'status' => 400,
                'message' => 'The file must be a type of: csv, xlsx, xls.'
            ];
        }
        
        $file = $request->file('file');
        $data = $request->all();
        $emailLogs = [];
        $logs = [];
        try {
            // Check if the file is an Excel file
            if ($file->getClientOriginalExtension() == 'csv') {
                // Process CSV file
                $rows = array_map('str_getcsv', file($file));
            } else {
                // Process Excel file using PhpSpreadsheet
                $spreadsheet = IOFactory::load($file->getPathname());
                $worksheet = $spreadsheet->getActiveSheet();
                $rows = $worksheet->toArray();
            }


            foreach ($rows as $key => $row) {
                if ($key == 0) {
                    continue;
                }

                if (!isset($row[0]) || empty($row[0])) {
                    continue;
                }
        
                Mail::to($row[0])->queue(new BulkEmail($data['email_subject'], $data['email_content']));

                $lead = Lead::where('email', $row[0])
                              ->select('id')
                              ->first();
                $emailLogs[] = [
                    'email_from'    => "Genuity",
                    'email_to'      => $row[0],
                    'lead_id'       => $lead->id ?? null,
                    'email_subject' => $data['email_subject'],
                    'email_content' => $data['email_content'],
                    'log_time'      => Carbon::now(),
                    'delivery_time' => Carbon::now(),
                    'user_id'       => Auth::id(),
                    'send_status'   => config('constants.campaign_status')["Success"]
                ];

                $logs[] = [
                        'log_message'   => "Email send successfully to " .$row[0]." => Email Module  => Send Bulk Email",
                        'module'        => "Email Module",
                        'sub_module'    => "Send Bulk Email",
                        'user_id'       => Auth::id(),
                        'lead_id'       => $lead->id ?? null,
                        'status'        => 1
                ];
            }

            return  DB::transaction(function () use ($emailLogs, $logs) {
                EmailLog::insert($emailLogs);
                Logs::insert($logs);
                return (object)[
                    'status'                 => 201,
                ];
            });

        } catch (\Exception $e) {
            return (object)[
                'status'                 => 401,
                'message'                => $e->getMessage()
            ];
        }
        return (object)[
            'status'                 => 201,
        ];
    }
   

}