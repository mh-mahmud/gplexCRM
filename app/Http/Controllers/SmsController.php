<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SmsService;
use App\Models\SmsTemplate;
use App\Models\SmsQueue;
use App\Models\SmsLog;

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
        return $this->service->get_all_templates();
    }

    public function sms_template_create(Request $request)
    {
        return $this->service->sms_template_create_service($request);
    }

    public function sms_template_show(string $id)
    {
        return $this->service->sms_template_show_service($id);
    }

    public function sms_template_update(Request $request)
    {
        return $this->service->sms_template_update_service($request);
    }

    public function sms_template_destroy(Request $request)
    {
        return $this->service->sms_template_destroy_service($request);
    }

    public function send_sms(Request $request)
    {
        return $this->service->send_sms_service($request);
    }
}
