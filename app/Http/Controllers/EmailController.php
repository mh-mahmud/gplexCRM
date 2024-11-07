<?php
namespace App\Http\Controllers;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Services\EmailService;
use App\Models\EmailTemplate;


class EmailController extends Controller {

	// public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    protected $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
        // $this->middleware('auth');
    }

	public function emailTemplateList(Request $request)
    {      
        $templates = $this->emailService->emailTemplateList($request);
        return view('emails.template-list', compact('templates'));
    }

    public function templateCreate()
    {       
        return view('emails.template-create');
    }

    public function templateStore(Request $request)
    { 
        $result = $this->emailService->templateStore($request);
        if($result->status == 201){
            return redirect()->route('email-template')->with('success', 'Email template created successfully.');

        }else{
            session()->flash('error', 'Can not Create !');
        }

    }

    public function templateShow($id)
    {
        $template = $this->emailService->getEmailTemplateById($id);
        return view('emails.template-show', compact('template'));
    }

    public function templateEdit($id)
    {
        $template = $this->emailService->getEmailTemplateById($id);
        return view('emails.template-edit', compact('template'));
    }

    public function templateDelete($id)
    {
        $this->emailService->templateDelete($id);
        return redirect()->route('email-template')->with('success', 'Email template deleted successfully.');
    }

    public function templateUpdate(Request $request, $id)
    { 
        $result = $this->emailService->templateUpdate($request, $id);
        
        if($result->status == 208){
            return redirect()->route('email-template')->with('success', 'Email template updated successfully.');

        }else{
            session()->flash('error', 'Can not Update !');
        }

    }

    public function sendEmail(Request $request)
    {   
        $request->merge(['paginate' => false]);   
        $templates = $this->emailService->emailTemplateList($request);
        $leads = Helper::getLeads();
        return view('emails.send-email', compact('templates', 'leads'));
    }

    public function sendEmailPro(Request $request)
    { 
         $result = $this->emailService->sendEmailPro($request);
         if($result->status == 200){
            return redirect()->route('send-email')->with('success', 'Email send successfully.');
        }else{
            session()->flash('error', 'Email can not send !');
        }

    }

    public function sendEmailList(Request $request)
    {      
        $emails = $this->emailService->sendEmailList($request);
        return view('emails.send-email-list', compact('emails'));
    }

    public function sendBulkEmail(Request $request)
    {   
        $request->merge(['paginate' => false]);   
        $templates = $this->emailService->emailTemplateList($request);
        return view('emails.send-bulk-email', compact('templates'));
    }

    public function sendBulkEmailPro(Request $request)
    { 
         $result = $this->emailService->sendBulkEmailPro($request);
         if($result->status == 201) {
            return redirect()->route('send-bulk-email')->with('success', 'Email send successfully.');

        } else if ($result->status == 400) {
            return redirect()->route('send-bulk-email')->withErrors(['file' => $result->message]);
        } else{
            session()->flash('error', 'Email can not send !');
        }

    }

    public function getEmailSendById($id)
    {
        $email = $this->emailService->getEmailSendById($id);
        return view('emails.send-email-show', compact('email'));
    }

    public function sendPendingEmail(Request $request)
    {
        $this->emailService->sendPendingEmail($request);

    }

}