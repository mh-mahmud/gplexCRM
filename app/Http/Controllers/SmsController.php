<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SmsService;
use App\Models\smsTemplate;


class smsController extends Controller {

	// public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    protected $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
        $this->middleware('auth');
    }

	public function smsTemplateList(Request $request)
    {      
        $templates = $this->smsService->smsTemplateList($request);
        return view('sms.template-list', compact('templates'));
    }

    public function templateCreate()
    {       
        return view('sms.template-create');
    }

    public function templateStore(Request $request)
    { 
        $result = $this->smsService->templateStore($request);
        if($result->status == 201){
            return redirect()->route('sms-template')->with('success', 'Sms template created successfully.');

        }else{
            session()->flash('error', 'Can not Create !');
        }

    }

    public function templateShow($id)
    {
        $template = $this->smsService->getSmsTemplateById($id);
        return view('sms.template-show', compact('template'));
    }

    public function templateEdit($id)
    {
        $template = $this->smsService->getSmsTemplateById($id);
        return view('sms.template-edit', compact('template'));
    }

    public function templateDelete($id)
    {
        $this->smsService->templateDelete($id);
        return redirect()->route('sms-template')->with('success', 'Sms template deleted successfully.');
    }

    public function templateUpdate(Request $request, $id)
    { 
        $result = $this->smsService->templateUpdate($request, $id);
        
        if($result->status == 208){
            return redirect()->route('sms-template')->with('success', 'Sms template updated successfully.');

        }else{
            session()->flash('error', 'Can not Update !');
        }

    }

    public function sendsms(Request $request)
    {   
        $request->merge(['paginate' => false]);   
        $templates = $this->smsService->smsTemplateList($request);
        return view('sms.send-sms', compact('templates'));
    }

    public function sendsmsPro(Request $request)
    { 
         $result = $this->smsService->sendsmsPro($request);
         if($result->status == 200){
            return redirect()->route('send-sms')->with('success', 'sms send successfully.');

        }else{
            session()->flash('error', 'sms can not send !');
        }

    }

    public function sendsmsList(Request $request)
    {      
        $sms = $this->smsService->sendsmsList($request);
        return view('sms.send-sms-list', compact('sms'));
    }
}