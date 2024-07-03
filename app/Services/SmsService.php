<?php

namespace App\Services;

use App\Models\SmsTemplate;
use App\Models\SmsLog;
use App\Models\SmsQueue;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
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
            return  $sql->orderBy('id', 'DESC')->get();

        } else {
            return  $sql->orderBy('id', 'DESC')->paginate(config('constants.ROW_PER_PAGE'));

        }
    }

    public function templateStore($request)
    {
        $request->validate([
            'title' => 'required|unique:sms_templates|max:100',
            'description' => 'required|max:191',
           
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
        $request->validate([
            'sms_to' => ['required', 'digits:11'],
            'sms_text' => 'required|max:191'
        ],[
            'sms_to.required' => 'Mobile NO is required',
            'sms_to.digits' => 'Mobile NO have to be 11 digits',
            'sms_text.required' => 'Content is required',
            'sms_text.max' => 'Content may not be greater than 191 characters',
        ]);

        // if(empty($request->send_status)) {
        //     $request['send_status'] = 0;
        // }

        // if(empty($request->priority_level)) {
        //     $request['priority_level'] = 5;
        // }
        // $request['log_time'] = date("Y-m-d h:i:s", time());
        $data = $request->all();

        $dataObj                        = new SmsQueue();
        $dataObj->sms_from              = config('constants.SMS_SEND_MOBILE_NO');
        $dataObj->sms_to                = $data['sms_to'];
        $dataObj->sms_text              = $data['sms_text'];
        $dataObj->log_time              = Carbon::now();
        $dataObj->user_id               = Auth::id();  

        try {
            $dataObj->send_status       = 1;
            $dataObj->save();
            
            
        } catch (\Exception $e) {
            $dataObj->send_status       = 0;
            $dataObj->save();
            return (object)[
                'status'                 => 401,
                'message'                => $e->getMessage()
            ];

        }
        return (object)[
            'status'                 => 201,
            'info'                   => $dataObj->id
        ];
	}

    public function sendSMSList($request)
    {
        $sql = SmsQueue::query();
        $data = $request->all();
        if(!empty($data["search"])) {
            $sql->where('sms_to','like', '%' . $data["search"] . '%');

        }
        return $sql->orderBy('id', 'DESC')->paginate(config('constants.ROW_PER_PAGE'));
    }

    public function  sendBulkSmsPro($request)
    {
        $request->validate([
            'file' => 'required|file',
            'sms_text' => 'required|string|max:180'
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

        try {
            if ($file->getClientOriginalExtension() == 'csv') {
                $rows = array_map('str_getcsv', file($file));
            } else {
                $spreadsheet = IOFactory::load($file->getPathname());
                $worksheet = $spreadsheet->getActiveSheet();
                $rows = $worksheet->toArray();
            }

            DB::beginTransaction();

            foreach ($rows as $key => $row) {
                if ($key == 0) {
                    continue;
                }

                if (!isset($row[0]) || empty($row[0])) {
                    continue;
                }

                $dataObj = new SmsQueue();
                $dataObj->sms_from = config('constants.SMS_SEND_MOBILE_NO');
                $dataObj->sms_to = "0".$row[0];
                $dataObj->sms_text = $data['sms_text'];
                $dataObj->log_time = Carbon::now();
                $dataObj->user_id = Auth::id();
                $dataObj->send_status = 1;
                $dataObj->save();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return (object)[
                'status'                 => 401,
                'message'                => $e->getMessage()
            ];
        }

        return (object)[
            'status'                 => 201,
            'info'                   => $dataObj->id
        ];
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