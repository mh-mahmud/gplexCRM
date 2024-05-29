<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EmailService;
use App\Models\EmailTemplate;
use Mail;
use App\Mail\SingleMail;

class EmailController extends Controller {

	// public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    protected $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
        $this->middleware('auth');
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
            return redirect()->route('email-template')->with('success', 'Email template '.$result->messages. ' created successfully.');

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


}